<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
        'last_login',
        'profile_picture',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }
    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class, 'approved_by', 'id');
    }

    public function notices(): HasMany
    {
        return $this->hasMany(Notice::class, 'posted_by', 'id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by', 'id');
    }

     public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class, 'generated_by','id');
    }

    public function assignedAssets(): HasMany
    {
        return $this->hasMany(AssetAssignment::class, 'assigned_by','id');
    }
}
