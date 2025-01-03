<?php

namespace App\View\Components;

use App\Enums\DropdownItemTypeEnum;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropdownItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string               $href,
        public string               $icon = 'circle',
        public DropdownItemTypeEnum $type = DropdownItemTypeEnum::Default
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown-item');
    }
}
