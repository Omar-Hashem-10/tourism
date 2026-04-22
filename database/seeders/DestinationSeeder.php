<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            [
                'name'        => ['ar' => 'الغردقة',        'en' => 'Hurghada'],
                'description' => [
                    'ar' => 'مدينة ساحلية رائعة على البحر الأحمر، مشهورة بشعابها المرجانية وشواطئها الذهبية ورياضات الغوص والسنوركل.',
                    'en' => 'A stunning coastal city on the Red Sea, famous for its coral reefs, golden beaches, and world-class diving.',
                ],
                'category'    => 'beach',
                'is_featured' => true,
                'sort_order'  => 1,
            ],
            [
                'name'        => ['ar' => 'شرم الشيخ',      'en' => 'Sharm El-Sheikh'],
                'description' => [
                    'ar' => 'جنة الشعاب المرجانية والمنتجعات الفاخرة بين جبال سيناء وأزرق البحر الأحمر.',
                    'en' => 'Paradise of coral reefs and luxury resorts nestled between the Sinai mountains and the Red Sea.',
                ],
                'category'    => 'beach',
                'is_featured' => true,
                'sort_order'  => 2,
            ],
            [
                'name'        => ['ar' => 'الأقصر وأسوان',  'en' => 'Luxor & Aswan'],
                'description' => [
                    'ar' => 'معابد الفراعنة ووادي الملوك الأسطوري والإبحار على النيل بين الحضارات.',
                    'en' => 'Pharaonic temples, the Valley of the Kings, and Nile cruises between ancient civilizations.',
                ],
                'category'    => 'heritage',
                'is_featured' => true,
                'sort_order'  => 3,
            ],
            [
                'name'        => ['ar' => 'القاهرة',         'en' => 'Cairo'],
                'description' => [
                    'ar' => 'قلب مصر النابض بين الأهرامات والمتحف المصري وأزقة الحي الإسلامي العريق.',
                    'en' => 'The beating heart of Egypt between the Pyramids, the Egyptian Museum, and the ancient Islamic Quarter.',
                ],
                'category'    => 'culture',
                'is_featured' => true,
                'sort_order'  => 4,
            ],
            [
                'name'        => ['ar' => 'مرسى مطروح',      'en' => 'Marsa Matrouh'],
                'description' => [
                    'ar' => 'أنقى شواطئ البحر المتوسط بمياهه الفيروزية الشفافة ورماله الناصعة البياض.',
                    'en' => "The Mediterranean's purest beaches with crystal-clear turquoise waters and pristine white sands.",
                ],
                'category'    => 'beach',
                'is_featured' => false,
                'sort_order'  => 5,
            ],
            [
                'name'        => ['ar' => 'سيناء',            'en' => 'Sinai'],
                'description' => [
                    'ar' => 'جبال سيناء الشاهقة وجبل موسى المقدس وشواطئ العقبة الرائعة.',
                    'en' => 'The towering Sinai mountains, sacred Mount Moses, and the stunning Gulf of Aqaba beaches.',
                ],
                'category'    => 'adventure',
                'is_featured' => false,
                'sort_order'  => 6,
            ],
        ];

        foreach ($destinations as $dest) {
            Destination::firstOrCreate(
                ['sort_order' => $dest['sort_order']],
                $dest
            );
        }
    }
}
