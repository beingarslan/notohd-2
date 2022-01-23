<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UploadFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'filename',
        'created_at',
        'updated_at',
    ];

    // get path
    public function getPathAttribute()
    {
        return Storage::disk('Wasabi')->url($this->filename);
    }
}