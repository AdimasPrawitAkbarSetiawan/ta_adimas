<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectprogress extends Model
{
    protected $table = 'project_progress';

    protected $fillable = [
        'project_id', 'operational_id',
        'title', 'description', 'percentage', 'tanggal_laporan'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function operational()
    {
        return $this->belongsTo(User::class, 'operational_id');
    }

    public function photos()
    {
        return $this->hasMany(Projectphoto::class, 'progress_id');
    }
}