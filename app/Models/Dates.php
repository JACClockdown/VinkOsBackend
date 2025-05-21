<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dates extends Model
{
    use HasFactory;

    protected $table = 'dates';

    protected $fillable = [
        'name',
        'phone',
        'born_date',
    ];
}
