<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'projects';
    protected $fillable = [
        'project_code', 'name', 'description',
        'client_id', 'marketing_id',
        'budget_estimate', 'budget_final',
        'status', 'approved_at',
        'location', 'maps_link', 'other_info'
    ];

    public function klien()
    {
        return $this->belongsTo(Klien::class, 'client_id');
    }

    public function marketing()
    {
        return $this->belongsTo(User::class, 'marketing_id');
    }

    public function notes()
    {
        return $this->hasMany(Projectnote::class);
    }

    public function detail()
    {
        return $this->hasOne(Projectdetail::class);
    }

    public function progress()
    {
        return $this->hasMany(Projectprogress::class);
    }

    public function latestProgress()
    {
        return $this->hasOne(Projectprogress::class)->latestOfMany();
    }
}