<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductsController extends Controller
{
    

    /*
    | @Metodo:index.
	| @Descripcion:Listar productos en la vista welcome.
    */
    public function index()
    {
        $products=Product::all();
		
		return view('welcome', compact('products'));
    }


}
