@extends('layouts.app')

@section('content')
<div class="col-xs-6 col-xs-offset-3">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	<h1>Fichier</h1><hr>
	<?php
	foreach ($data as $key => $value) {
		echo "Dossier : $value->folder <br>";
		echo "Nom du fichier : $value->file <br>";
		echo "Type : $value->type <br>";
		echo "Date de création : $value->created_at <br>";
		echo "<hr>";
		echo "<h2>Changez le nom de votre fichier :</h2>";
		echo '<form method="post">';
		?><input type="hidden" name="_token" value="<?php echo csrf_token() ?>"><?php
		echo "<input type='hidden' name='old_name' value='$value->file'>";
		echo "<input type='hidden' name='folder' value='$value->folder'>";
		echo '<input type="text" name="name" class="form-control"><hr>';
		echo '<button class="btn btn-success pull-right">Changer</button>';
		echo '</form>';
	}
	?>
</div>
@endsection