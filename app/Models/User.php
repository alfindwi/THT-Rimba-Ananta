<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class User extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected static function boot() {

        parent::boot();

        static::creating(function ($model) {
            if( empty($model->{$model->getKeyName()}) ) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    
    protected $fillable = [
        'name',
        'email',
        'age',
    ];
}
