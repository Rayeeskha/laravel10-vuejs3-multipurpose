<?php

namespace App\Models;
use App\Enums\RoleType;
use Illuminate\Database\Eloquent\Casts\Attribute;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'formatted_created_at',
    ];

    //Scope
    public function scopeSearch($query, $searchQuery){
        return $query->where('name', 'like', "%{$searchQuery}%")->orWhere('email', 'like', "%{$searchQuery}%");
    }

    // Accessors
    public function getFormattedCreatedAtAttribute(){
        return $this->created_at->format('d M Y');
    }

    // Accessors
    public function role(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => RoleType::from($value)->name,
        );
    }
}
