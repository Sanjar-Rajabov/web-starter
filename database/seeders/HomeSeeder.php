<?php

namespace Database\Seeders;

use App\Helpers\LocaleHelper;
use App\Models\Section;
use Illuminate\Database\Seeder;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::query()->create([
            'name' => 'home',
            'content' => self::getContent()
        ]);
    }

    public static function getContent(): array
    {

        return [
            'section-1' => [
                'title' => LocaleHelper::localize('Установка наружной рекламы по всему Узбекистану'),
                'preview_image' => 'uploads/sections/main/1.jpg',
                'media_file' => 'uploads/sections/main/1.jpg',
                'media_file_type' => 'image'
            ],
            'about' => [
                'title' => LocaleHelper::localize('Наружная реклама, которая делает ваш <b>бизнес видимым каждому</b>'),
                'description' => LocaleHelper::localize("Мы занимаемся установкой и размещением наружной рекламы в местах с высоким трафиком, обеспечивая бизнесу видимость и максимальный охват аудитории через яркие и заметные рекламные конструкции.\nНаши решения помогают брендам стать видимыми для тысяч людей каждый день, обеспечивая максимальный охват аудитории и эффективную коммуникацию с потенциальными клиентами."),
                'items' => [
                    [
                        'icon' => 'uploads/sections/home/1.png',
                        'title' => LocaleHelper::localize('200+'),
                        'description' => LocaleHelper::localize('Более 200 поверхностей')
                    ],
                    [
                        'icon' => 'uploads/sections/home/1.png',
                        'title' => LocaleHelper::localize('500 000'),
                        'description' => LocaleHelper::localize('Охват рекламы за месяц')
                    ],
                    [
                        'icon' => 'uploads/sections/home/1.png',
                        'title' => LocaleHelper::localize('18'),
                        'description' => LocaleHelper::localize('Более 18 лет опыта')
                    ],
                    [
                        'icon' => 'uploads/sections/home/1.png',
                        'title' => LocaleHelper::localize('16'),
                        'description' => LocaleHelper::localize('городов по Узбекистану')
                    ]
                ]
            ],
            'form' => [
                'title' => LocaleHelper::localize('<b>Давайте обсудим</b> вашу самую смелую идею!'),
                'description' => LocaleHelper::localize('После отправки вашей заявки, мы оперативно свяжемся с вами и обсудим проект.'),
            ]
        ];
    }
}
