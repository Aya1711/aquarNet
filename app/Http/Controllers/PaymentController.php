<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Payment;
use App\Services\PricingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * الخطوة 1: عرض باقات النشر
     */
    public function showPublicationPackages($bienId)
    {
        $bien = Bien::where('id_bien', $bienId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        if ($bien->isPaid()) {
            return redirect()->route('properties.show', $bien->id_bien)
                ->with('success', 'تم دفع رسوم النشر مسبقاً.');
        }

        $packages = PricingService::getPublicationPrices();

        return view('payments.publication-packages', compact('bien', 'packages'));
    }

    /**
     * الخطوة 2: إنشاء طلب دفع
     */
    public function createPayment(Request $request, $bienId)
    {
        $request->validate([
            'package_type' => 'required|in:basic,featured,urgent,package'
        ]);

        $bien = Bien::where('id_bien', $bienId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        // التأكد من عدم وجود دفعة سابقة
        $existingPayment = Payment::where('bien_id', $bienId)
                                ->where('statut', 'en_attente')
                                ->first();

        if ($existingPayment) {
            return redirect()->route('payment.process', $existingPayment->id_paiement);
        }

        // إنشاء دفعة جديدة
        $payment = Payment::create([
            'user_id' => Auth::id(),
            'bien_id' => $bienId,
            'montant' => PricingService::calculatePrice($request->package_type),
            'type' => 'publication',
            'statut' => 'en_attente',
            'details' => json_encode([
                'package_type' => $request->package_type,
                'package_name' => PricingService::getPriceDetails($request->package_type)['name'],
                'duration' => PricingService::getDuration($request->package_type),
                'features' => PricingService::getPriceDetails($request->package_type)['features']
            ])
        ]);

        return redirect()->route('payment.process', $payment->id_paiement);
    }

    /**
     * الخطوة 3: معالجة الدفع
     */
    public function processPayment($paymentId)
    {
        $payment = Payment::where('id_paiement', $paymentId)
                         ->where('user_id', Auth::id())
                         ->where('statut', 'en_attente')
                         ->firstOrFail();

        $bien = $payment->bien;
        $packageDetails = json_decode($payment->details, true);

        return view('payments.process', compact('payment', 'bien', 'packageDetails'));
    }

    /**
     * الخطوة 4: محاكاة نجاح الدفع (للتطوير)
     */
    public function simulateSuccess($paymentId)
    {
        $payment = Payment::where('id_paiement', $paymentId)
                         ->where('user_id', Auth::id())
                         ->where('statut', 'en_attente')
                         ->firstOrFail();

        // تحديث حالة الدفع
        $payment->markAsPaid('carte', 'SIM_' . uniqid());

        // تحديث حالة العقار
        $packageDetails = json_decode($payment->details, true);
        $duration = $packageDetails['duration'] ?? 30;

        $updates = [
            'statut' => 'disponible',
            'payment_status' => 'paid'
        ];

        // إضافة ميزات إضافية حسب الباقة
        if (in_array($packageDetails['package_type'], ['featured', 'package'])) {
            $updates['featured_until'] = now()->addDays($duration);
        }

        if (in_array($packageDetails['package_type'], ['urgent', 'package'])) {
            $updates['urgent_until'] = now()->addDays($duration);
        }

        $payment->bien->update($updates);

        return redirect()->route('properties.show', $payment->bien_id)
            ->with('success', 'تم الدفع بنجاح ونشر العقار!');
    }

    /**
     * محاكاة فشل الدفع
     */
    public function simulateFailure($paymentId)
    {
        $payment = Payment::where('id_paiement', $paymentId)
                         ->where('user_id', Auth::id())
                         ->where('statut', 'en_attente')
                         ->firstOrFail();

        $payment->update(['statut' => 'echoue']);

        return redirect()->route('payment.packages', $payment->bien_id)
            ->with('error', 'فشل عملية الدفع. يرجى المحاولة مرة أخرى.');
    }

    /**
     * تاريخ المدفوعات
     */
    public function paymentHistory()
    {
        $payments = Payment::with('bien')
                          ->where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        return view('payments.history', compact('payments'));
    }
}