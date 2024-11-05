<?php

namespace App\Http\Requests\Admin\Section;

use App\Enums\ImageSizeEnum;
use App\Helpers\ValidationHelper;

class SectionRequest
{
    public static function getRules(string $page): array
    {
        $rulesByPages = [
            'home' => [
                'section-1' => 'required|array',
                'section-1.title' => 'required|array',
                'section-1.title.ru' => 'nullable|string',
                'section-1.title.uz' => 'nullable|string',
                'section-1.title.en' => 'nullable|string',
                'section-1.preview_image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::High->value,
                'section-1.media_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4|max:' . ImageSizeEnum::Max->value,
                'about' => 'required|array',
                ...ValidationHelper::localized('about.title'),
                ...ValidationHelper::localized('about.description'),
                'about.items' => 'required|array|min:1',
                ...ValidationHelper::localized('about.items.*.title'),
                ...ValidationHelper::localized('about.items.*.description'),
                'about.items.*.icon' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::Small->value,
                'form' => 'required|array',
                ...ValidationHelper::localized('form.title'),
                ...ValidationHelper::localized('form.description'),
            ],
            'about' => [
                'section-1' => 'nullable|array',
                'section-1.image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:' . ImageSizeEnum::Max->value,
                'mission' => 'required|array',
                ...ValidationHelper::localized('mission.title'),
                'who-we-are' => 'required|array',
                ...ValidationHelper::localized('who-we-are.title'),
                ...ValidationHelper::localized('who-we-are.description'),
            ],
            'contacts' => [
                ...ValidationHelper::localized('address'),
                'phone' => 'required|string',
                'email' => 'required|email',
                'socials' => 'required|array',
                'socials.*.icon' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:' . ImageSizeEnum::Small->value,
                'socials.*.link' => 'required|string',
                'location' => 'required|array',
                'location.lat' => 'required|numeric',
                'location.lng' => 'required|numeric',
            ]
        ];

        return $rulesByPages[$page] ?? [];
    }

    public static function getUploadInfo(string $page): array
    {
        $info = [
            'home' => [
                'section-1' => [
                    'preview_image' => [1920],
                    'media_file' => [2560],
                ],
                'about' => [
                    'items' => [
                        'icon' => [200],
                    ]
                ]
            ],
            'about' => [
                'section-1' => [
                    'image' => [1920],
                ]
            ],
            'contacts' => [
                'socials' => [
                    'icon' => [50]
                ]
            ]
        ];

        return $info[$page] ?? [];
    }
}
