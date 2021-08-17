<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\OrdersController as Orders;
use App\Models\Client;


class ClientsController extends Controller
{

    
    /*
    |@metodo:store.
    |@Descripcion:Registrar cliente. 
    */
     public function store( Request $request )
    {
        try{
            $data = $request->All();
            $data = array_map("trim", $data);
            $validated = Validator::make( $data, Client::$rules, Client::$messages );
            if ( $validated->fails() ) {
                return redirect()->back()->withErrors( $validated )->withInput();
            }
			
			if( !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ){
				return redirect()->back()->with('mensaje', 'El email tiene un formato incorrecto.')->withInput();
			}

			$client = Client::where('email', strtolower($data['email']))->first();
			if ( (!is_numeric($client['id'])) ) {
	           	$id = Client::insertGetId([
					'names' 		=> utf8_encode( ucwords( strtolower($data['names'])) ),
					'surnames' 		=> utf8_encode( ucwords( strtolower($data['surnames']) ) ),
					'email' 		=> strtolower( trim($data['email']) ),
					'mobile' 		=> @trim( $data['mobile'] ),
					'created_at' 	=> date("Y-m-d H:i:s"),
					'updated_at' 	=> date("Y-m-d H:i:s")
	            ]);
	            $client = Client::findOrFail( $id );
			}
           
		    $params_payment = [
				'id_product' => $data['id_product'],
				'id_client' => $client->id,
			];
			unset($data, $client);
			$orders = new Orders();
        	return $orders->createOrder( $params_payment );
			
        }catch(\Exception $e) {
        	$message = "".$e->getLine()." ".$e->getMessage();
        	return redirect()->back()->with('mensaje', $message);
        }
        
    }


}
