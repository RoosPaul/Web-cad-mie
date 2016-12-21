@extends('layouts.app')

@section('content')
<div class="container">
	@if (session('status'))
	<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		{{ session('status') }}
	</div>
	@endif
	<h2>Inscrits</h2><hr>
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
			<th>Status</th>
			<th>Bloquer</th>
			<th>Admin</th>
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
			echo "<td>$value->admin</td>";
			echo "<td><a href='/admin/$value->id/update' class='btn btn-danger btn-xs'>bloquer/débloquer</a></td>";
			echo "<td><a href='/admin/$value->id/edit' class='btn btn-danger btn-xs'>admin/user</a></td>";
			echo "</tr>";
		}
		?>
	</table>
	@endsection