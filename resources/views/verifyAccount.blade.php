<!doctype html>
<html>
	<head>

		<link rel="icon" type="image/x-icon" href="{{ asset('favicon-desktop.ico') }}">
		<title>logres</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
		crossorigin="anonymous">

		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
		crossorigin="anonymous"></script>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
		crossorigin="anonymous"></script>

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
		crossorigin="anonymous">

		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

		<script type="text/javascript" src="{{ asset('js/pnotify.custom.min.js') }}"></script>
		<link rel="stylesheet" href="{{ asset('css/pnotify.custom.min.css') }}" media="all" type="text/css" />

	</head>
	<style type="text/css">
		body {
			background-color: #e8e8e8;
			font-family: 'Raleway', sans-serif;
		}
	</style>
	<body>
		<br>
		<div class="container">
			<h2 class="text-dark text-center">
				<i class="fas fa-desktop"></i> logres
				<i class="fas fa-chevron-circle-right"></i>
			</h2>
		</div>
		<script type="text/javascript">
			let data = {!! json_encode($data) !!}
			console.log('response => ', data);
			switch(data['success'])
			{
				case 0:
					$(function() {
						new PNotify({
							text: data['message'],
							type: 'error',
							width: '400px'
						});
					});
					break;
				case 1:
					$(function() {
						new PNotify({
							title: 'Success',
							text: data['message'],
							type: 'success',
							width: '400px'
						});
					});
					break;
				case 2:
					$(function() {
						new PNotify({
							text: data['message'],
							type: 'notice',
							width: '400px'
						});
					});
					break;
				default:
					$(function() {
						new PNotify({
							text: 'Something went wrong',
							type: 'error',
							width: '400px'
						});
					});
			}
		</script>
	</body>
</html>