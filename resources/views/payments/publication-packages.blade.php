@extends('layouts.app')

@section('title', 'اختيار باقة النشر')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- رأس الصفحة -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">اختر باقة النشر لعقارك</h1>
            <p class="text-gray-600">يجب دفع رسوم النشر قبل عرض عقارك للجمهور</p>
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

        <!-- الباقات -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($packages as $key => $package)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="bg-blue-600 text-white p-4">
                    <h3 class="text-lg font-semibold">{{ $package['name'] }}</h3>
                    <div class="text-2xl font-bold">{{ $package['price'] }} MAD</div>
                    <div class="text-sm opacity-90">لمدة {{ $package['duration'] }} يوم</div>
                </div>

                <div class="p-4">
                    <ul class="space-y-2 mb-4">
                        @foreach($package['features'] as $feature)
                        <li class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>

                    <form action="{{ route('payment.create', $bien->id_bien) }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_type" value="{{ $key }}">
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200">
                            اختر هذه الباقة
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- معلومات إضافية -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">معلومات مهمة</h3>
            <ul class="space-y-2 text-sm text-gray-700">
                <li>• يمكنك دفع الرسوم عبر البطاقة الائتمانية أو التحويل البنكي</li>
                <li>• سيتم نشر عقارك فوراً بعد تأكيد الدفع</li>
                <li>• يمكنك إدارة مدة النشر من لوحة التحكم الخاصة بك</li>
                <li>• في حالة وجود مشكلة، يمكنك التواصل معنا</li>
            </ul>
        </div>
    </div>
</div>
@endsection
