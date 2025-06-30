<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable =[
        'uuid',
        'name',
        'description',
        'code',
        'status',
    ];
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string'; 
}
