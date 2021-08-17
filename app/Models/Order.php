<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;


    protected $table = 'orders';


    public $timestamps = true;


    protected $casts = [];


    /*
    |@var array
    */
    protected $fillable = [
        'id',
		'reference_cod',
		'customer_name',
		'customer_email',
		'customer_mobile',
		'request_id',
		'response_mess',
		'process_url',
		'status',
		'id_client',
		'id_product',
		'product_price',
        'create_at',
        'update_at'
    ];
}
