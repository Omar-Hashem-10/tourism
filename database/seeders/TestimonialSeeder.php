<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'أحمد محمد',   'rating' => 5, 'review' => 'تجربة رائعة جداً! الرحلة إلى الغردقة كانت أكثر من رائعة، الفندق ممتاز والخدمة احترافية.'],
            ['name' => 'مي السيد',    'rating' => 5, 'review' => 'سافرنا كعائلة إلى الأقصر وأسوان وكانت رحلة لا تُنسى، الأطفال أحبوها جداً وشعرنا بالتاريخ المصري العريق.'],
            ['name' => 'كريم علي',    'rating' => 5, 'review' => 'حجزت رحلة تركيا وكان كل شيء مرتب بشكل احترافي من الفندق للجولات. سأحجز مرة ثانية بالتأكيد.'],
            ['name' => 'سارة حسن',   'rating' => 4, 'review' => 'رحلة بالي كانت حلماً أصبح حقيقة، الطبيعة الخلابة والمعابد الجميلة، شكراً رحلاتي!'],
            ['name' => 'عمر خالد',   'rating' => 5, 'review' => 'أفضل خدمة وأفضل أسعار، رحلة دبي كانت ممتازة وسيكون رحلاتي هو خياري دائماً للسفر.'],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['name' => $t['name']], array_merge($t, ['is_active' => true]));
        }
    }
}
