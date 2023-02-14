<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_DataType extends Model
{
    use HasFactory;
    protected $table = 'master_datatype';
    protected $guarded = [
        'id',
    ];
}
