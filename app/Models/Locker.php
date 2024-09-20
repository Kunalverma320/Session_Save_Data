<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    protected $table = 'locker';
    protected $fillable = [
        'id',
        'locker_number',
        'status',
    ];
    use HasFactory;
}
