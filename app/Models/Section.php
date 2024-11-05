<?php

namespace App\Models;

use App\Casts\ContentCast;
use App\Traits\DateSerializer;
use Illuminate\Database\Eloquent\Model;

/**
 * @property array $content
 */
class Section extends Model
{
    use DateSerializer;

    protected $guarded = ['id'];

    protected $casts = [
        'content' => ContentCast::class
    ];
}
