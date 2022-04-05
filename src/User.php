<?php

namespace Authenticate;

use App\Models\Plan;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Job\Models\Job;
use Laravel\Sanctum\HasApiTokens;
use Topic\Models\Topic;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = [
        'full_name', 'slogan', 'national_id', 'mobile', 'email',
        'address', 'gender', 'active', 'birthday', 'role', 'lat', 'lang',
        'avatar', 'custom_color', 'cover', 'username', 'api_token',
        'visit', 'lat', 'lang', 'province', 'city', 'instagram',
        'twitter', 'linkedin', 'api_token'
    ];

    protected $hidden = ['password', 'api_token'];

    public function scopeIsBanned($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }

    public function scopeSuperAdmin($query)
    {
        $query->where('id', '<>', 1);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }

    public function isAdmin()
    {
        return $this->role == "admin";
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }
}
