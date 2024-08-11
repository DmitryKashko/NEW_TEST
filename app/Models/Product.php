<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    const UPDATED_AT = 'stmTimestamp';
    protected $table = 'tblProductData';
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'intProductDataId';
}
