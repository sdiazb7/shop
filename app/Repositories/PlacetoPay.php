<?php
namespace App\Repositories;


class PlacetoPay
{

    private $conection = [];


    private $url_api;


    public function __construct()
    {
    	$seed = date('c');
		if (function_exists('random_bytes')) {
		    $nonce = bin2hex(random_bytes(16));
		} elseif (function_exists('openssl_random_pseudo_bytes')) {
		    $nonce = bin2hex(openssl_random_pseudo_bytes(16));
		} else {
		    $nonce = mt_rand();
		}
		$tran_key = base64_encode(sha1($nonce . $seed . config('app_payments.tran_key'), true));
        $this->conection = [
			'login' => config('app_payments.login'),
			'seed' => $seed,
			'nonce' => base64_encode($nonce),
			'tranKey' => $tran_key
		];
		$this->url_api = "https://test.placetopay.com/redirection/api";
    }


    /*
    |@Metodo:webCheckout.
    |@Descripcion:Verifica la autenticación con Placetopay. 
    */
	public function webCheckout( $params=null )
	{
        try{
	    	if ( !$params or empty($params) ) return false;

	    	$data = is_object($params) ? $params : (object)$params;
			$request = [
				'auth' => $this->conection,
				'buyer' => [
					'name' => $data->names,
					'surname' => $data->surnames,
					'email' => $data->email,
					'document' => '',
					'documentType' => '',
					'mobile' => $data->mobile
				],
			    'payment' => [
			        'reference' => $data->reference_cod,
					'description' => $data->product_name,
			        'amount' => [
			            'currency' => 'COP',
			            'total' => $data->product_price
			        ]
			    ],
			    'expiration' => date('c', strtotime('+2 days')),
			    'returnUrl' => route('orders.response', $data->reference_cod),
			    'ipAddress' => '127.0.0.1',
			    'userAgent' => 'PlacetoPay Sandbox'
			];
			$response = $this->getJson( $this->url_api."/session", $request ); 
            return $response;
        }catch(\Exception $e) {
        	return "No se ha logrado el checkout, linea: ".$e->getLine()." ".$e->getMessage();
        }
	}


    /**
	| @metodo:requestInformation
	| @descripcion:Obtener información sobre una orden de compra.
     */
	public function requestInformation( $request_id=null )
	{
        try{
			$request = [ 'auth' => $this->conection ];
			return $this->getJson( $this->url_api."/session/$request_id", $request );
        }catch(\Exception $e) {
        	return "No se ha logrado obtener información, ".$e->getLine()." ".$e->getMessage();
        }
	}


    /*
    | @metodo:reversePayment. 
    | @descripcion:Revertir una orden de compra al estado aprobado.
	*/
	public function reversePayment( $reference=null )
	{
        try{
			$request = [
				'auth' => $this->conection,
				'internalReference' => $reference
			];
			$response = $this->getJson( $this->url_api."/reverse", $request );
			return $response;
        }catch(\Exception $e) {
        
        	return "No se ha logrado reversar transacción, ".$e->getLine()." ".$e->getMessage();
        }
	}


   /*
    | @method getJson.
    | @Descripcion:Este metodo obtiene información en formato JSON Restful APIs.
    */
    public function getJson( $url=null, $request='' )
    {
		$curl = curl_init( trim($url) );
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
		$json_response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		return json_decode($json_response);
    }


}
