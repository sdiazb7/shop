<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;


    protected $table = 'products';


    public $timestamps = true;


    protected $casts = [];


    /*
    |@var array
    */
    protected $fillable = [
        'id', 
        'product_name', 
        'description', 
        'price', 
        'product_image'
    ];

}
