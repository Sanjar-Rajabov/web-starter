<?php

namespace App\View\Components;

use App\Enums\ImageInputTypesEnum;
use App\Enums\ImageSizeEnum;
use App\Helpers\ArrayHelper;
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
        public bool          $required = false,
        public bool          $deletable = false,
        public ImageSizeEnum $size = ImageSizeEnum::Small,
        public string        $id = ''
    )
    {
        if (empty($this->id)) {
            $this->id = ArrayHelper::arrayStringToDot($name, '-');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-input', [
            'size-info' => "(Макс: {$this->size->getMB()} MB|{$this->size->getResolution()})"
        ]);
    }
}
