<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formdata extends Model
{
    protected $table = 'formdata';
    protected $fillable = [
        'id',
        'Name',
        'Password',
        'Email',
        'Image',
        'Mobile',
        'Date',
        'Role',
    ];

    use HasFactory;
}
