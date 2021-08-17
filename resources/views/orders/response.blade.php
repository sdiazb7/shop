<!DOCTYPE html>


@extends('layout')

@section('content')

<div class="container-flex">
    <div class="container-flex-column">
        <?php if ( $order->status=='APPROVED' ): ?>
            <div class="alert alert-success">
			    <div class="mt-5 p-5" style="display: flex; justify-content: center;  flex-direction: column;">
					<h2 class="text-center">COMPRA EXITOSA</h2>
					<h5>Tus zapatillas llegaran aproximadamente en un día</h5><br>
					<a class="btn btn-light" href="{{ route('welcome') }}">Volver al stock</a> 
				</div>
			</div>
        <?php endif; ?>

        <?php if ( $order->status=='PENDING' ): ?>
            <div class="alert alert-warning">
                <div class="mt-5 p-5" style="display: flex; justify-content: center;  flex-direction: column;">
                    <h2 class="text-center">COMPRA PENDIENTE</h2>
                        <a href="{{ $order->process_url }}" class="btn btn-info m-3">Revisar de nuevo</a>&nbsp;
                        <a href="{{ route('orders.retrypayment', $order->reference_cod) }}" class="btn btn-light m-3">Reintentar pago</a>
                        <a href="{{ route('welcome') }}" class="btn btn-link">Volver al stock</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( $order->status=='REJECTED' ): ?>
		    <div class="alert alert-danger">
	            <div class="mt-5 p-5" style="display: flex; justify-content: center;  flex-direction: column;">
				    <h2 class="text-center">ORDEN DE COMPRA RECHAZADA</h2>
				    <a href="{{ route('orders.retrypayment', $order->reference_cod) }}" class="btn btn-light m-3">Reintentar pago</a>
			    </div>
            </div>
        <?php endif; ?>  
	</div>
</div>

@endsection
