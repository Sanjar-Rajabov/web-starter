<?php

namespace Database\Factories;

use App\Enums\ProductTypeEnum;
use App\Helpers\LocaleHelper;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;
        $type = $this->faker->randomElement(array_map(fn($enum) => $enum->value, ProductTypeEnum::cases()));
        return [
            'name' => LocaleHelper::localize($name),
            'image' => 'uploads/products/' . Str::random(20) . '.jpg',
            'type' => $type,
            'content' => $this->getContent($type),
            'category_id' => $this->faker->numberBetween(1, 5),
            'is_published' => $this->faker->boolean(90),
            'show_on_home_page' => $this->faker->boolean(60),
            'position' => $this->faker->numberBetween(1, 25)
        ];
    }

    public function getContent(string $type): array
    {
        $items = [
            [
                'title' => LocaleHelper::localize($this->faker->word())
            ],
            [
                'title' => LocaleHelper::localize($this->faker->word())
            ]
        ];
        $advantages = [
            'active' => $this->faker->boolean(60),
            'items' => [
                [
                    'title' => LocaleHelper::localize($this->faker->word())
                ],
                [
                    'title' => LocaleHelper::localize($this->faker->word())
                ],
                [
                    'title' => LocaleHelper::localize($this->faker->word())
                ],
                [
                    'title' => LocaleHelper::localize($this->faker->word())
                ],
            ]
        ];
        $slider = [
            'active' => $this->faker->boolean(90),
            'title' => LocaleHelper::localize($this->faker->words(asText: true)),
            'items' => [
                [
                    'image' => 'uploads/products/' . Str::random(20) . '.jpg',
                    'description' => LocaleHelper::localize($this->faker->words(asText: true))
                ],
                [
                    'image' => 'uploads/products/' . Str::random(20) . '.jpg',
                    'description' => LocaleHelper::localize($this->faker->words(asText: true))
                ],
                [
                    'image' => 'uploads/products/' . Str::random(20) . '.jpg',
                    'description' => LocaleHelper::localize($this->faker->words(asText: true))
                ],
            ]
        ];
        return match ($type) {
            ProductTypeEnum::Type1->value => [
                'file' => 'uploads/products/' . Str::random(20) . '.pdf',
                'title' => LocaleHelper::localize($this->faker->title),
                'description' => LocaleHelper::localize($this->faker->words(asText: true)),
                'items' => $items,
                'routes' => [
                    'active' => $this->faker->boolean(30),
                    'items' => [
                        [
                            'title' => LocaleHelper::localize($this->faker->word())
                        ],
                        [
                            'title' => LocaleHelper::localize($this->faker->word())
                        ],
                    ]
                ],
                'advantages' => $advantages,
                'slider' => $slider
            ],
            ProductTypeEnum::Type2->value => [
                'file' => 'uploads/products/' . Str::random(20) . '.pdf',
                'title' => LocaleHelper::localize($this->faker->title),
                'items' => $items,
                'advantages' => $advantages,
                'description' => LocaleHelper::localize($this->faker->words(asText: true)),
                'slider' => $slider
            ],
            ProductTypeEnum::SuperFormat->value => [
                'items' => [
                    [
                        'image' => 'uploads/products/' . Str::random(20) . '.jpg',
                        'description' => LocaleHelper::localize($this->faker->words(asText: true))
                    ],
                    [
                        'image' => 'uploads/products/' . Str::random(20) . '.jpg',
                        'description' => LocaleHelper::localize($this->faker->words(asText: true))
                    ],
                    [
                        'image' => 'uploads/products/' . Str::random(20) . '.jpg',
                        'description' => LocaleHelper::localize($this->faker->words(asText: true))
                    ],
                ]
            ]
        };
    }

    public function type(ProductTypeEnum $type): ProductFactory|Factory
    {
        return $this->state(function (array $attributes) use ($type) {
            return [
                'type' => $type->value,
                'content' => $this->getContent($type->value)
            ];
        });
    }
}
