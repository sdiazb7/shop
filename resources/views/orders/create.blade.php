<!DOCTYPE html>


@extends('layout')

@section('content')

<div class="container-flex">
    <div class="container-flex-column">
         <ul>
	        <li><h5>Nombre del producto:</h5></li>
	        <li><?=$product['product_name']?></li><br>
	        <li><h5>Descripcion del producto:</h5></li>
	        <li><?=$product['description']?></li><br>
	     </ul>
		 <div class="container-img">
		    <img src="{{url('img/'.$product['product_image'])}}" ></img>
	     </div> 
	</div>
    <div class="container-flex-column" style="background:#eceff7">
		<form action="{{ route('clients.store') }}" method="POST" >
		    @csrf
			<input type="hidden" name="id_product" value="<?=$product['id']?>" >
            <div class="form-group">
                <label for="nombre">Nombres:</label>
                <input type="text" class="form-control" name="names" value="{{ old('name') }}"  placeholder="Registre sus nombres" >
            </div>
            <div class="form-group">
                <label for="surnombre">Apellidos:</label>
                <input type="text" class="form-control" name="surnames" value="{{ old('surname') }}"  placeholder="Registre sus apellidos" >
            </div>
            <div class="form-group">
                <label for="surnombre">Correo Electrico:</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="Registre su correo electronico" >
            </div>
            <div class="form-group">
                <label for="surnombre">Telefono:</label>
                <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"  placeholder="Registre su numero de telefono" >
            </div>	
            <div class="form-group">
                <label for="surnombre">Precio del producto:</label>
                <input type="text" class="form-control"  value="<?="$".number_format( $product->price, 0 )?>" readonly="readonly" placeholder="Registre su numero de telefono" >
            </div>				
            <button type="submit" class="btn btn-success" style="margin-top:25px">Completar compra</button>
        </form>
    </div>
</div>

@endsection
