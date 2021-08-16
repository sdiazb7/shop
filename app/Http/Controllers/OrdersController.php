<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PlacetoPay;
use App\Models\Product;
use App\Models\Client;
use App\Models\Order;


class OrdersController extends Controller
{


    /*
    | @metodo:create.
    | @Descripcion:Crear orden de compra. 
    */
    public function create( $id_product=0 )
    {
        if ( empty($id_product) or !is_numeric($id_product) ) {
            return redirect('products')->with('mensaje', 'Id invalido.');
        }

        $product = Product::where( 'id', $id_product )->first();

    	return view('orders.create', compact('product'));
    }


}
