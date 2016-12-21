@extends('layouts.app')
@section('content')
<div class="col-xs-6 col-xs-offset-3">
	@if (session('status'))
	<div class="alert alert-danger">
		{{ session('status') }}
	</div>
	@endif
	<h1>Home</h1>
	<p>Bienvenue sur le Cloud Wac</p><hr>
	@if (Auth::guest())
	<p>Connectez-vous pour upload vos fichiers</p>

	@else
	<div class="dropzone" id="dropzoneFileUpload">
	</div>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
	
	<script type="text/javascript">
		var baseUrl = "{{ url('/') }}";
		var token = "{{ Session::getToken() }}";
		Dropzone.autoDiscover = false;
		var myDropzone = new Dropzone("div#dropzoneFileUpload", {
			url: baseUrl + "/dropzone/uploadFiles",
			params: {
				_token: token
			}
		});
		Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            accept: function(file, done) {
            	
            },
        };
    </script>
	@endif
</div>
@endsection