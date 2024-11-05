<?php

namespace App\Models;

use App\Traits\DateSerializer;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use DateSerializer;

    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array'
    ];
}
