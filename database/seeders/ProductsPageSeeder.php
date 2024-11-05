<?php

namespace Database\Seeders;

use App\Helpers\LocaleHelper;
use App\Models\Section;
use Illuminate\Database\Seeder;

class ProductsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::query()->create([
            'name' => 'products',
            'content' => self::getContent()
        ]);
    }

    public static function getContent(): array
    {
        return [
            'section-1' => [
                'title' => LocaleHelper::localize('Установка и размещение наружной рекламы: <b>от билбордов до цифровых экранов</b>')
            ],
            'form' => [
                'title' => LocaleHelper::localize('<b>Давайте обсудим</b> вашу самую смелую идею!'),
                'description' => LocaleHelper::localize('После отправки вашей заявки, мы оперативно свяжемся с вами и обсудим проект.'),
            ]
        ];
    }
}
