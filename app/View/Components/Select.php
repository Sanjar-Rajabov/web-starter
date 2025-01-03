<?php

namespace App\View\Components;

use App\Helpers\ArrayHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string      $name,
        public string      $label,
        public array       $options,
        public mixed       $value = null,
        public bool        $required = false,
        public string|null $id = null
    )
    {
        if (empty($this->id)) {
            $this->id = ArrayHelper::arrayStringToDot($this->name, '-');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
