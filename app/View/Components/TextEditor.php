<?php

namespace App\View\Components;

use App\Helpers\ArrayHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextEditor extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string      $name,
        public string      $label,
        public string|null $value = '',
        public string      $id = '',
        public bool        $required = false,
        public array       $toolbar = []
    )
    {
        if (empty($this->id)) {
            $this->id = $this->name;
        }

        $this->id = ArrayHelper::arrayStringToDot($this->id, '-');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.text-editor', [
            'old' => preg_replace('/\[(.*?)\]/', '.$1', $this->name),
        ]);
    }
}
