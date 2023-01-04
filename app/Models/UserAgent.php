<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAgent extends Model
{
    use HasFactory;
    protected $fillable = [
        'browser',
        'device',
        'region_id',
        'counts'
    ];
}
