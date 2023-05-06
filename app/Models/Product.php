<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    public static function listProducts($name = null){

        if (!$name) {
            return DB::table('products')->get();
        } 
        
        return DB::table('products')->where('name', 'LIKE', "%{$name}")->get();        
    }


}
