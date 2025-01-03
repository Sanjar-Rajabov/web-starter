<?php

namespace App\Enums;

enum InputTypesEnum: string
{
    case Text = 'text';
    case Number = 'number';
    case Email = 'email';
    case Color = 'color';
    case Date = 'date';
}
