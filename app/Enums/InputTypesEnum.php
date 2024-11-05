<?php

namespace App\Enums;

enum InputTypesEnum: string
{
    case Text = 'text';
    case Number = 'number';
    case Email = 'email';
}
