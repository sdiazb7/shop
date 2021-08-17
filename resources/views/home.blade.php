@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
	    <h1>Ordenes totales de la tienda</h1>
        <div class="col-md-10">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">Codigo de referencia</th>
                    <th scope="col">Nombre cliente</th>
                    <th scope="col">Email cliente</th>
					<th scope="col">Telefono cliente</th>
					<th scope="col">Nombre producto</th>
					<th scope="col">Precio producto</th>
					<th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
					    <tr>
                            <th scope="row">{{$order['reference_cod']}}</th>
                            <td>{{$order['customer_name']}}</td>
                            <td>{{$order['customer_email']}}</td>
                            <td>{{$order['customer_mobile']}}</td>
							<td>{{$order['product_name']}}</td>
							<td>{{$order['product_price']}}</td>
							<td>{{$order['status']}}</td>
                        </tr>
					@endforeach
                </tbody>
            </table>
                    {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
