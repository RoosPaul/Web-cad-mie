@extends('layouts.app')

@section('content')
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	<h2><?php echo $user;?></h2><hr>
	<table class="table table-responsive table-striped">
		<tr>
			<th>Dossier</th>
			<th>Fichier</th> 
			<th>Type</th>
			<th>Date d'ajout</th>
			<th>Poids</th>
		</tr>
		<?php
		foreach ($files as $value) {
			echo "<tr>";
			echo "<td>$value->folder</td>";
			echo "<td>$value->file</td>";
			echo "<td>$value->type</td>";
			echo "<td>$value->created_at</td>";
			echo "<td>$value->taille</td>";
			echo "</tr>";
		}
		?>
	</table>

	@endsection