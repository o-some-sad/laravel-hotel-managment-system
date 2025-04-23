<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Cog\Laravel\Ban\Traits\Bannable;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements \Cog\Contracts\Ban\Bannable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles, Bannable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_by',
        'national_id',
        'avatar_image',
        'mobile',
        'country_code',
        'gender',
        'approved_at',
        'approved_by',
        'manager_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'approved_at' => 'datetime',
            'banned_at' => 'datetime',
        ];
    }

    /**
     * Get the user who approved this user.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdFloors()
    {
        return $this->hasMany(Floor::class, 'created_by');
    }

    public function createdRooms()
    {
        return $this->hasMany(Room::class, 'created_by');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function bans()
    {
        return $this->hasMany(Ban::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function managedReceptionists()
    {
        return $this->hasMany(User::class, 'manager_id')
                ->whereHas('roles', fn($q) => $q->where('name', 'receptionist'));
    }

    public function approvedClients()
    {
        return $this->hasMany(User::class, 'approved_by')
                    ->whereHas('roles', fn($q) => $q->where('name', 'client'));
    }

    public function createdReceptionists()
    {
        return $this->hasMany(User::class, 'created_by')
                ->whereHas('roles', fn($q) => $q->where('name', 'receptionist'));
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function receptionists()
    {
     return $this->hasMany(User::class, 'manager_id');
    }

}

