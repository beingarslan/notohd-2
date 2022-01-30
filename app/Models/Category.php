<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'id',
        'title',
        'description',
        'slug',
        'image',
        'parent_id',
        'status',
    ];


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function child(){
        return $this->hasMany(Category::class, 'parent_id');
    }


    // relationship with upload file
    public function uploadFiles()
    {
        return $this->hasMany(UploadFile::class);
    }
}
