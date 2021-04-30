<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Oops!</title>
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"
		id="bootstrap-css">
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/welcome.css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="error-template">
					<h1>
						MM API</h1>
					<h2>
					You are not allowed to access this page</h2>
					<div class="error-details">
						<br>
					</div>
					<div class="error-actions">
						<a href="#" class="btn btn-primary btn-lg"><span
								class="glyphicon glyphicon-home"></span>
							Take Me Home </a>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>
