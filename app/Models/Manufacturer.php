<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name'];

}