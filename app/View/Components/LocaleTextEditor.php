<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LocaleTextEditor extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string     $name,
        public string     $label,
        public array|null $value = [],
        public string     $id = '',
        public bool       $required = false,
        public array       $toolbar = []
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
        return view('components.locale-text-editor');
    }
}
