<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

protected $fillable = [
        'user_type_id',
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'profession',
        'photo_profile',
        'is_active',
        'email_verified_at',
        'vcard_file',
        'expiration_date',
        'activation_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'expiration_date' => 'date',
    ];

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function isSuperAdmin()
    {
        return $this->userType->name === 'superadmin';
    }

    public function isEntreprise()
    {
        return $this->userType->name === 'entreprise';
    }

    public function isPremium()
    {
        return $this->userType->name === 'premium';
    }

    public function isClassique()
    {
        return $this->userType->name === 'classique';
    }
}
