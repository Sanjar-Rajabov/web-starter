<?php

namespace App\DTO;

use App\Enums\FieldTypesEnum;
use App\Enums\ImageInputTypesEnum;
use App\Enums\ImageSizeEnum;

class FormListItem
{
    public function __construct(
        public FieldTypesEnum      $type,
        public string              $name,
        public string              $label,
        public string              $id = '',
        public bool                $required = false,
        public ImageSizeEnum       $size = ImageSizeEnum::Small,
        public ImageInputTypesEnum $imageType = ImageInputTypesEnum::Image,
        public bool                $imageIsDeletable = false
    )
    {
        if (empty($this->id)) {
            $this->id = $this->name;
        }
    }

    public function toJson(): bool|string
    {
        return json_encode($this->toArray());
    }

    public function toArray(): array
    {
        $type = $this->type->name;
        if (in_array($this->type, [FieldTypesEnum::ImageInput, FieldTypesEnum::LocaleImage]) && $this->imageIsDeletable) {
            $type .= 'Deletable';
        }

        return [
            'type' => $type,
            'name' => $this->name,
            'label' => $this->label,
            'id' => $this->id
        ];
    }
}
