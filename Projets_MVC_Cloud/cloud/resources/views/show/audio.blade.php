@extends('layouts.app')

@section('content')
<div class="col-xs-6 col-xs-offset-3">
	<?php
	foreach ($data as $val) {
		echo "<div class='row'>";
		echo "<h1>$val->username</h1><hr>";
		echo "<h2>$val->file</h2>";
		echo "<a href='/images/$val->user_id/$val->folder/$val->file' class='btn btn-success btn-md pull-right' download>Download</a>";
		echo "Upload le : $val->created_at<hr>";
		echo "</div>";
		echo "<audio controls>";
		echo "<source src='/images/$val->user_id/$val->folder/$val->file' type='audio/ogg'>";
		echo "<source src='/images/$val->user_id/$val->folder/$val->file' type='audio/mpeg'>";
		echo "Your browser does not support the audio element.";
		echo "</audio>";
	}
	?>

</div>
@endsection