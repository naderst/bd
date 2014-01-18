@extends('layouts.default')

@section('title')
	Atletas
@stop

@section('description')
	Aquí se listan todos los atletas registrados. Puedes crear nuevos, editar y borrar existentes.
@stop

@section('breadcrumb')
    <li>
        <form action="{{ URL::action('AtletasController@getBuscar') }}" method="get">
            <i class="fa fa-search"></i>
            <input name="q" class="busqueda" type="text" placeholder="Búsqueda">
        </form>

    </li>
	@if (Request::segment(2) == 'buscar')
		<li>
			<a href="{{ URL::action('AtletasController@getIndex') }}">
				<i class="fa fa-arrow-circle-left"></i>
				<span>Volver</span>
			</a>
		</li>
	@endif
    <li>
        <a href="{{ URL::action('AtletasController@getAgregar') }}">
            <i class="fa fa-plus"></i><span>Nuevo atleta</span></a>
    </li>
@stop

@section('content')
	@if (Request::segment(2) == 'buscar')
		Mostrando resultados de búsqueda para: <b>{{ $q }}</b><br><br>
	@endif
	@if ($atletas->getTotal() == 0)
		<center>Sin resultados.</center>
	@else
		<table class="tabla">
			<tbody>
		    	<tr>
		    		<th>Cédula</th>
		    		<th>Nombres</th>
		    		<th>Apellidos</th>
		    		<th>Fecha Nac.</th>
		    		<th>Sexo</th>
		    		<th>Club</th>
		    		<th>Acción</th>
		    	</tr>
			    @foreach ($atletas as $e)
			    <tr>
			    	<td><a href="{{ URL::action('AtletasController@getModificar', array($e->cedula)) }}">{{ $e->cedula }}</a></td>
			    	<td>{{ $e->nombres }}</td>
			    	<td>{{ $e->apellidos }}</td>
			    	<td>{{ $e->fecha_nacimiento }}</td>
			    	<td>{{ $e->sexo=='M'?'Masculino':'Femenino' }}</td>
			    	<td>{{ $e->club?$e->club->nombre:'Independiente' }}</td>
			    	<td>
				            <a class="borrar" href="{{ URL::action('AtletasController@getEliminar', array($e->cedula)) }}" data-msg="{{ $e->nombres }} {{ $e->apellidos }}">
				                <i class="fa fa-times"></i>Borrar</a>
			    	</td>
			    </tr>
				@endforeach
			</tbody>
		</table>
	@endif
	@if (Request::segment(2) == 'buscar')
		{{ $atletas->appends(array('q' => $q ))->links() }}
	@else
		{{ $atletas->links() }}
	@endif
@stop