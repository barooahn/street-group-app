<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homeowner extends Model
{
    public $fillable = ['title ','first_name','initial', 'last_name'];
}
