<?php

namespace App\Models;

use App\Models\Interfaces\HasRelationsInterface;
use App\Models\Interfaces\SafelySaveInterface;
use App\Traits\DateSerializer;
use App\Traits\HasRelation;
use App\Traits\SafelySave;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $login
 */
class User extends Authenticatable implements SafelySaveInterface, HasRelationsInterface
{
    use SafelySave, HasRelation, HasFactory, DateSerializer;

    protected $guarded = ['id'];

    protected $hidden = [
        'password'
    ];
}
