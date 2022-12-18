<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'org_url',
        'gen_url',
        'gen_code',
        'status',
        'project_id'
    ];

    public function urlProject()
    {
     return $this->belongsTo(UrlProject::class,'project_id');
    }
}
