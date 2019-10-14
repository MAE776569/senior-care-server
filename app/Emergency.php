<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
class Emergency extends Model
{
    use HasApiTokens;
    protected $fillable = [
        'patient_id', 'type',
    ];
    public $table = 'emergency';
}
