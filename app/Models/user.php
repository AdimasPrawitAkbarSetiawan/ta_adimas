<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'is_active', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    public function klien()
    {
        return $this->hasOne(Klien::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'marketing_id');
    }

    public function projectNotes()
    {
        return $this->hasMany(Projectnote::class, 'owner_id');
    }

    public function projectDetails()
    {
        return $this->hasMany(Projectdetail::class, 'operational_id');
    }

    public function projectProgress()
    {
        return $this->hasMany(Projectprogress::class, 'operational_id');
    }

    public function isAdmin() { return $this->role === 'admin'; }
    public function isOwner() { return $this->role === 'owner'; }
    public function isMarketing() { return $this->role === 'marketing'; }
    public function isOperasional() { return $this->role === 'operasional'; }
    public function isKlien() { return $this->role === 'klien'; }
}