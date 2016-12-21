@extends('layouts.app')

@section('content')
<div class="col-xs-5 col-xs-offset-3">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	<h1>Contact</h1><hr>
	<form method="post">
	{{ csrf_field() }}
		<h4>Objet :</h4>
		<input type="text" name="titre" class="form-control">
		<h4>Message :</h4>
		<textarea class="form-control" name="objet"></textarea><hr>
		<button class="btn btn-primary pull-right">Envoyé</button>
	</form>
</div>
@endsection