@extends('layouts.app')

@section('content')
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	<h1>Vos fichiers</h1><hr>
	<table class="table table-responsive table-striped">
		<tr>
			<th>Dossier</th>
			<th>Fichier</th> 
			<th>Type</th>
			<th>Date d'ajout</th>
			<th>Poids</th>
			<th>Action</th>
		</tr>
		<?php
		foreach ($data as $value) {
			foreach ($value as $val) {
				echo "<tr>";
				echo "<td>$val->folder</td>";
				echo "<td>$val->file</td>";
				echo "<td>$val->type</td>";
				echo "<td>$val->created_at</td>";
				echo "<td>$val->taille</td>";
				echo "<td><a href='/files/$val->id' class='btn btn-primary btn-xs'>Voir le fichier</a></td>";
				echo "</tr>";
			}
		}
		?>
	</table>
</div>

@endsection