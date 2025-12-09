@extends('layouts.app')

@section('title', 'معالجة الدفع')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- رأس الصفحة -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">معالجة الدفع</h1>
            <p class="text-gray-600">يرجى تأكيد معلومات الدفع والمتابعة</p>
        </div>

        <!-- معلومات الدفع -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-6">تفاصيل الدفع</h2>

            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">الباقة:</span>
                    <span class="font-medium">{{ $packageDetails['package_name'] ?? 'غير محدد' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">المبلغ:</span>
                    <span class="font-medium text-lg">{{ $payment->montant }} MAD</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">مدة النشر:</span>
                    <span class="font-medium">{{ $packageDetails['duration'] }} يوم</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">حالة الدفع:</span>
                    <span class="font-medium text-orange-600">{{ $payment->statut_label }}</span>
                </div>
            </div>
        </div>

        <!-- معلومات العقار -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">معلومات العقار</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">العنوان</p>
                    <p class="font-medium">{{ $bien->titre }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">النوع</p>
                    <p class="font-medium">{{ $bien->type_label }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">الفئة</p>
                    <p class="font-medium">{{ $bien->categorie_label }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">المدينة</p>
                    <p class="font-medium">{{ $bien->ville }}</p>
                </div>
            </div>
        </div>

        <!-- نموذج الدفع -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6">معلومات الدفع</h2>

            <form action="{{ route('payment.success', $payment->id_paiement) }}" method="GET" class="space-y-6">

                <!-- معلومات البطاقة -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">
                            رقم البطاقة
                        </label>
                        <input type="text" id="card_number" name="card_number"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="1234 5678 9012 3456" required>
                    </div>

                    <div>
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">
                            تاريخ الانتهاء
                        </label>
                        <input type="text" id="expiry_date" name="expiry_date"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="MM/YY" required>
                    </div>

                    <div>
                        <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">
                            CVV
                        </label>
                        <input type="text" id="cvv" name="cvv"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="123" required>
                    </div>

                    <div>
                        <label for="card_holder" class="block text-sm font-medium text-gray-700 mb-1">
                            اسم صاحب البطاقة
                        </label>
                        <input type="text" id="card_holder" name="card_holder"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="الاسم الكامل" required>
                    </div>
                </div>

                <!-- أزرار التحكم -->
                <div class="flex space-x-4 space-x-reverse">
                    <button type="submit" class="flex-1 bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 transition-colors duration-200 font-medium">
                        تأكيد الدفع
                    </button>

                    <a href="{{ route('payment.packages', $bien->id_bien) }}" class="flex-1 bg-gray-500 text-white py-3 px-4 rounded-md hover:bg-gray-600 transition-colors duration-200 font-medium text-center">
                        العودة للباقات
                    </a>
                </div>
            </form>

            <!-- روابط تجريبية للتطوير -->
            @if(app()->environment('local'))
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-3">روابط تجريبية (للتطوير فقط):</h3>
                <div class="flex space-x-2 space-x-reverse">
                    <a href="{{ route('payment.success', $payment->id_paiement) }}" class="bg-green-500 text-white px-4 py-2 rounded text-sm hover:bg-green-600">
                        محاكاة نجاح الدفع
                    </a>
                    <a href="{{ route('payment.failure', $payment->id_paiement) }}" class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600">
                        محاكاة فشل الدفع
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- معلومات الأمان -->
        <div class="bg-gray-50 rounded-lg p-4 mt-6">
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                </svg>
                جميع المعاملات محمية بتشفير SSL 256-bit
            </div>
        </div>
    </div>
</div>

<script>
// تنسيق رقم البطاقة
document.getElementById('card_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
    let formattedValue = value.replace(/(.{4})/g, '$1 ').trim();
    e.target.value = formattedValue;
});

// تنسيق تاريخ الانتهاء
document.getElementById('expiry_date').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});

// تحديد CVV
document.getElementById('cvv').addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
});
</script>
@endsection
