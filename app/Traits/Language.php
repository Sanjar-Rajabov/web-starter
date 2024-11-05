<?php

namespace App\Traits;

trait Language
{
    public function translate(string $column): ?string
    {
        return $this->{$column}->{$this->lang()} ?? null;
    }

    /**
     * Returns Accept-Language header.
     */
    protected function lang(): string
    {
        $lang = request()->header('Accept-Language', 'ru');
        return in_array($lang, ['uz', 'ru', 'en']) ? $lang : 'ru';
    }
}
