<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string      $name,
        public string      $label,
        public string|null $value = '',
        public string $id = '',
        public bool   $required = false
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
        return view('components.textarea', [
            'old' => preg_replace('/\[(.*?)\]/', '.$1', $this->name),
        ]);
    }
}
