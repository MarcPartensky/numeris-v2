<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,
        OnEventsTrait;

    protected $fillable = [
        // One-to-One relations
        'address_id',

        // attributes
        'activated',
        'tou_accepted',
        'subscription_paid_at',
        'email',
        'password',
        'username',
        'first_name',
        'last_name',
        'student_number',
        'promotion',
        'phone',
        'nationality',
        'birth_date',
        'birth_city',
        'social_insurance_number',
        'iban',
        'bic',
    ];

    protected $hidden = [
        'password',
        'address',
    ];

    protected $casts = [
        'activated'             => 'boolean',
        'tou_accepted'          => 'boolean',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function setAddress(Address $address)
    {
        return $this->address()->attach($address);
    }

    /**
     * To be realised just after an user is deleted
     */
    public static function onDeleted(self $user)
    {
        // Delete all related models
        $user->address()->delete();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }

    /**
     * Return the current role of the user (= the latest)
     */
    public function role()
    {
        return $this->roles()->latest()->first();
    }

    public function isDeveloper()
    {
        return $this->role()->name === "developer";
    }

    public function isAdministrator()
    {
        return $this->role()->name === "administrator";
    }

    public function isStaff()
    {
        return $this->role()->name === "staff";
    }

    public function isStudent()
    {
        return $this->role()->name === "student";
    }

    public function preference()
    {
        return $this->belongsTo(Preference::class);
    }
}
