@extends('layouts.app')

@section('content')
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	<h1>Partage de fichiers</h1><hr>
	<form method="POST">
		<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
		<div class="col-xs-6">
			<h2>Utilisateurs :</h2><hr>
			<div class='checkbox'>
				<label>
					<input type='checkbox' class="checkPublic" onclick="checkAllBox()">Donner le droit a tout le monde</label>
				</div>
				<div class='checkbox'>
					<label>
					<input type='checkbox' name='private' value='true'>Private</label>
					</div>
					<?php 
					foreach ($data as $value) {
						echo "<div class='checkbox'><label>
						<input type='checkbox' name='users[]' class='checkClass' value='$value->id'>$value->email</label></div>";
					}
					?>
				</div>
				<div class="col-xs-6">
					<h2>Dossiers :</h2><hr>
					<?php 
					foreach ($folders as $value) {
						echo "<div class='checkbox'><label>
						<input type='checkbox' name='folders[]' value='$value'>$value</label></div>";
					}
					?>
				</div>
				<button type="submit" class="btn btn-success pull-right">Mettre</button>
			</form>
		</div>
		@endsection