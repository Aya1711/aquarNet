<?php
// app/Services/PricingService.php

namespace App\Services;

class PricingService
{
    const PUBLICATION_BASIC = 50.00;
    const PUBLICATION_FEATURED = 100.00;
    const PUBLICATION_URGENT = 75.00;
    const PUBLICATION_PACKAGE = 150.00;

    public static function getPublicationPrices()
    {
        return [
            'basic' => [
                'name' => 'النشر العادي',
                'price' => self::PUBLICATION_BASIC,
                'duration' => 30,
                'features' => [
                    'النشر لمدة 30 يوم',
                    'ظهور في نتائج البحث',
                    '3 صور للعقار'
                ]
            ],
            'featured' => [
                'name' => 'نشر مميز',
                'price' => self::PUBLICATION_FEATURED,
                'duration' => 30,
                'features' => [
                    'كل ميزات النشر العادي',
                    'ظهور في القسم المميز',
                    'ترتيب متقدم في البحث',
                    'تمييز بلون مختلف'
                ]
            ],
            'urgent' => [
                'name' => 'نشر عاجل',
                'price' => self::PUBLICATION_URGENT,
                'duration' => 15,
                'features' => [
                    'كل ميزات النشر العادي',
                    'علامة "عاجل" على العقار',
                    'أولوية في العرض',
                    'إشعارات للمهتمين'
                ]
            ],
            'package' => [
                'name' => 'الباقة الشاملة',
                'price' => self::PUBLICATION_PACKAGE,
                'duration' => 60,
                'features' => [
                    'كل الميزات السابقة',
                    'النشر لمدة 60 يوم',
                    '10 صور للعقار',
                    'دعم فني متميز'
                ]
            ]
        ];
    }

    public static function calculatePrice($type)
    {
        $prices = self::getPublicationPrices();
        return $prices[$type]['price'] ?? self::PUBLICATION_BASIC;
    }

    public static function getPriceDetails($type)
    {
        return self::getPublicationPrices()[$type] ?? self::getPublicationPrices()['basic'];
    }

    public static function getDuration($type)
    {
        $details = self::getPriceDetails($type);
        return $details['duration'] ?? 30;
    }
}