<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Provider\Node\RandomNodeProvider;

Class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password'
    ];

    public $incrementing = false;  public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $nodeProvider = new RandomNodeProvider();

            /* validate duplicate UUID */
            do{
            $uuid = Uuid::uuid1($nodeProvider->getNode());
            $uuid_exist = self::where('id', $uuid)->exists();
            } while ($uuid_exist);
            $model->id = $uuid;
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
