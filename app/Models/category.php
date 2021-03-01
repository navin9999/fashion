<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

      protected $fillable = [
        'name',
        'slug',
        'description',
        'cover',
        'status',
        'parent_id',
        'user_id',
        'is_featured',
        'is_top'
    ];
public function childs() {
        return $this->hasMany('App\Models\category','parent_id','id') ;
    }
}
