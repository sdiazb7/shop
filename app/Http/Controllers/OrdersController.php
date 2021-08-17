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
    | @Metodo:create.
    | @Descripcion:Crear orden de compra. 
    */
    public function create( $id_product=0 )
    {
        if ( empty($id_product) or !is_numeric($id_product) ) {
            return redirect('welcome')->with('mensaje', 'Id invalido.');
        }

        $product = Product::where( 'id', $id_product )->first();
        return view('orders.create', compact('product'));
    }


    /*
    | @Metodo:retryPayment.
    | @Descripcion:Reintentar un pago que a sido rechazado o declinado. 
    */
    public function retryPayment( $ref='' )
    {
		$order = Order::where( 'reference_cod', $ref )->first();
		$order = Order::where( 'reference_cod', $ref )->first();
        return $this->createOrder( [
            'id_product' => $order->id_product,
            'id_client' => $order->id_client,
        ]);
    }


    /*
    | @Metodo:registerOrder. 
	| @Descripcion:Registrar órden de compra.
	*/
    public function createOrder( $params=array() )
    {
        try{
            $product = Product::where('id', $params['id_product'])->first();
            $client = Client::where('id', $params['id_client'])->first();
            $payment = (object)[
                'product_name'  => str_replace('-', ' ', $product->product_name),
                'description'   => $product->description,
                'product_price'          => $product->price,
                'product_image'       => $product->product_image,
                'names'         => $client->names,
                'surnames'      => $client->surnames,
                'email'         => $client->email,
                'mobile'         => $client->mobile,
                'id_product'    => $product->id,
                'id_client'     => $client->id
            ];
            unset( $product, $client );
            if ( !isset($payment->id_product) or !isset($payment->id_client) ) {
                throw new \Exception('No existen parámetros para conectar con la pasarela de pagos.', 000 );
            }
          
		    $order = Order::where('id_client', $payment->id_client)
                ->where('id_product', $payment->id_product)
                ->whereIn('status', ['CREATE', 'PENDING','REJECTED'])
                ->orderBy('id', 'desc')
                ->first();
             
            if ( isset($order->id) and is_numeric($order->id) and $order->id>0 ) {
                // Si la órden de compra si existe, entonces se actualiza.
				$order->customer_name = $payment->names.' '.$payment->surnames;
                $order->customer_email = $payment->email;
                $order->customer_mobile = $payment->mobile;
                $order->product_price = $payment->product_price;
                $order->save();
            }else{
				// Si la órden de compra no existe, entonces se crea.
                $id_order = Order::insertGetId([
                    'customer_name' => $payment->names.' '.$payment->surnames,
                    'customer_email' => $payment->email,
                    'customer_mobile' => $payment->mobile,
                    'status' => 'CREATE',
					'id_client' => $payment->id_client,
                    'id_product' => $payment->id_product,
                    'product_price' => $payment->product_price,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
                $order = Order::findOrFail( $id_order );
                $order->reference_cod = "COD1"."OR".$id_order."PDT".$payment->id_product;
                $order->save();
            }
            $payment->reference_cod = $order->reference_cod;
            $placeto_pay = new PlacetoPay();
            $result = $placeto_pay->webCheckout( $payment );

            // Obtener la URL de pagos.
            if ( !isset($result->status->status) ) {
                throw new \Exception('No se ha establecido conección con la pasarela de pagos.', 000 );
            }
			
            // Hay una URL de procesamiento, continuar en la pasarela de pago.
            if ( isset($result->requestId) and isset($result->processUrl) ) {
                $order->request_id = $result->requestId;
                $order->response_mess = $result->status->message;
                $order->process_url = $result->processUrl;
                $order->status = $result->status->status;
                $order->save();
                $redirect = @trim($result->processUrl); 
                header('Location: ' . $redirect);
                exit;
            }
        }catch(\Exception $e) {
             $message = $e->getLine()." ".$e->getMessage();
             return redirect('welcome')->with('mensaje', $message);
        }
	}


    /*
    | @Metodo:responsePlacetoPay. 
	| @Descripcion:Obtiene la respuesta de la pasarela de pagos.
	*/
    public function responsePlacetoPay( $reference='' )
    {
        try{
            $order = Order::where( 'reference_cod', strtoupper($reference) )
                ->orderBy('id', 'desc')
                ->first();   	

	    	if ( !isset($order) or empty($order) ) {
	    		throw new \Exception("No se tiene identificación de la órden $reference.", 000 );
	    	}
			
            $placeto_pay = new PlacetoPay();
			$info = $placeto_pay->requestInformation( $order->request_id );
        	if ( !isset($info->status->status) ) {
        		throw new \Exception('Se ha perdido la conección con la pasarela de pagos.', 000 );
        	}

            $order->response_mess = $info->status->message;
            $order->status = $info->status->status;
            $order->save();

            return view('orders.response', [
                'product' => Product::where('id', $order->id_product)->first(),
                'order' => $order,
            ]);

        }catch(\Exception $e) {
             $message = $e->getLine()." ".$e->getMessage();
             return redirect('welcome')->with('mensaje', $message);
        }        
    }


}
