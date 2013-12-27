@extends('layouts.default')

@section('content')
    @foreach ($asociaciones as $e)
    	Asocación: {{ $e->nombre }} ({{ $e->estado }})<br>
	@endforeach
@stop