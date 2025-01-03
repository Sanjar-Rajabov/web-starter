<?php

namespace App\View\Components;

use App\DTO\FormListItem;
use App\Helpers\ArrayHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormList extends Component
{
    /**
     * @param string $name
     * @param FormListItem[] $items
     * @param array $values
     * @param string $id
     * @param bool $dynamic
     * @param int|null $min
     * @param int|null $max
     * @param bool $draggable
     */
    public function __construct(
        public string   $name,
        public array    $items,
        public array    $values,
        public string   $id = '',
        public bool     $dynamic = true,
        public int|null $min = null,
        public int|null $max = null,
        public bool     $draggable = false
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
        return view('components.form-list');
    }
}
