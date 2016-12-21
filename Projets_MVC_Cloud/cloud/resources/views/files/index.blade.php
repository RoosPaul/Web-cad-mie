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
			<th>Modifier</th>
			<th>Supprimer</th>
			<th>Action</th>
		</tr>
		<?php
		foreach ($data as $value) {
			echo "<tr>";
			echo "<td>$value->folder</td>";
			echo "<td>$value->file</td>";
			echo "<td>$value->type</td>";
			echo "<td>$value->created_at</td>";
			echo "<td>$value->taille</td>";
			echo "<td><a href='/files/$value->id/edit' class='btn btn-primary btn-xs'>Modifier</a></td>";
			echo "<td><a href='/files/$value->id/delete' class='btn btn-danger btn-xs'>Supprimer</a></td>";
			echo "<td><a href='/files/$value->id' class='btn btn-primary btn-xs'>Voir le fichier</a></td>";
			echo "</tr>";
		}
		?>
	</table>
	{{ $data->links() }}

	<hr>
	<div class="row col-xs-4">
		<h3>Ajouter un dossier :</h3><hr>
		<form method="get" action="/files/update">
			<input type="text" name="folder" class="form-control" placeholder="Nom de votre dossier"><hr>
			<button type="submit" class="btn btn-success pull-right">Créer le dossier</button>
		</form>
	</div>
	<div class="row col-xs-4">
		<h3>Supprimer un dossier :</h3><hr>
		<form method="post" action="/files/delete_dir">
			<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
			<select class="form-control" name="folder">
				<?php
				foreach ($folders as $key => $value) {
					echo "<option value='$value' name='folder'>$value</option>";
				}
				?>
			</select><hr>
			<button type="submit" class="btn btn-success pull-right">Supprimer le dossier</button>
		</form>
	</div>
	<div class="row col-xs-4">
		<h3>Changer un fichier de dossiers</h3><hr>
		<form method="post" action="/files/move_dir">
			<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
			<div class="col-xs-6">
				<select class="form-control" name="file">
					<?php
					foreach ($data as $value) {
						echo "<option value='$value->id' name='folder'>$value->file</option>";
					}
					?>
				</select>
			</div>
			<div class="col-xs-6">
			<select class="form-control" name="folder">
					<?php
					foreach ($folders as $key => $value) {
						echo "<option value='$value' name='folder'>$value</option>";
					}
					?>
				</select>
			</div>
			<hr><button type="submit" class="btn btn-success pull-right">Changer de dossier</button>
		</form>
	</div>

	@endsection