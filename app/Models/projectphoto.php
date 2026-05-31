<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectphoto extends Model
{
    protected $table = 'progress_photos';

    protected $fillable = ['progress_id', 'file_path', 'caption'];

    public function progress()
    {
        return $this->belongsTo(Projectprogress::class, 'progress_id');
    }
}