<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UrlProject extends Model
{
    use HasFactory;
    public $timestamps = false;

    
    protected $fillable = [
        'name',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($urlproject) {
            $urlproject->user_id = Auth::id();
        });
    }
}
