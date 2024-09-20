<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockerUser extends Model
{
    protected $table = 'locker_user';
    protected $fillable = [
        'id',
        'name',
        'address',
        'locker',
    ];
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(strtolower($value));
    }
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucfirst(strtolower($value));
    }
    use HasFactory;
}
