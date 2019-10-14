<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Patient extends Model
{
    use HasApiTokens;
    protected $fillable = [
        'name', 'age',
    ];
}
