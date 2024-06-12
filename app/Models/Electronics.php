<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electronics extends Model
{
    use HasFactory;
    protected $table = 'electronics'; 
    protected $fillable = ['name','description','image','price'];
}
