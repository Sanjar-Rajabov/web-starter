<?php

namespace App\Postman\Enum;

enum PostmanBodyModeEnum: string
{
    case RAW = 'raw';
    case FORMDATA = 'formdata';
}
