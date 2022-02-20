<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Provider\Node\RandomNodeProvider;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'Sku', 'Product_name', 'Qty', 'Price', 'unit', 'Status'
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
}
