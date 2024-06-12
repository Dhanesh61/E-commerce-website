<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mens extends Model
{
    use HasFactory;
    protected $table = 'mans_ware'; 
    protected $fillable = ['name','description','image','price'];
}
