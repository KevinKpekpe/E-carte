<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'nom',
        'prenom',
        'email',
        'telephone',
        'profession',
        'photo_profile',
        'vcard_file',
        'is_active',
        'expiration_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expiration_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }
}
