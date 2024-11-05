<?php

namespace App\View\Components;

use App\Enums\InputTypesEnum;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string          $name,
        public string          $label,
        public string|int|null $value = '',
        public InputTypesEnum  $type = InputTypesEnum::Text,
        public bool            $required = false,
        public string|null     $id = null
    )
    {
        if (empty($this->id)) {
            $this->id = $this->name;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input', [
            'old' => preg_replace('/\[(.*?)\]/', '.$1', $this->name),
        ]);
    }
}
