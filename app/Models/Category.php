<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'created_at'];

    public static function ListCategories($name) {

        if (!$name) {
            return DB::table('categories')->get();
        }

        return DB::table('categories')->where('name', 'LIKE', "%{$name}%")->get();
    }

    public function products() {

        return $this->hasMany(Product::class);

    }



}
