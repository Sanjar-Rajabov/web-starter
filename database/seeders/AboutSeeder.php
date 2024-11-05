<?php

namespace Database\Seeders;

use App\Helpers\LocaleHelper;
use App\Models\Section;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::query()->create([
            'name' => 'about',
            'content' => self::getContent()
        ]);
    }

    /**
     * @return array
     */
    public static function getContent(): array
    {
        return [
            'section-1' => [
                'image' => 'uploads/sections/about/1.jpg'
            ],
            'mission' => [
                'title' => LocaleHelper::localize('<b>Инновационный подход <br>к продвижению брендов</b> <br>с помощью наружной рекламы'),
            ],
            'who-we-are' => [
                'title' => LocaleHelper::localize('Prime - ведущая компания в Узбекистане которая помогает нашим партнерам и клиентам заявить себя с помощью ооһ рекламы'),
                'description' => LocaleHelper::localize("Prime компания, основанная в 2006 году в Узбекистане, специализирующаяся на наружной рекламе. Мы предлагаем широкий спектр рекламных продуктов, включая outdoor-рекламу, рекламу в метро, на железной дороге, автобусах, торговых и бизнес центрах.\nНаша компания стремится предоставлять клиентам инновационные и эффективные рекламные решения, помогая им укреплять свои бренды и привлекать аудиторию. Мы гордимся нашей репутацией надежного партнера и стремимся к постоянному развитию и совершенствованию наших услуг."),
            ]
        ];
    }
}
