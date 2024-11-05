<?php

namespace Database\Seeders;

use App\Helpers\LocaleHelper;
use App\Models\Section;
use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::query()->create([
            'name' => 'contacts',
            'content' => self::getContent()
        ]);
    }

    /**
     * @return array
     */
    public static function getContent(): array
    {
        return [
            'address' => LocaleHelper::localize('Ташкент Алмазарский р-н ул.камарнисо 13'),
            'phone' => '+998 (99) 000-00-00',
            'email' => 'info@primeoutdoor.uz',
            'location' => [
                'lat' => 41.311,
                'lng' => 69.240
            ],
            'socials' => [
                [
                    'icon' => 'uploads/sections/contacts/1.png',
                    'link' => '#'
                ],
                [
                    'icon' => 'uploads/sections/contacts/1.png',
                    'link' => '#'
                ],
                [
                    'icon' => 'uploads/sections/contacts/1.png',
                    'link' => '#'
                ],
            ],
            'form' => [
                'title' => LocaleHelper::localize('Свяжитесь с нами для размещения <b>рекламы <br>по всему городу</b>')
            ]
        ];
    }
}
