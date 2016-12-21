@extends('layouts.app')

@section('content')
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	<h2>10 derniers inscrits</h2><hr>
	<table class="table table-responsive table-striped">
		<tr>
			<th>Id</th>
			<th>Pseudo</th>
			<th>Prénom</th>
			<th>Nom</th>
			<th>E-mail</th>
			<th>Birthdate</th>
			<th>Poids</th>
			<th>Date d'inscription</th>
		</tr>
		<?php
		foreach ($users as $value) {
			echo "<tr>";
			echo "<td>$value->id</td>";
			echo "<td>$value->username</td>";
			echo "<td>$value->firstname</td>";
			echo "<td>$value->lastname</td>";
			echo "<td>$value->email</td>";
			echo "<td>$value->birthdate</td>";
			echo "<td>$value->taille</td>";
			echo "<td>$value->created_at</td>";
			echo "</tr>";
		}
		?>
	</table>
	<h2>10 derniers fichiers</h2><hr>
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