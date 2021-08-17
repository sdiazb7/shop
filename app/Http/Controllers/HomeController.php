<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 	
        $orders = Order::join("products","products.id", "=", "orders.id_product")
        ->select("orders.reference_cod", "orders.customer_name", "orders.customer_email", "orders.customer_mobile", "orders.status", "products.product_name", "orders.product_price")
        ->paginate(1);
		return view('home', compact('orders'));
    }
}
