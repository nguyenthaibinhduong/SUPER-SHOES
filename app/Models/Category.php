<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'name',
        'parent_id'
    ];
    public function categoryChildren(){
        return $this->hasMany(Category::class,'parent_id');
    }

    
}
