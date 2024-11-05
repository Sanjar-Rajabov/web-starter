<?php

namespace App\View\Components;

use App\Enums\ImageInputTypesEnum;
use App\Enums\ImageSizeEnum;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string              $name,
        public string              $label,
        public ImageInputTypesEnum $type = ImageInputTypesEnum::Image,
        public string|null         $value = '',
        public bool $required = false,
        public ImageSizeEnum       $size = ImageSizeEnum::Small
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-input');
    }
}
