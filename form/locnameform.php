<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
<script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript" src="locname.js"></script>
</head>
<body>
	<div class="container">

        <div id="map" >
            <img src="<?= base_url("assets/main/img/sloading.gif"); ?>" alt="Loading map" >
        </div>
		<form name="locnametest" method="post" action="api_sample.php">
			<div class="input-group input-group">
				<span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
				<input name="email" type="text" class="form-control" placeholder="email" maxlength="20" tabindex=1>
			</div>

			<div class="input-group input-group">
				<span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
				<input name="firstname" type="text" class="form-control" placeholder="FirstName" maxlength="20" tabindex=1>
			</div>
			<div class="input-group input-group">
				<span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
				<input name="lastname" type="text" class="form-control" placeholder="LastName" maxlength="20" tabindex=1>
			</div>
			<div class="input-group input-group">
				<span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
				<input name="latitude" type="text" class="form-control" placeholder="Latitude" maxlength="20" tabindex=1>
			</div>
			<div class="input-group input-group">
				<span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
				<input name="longitude" type="text" class="form-control" placeholder="Longitude" maxlength="20" tabindex=1>
			</div>
			<div class="input-group input-group">
				<span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
				<input name="title" type="text" class="form-control" placeholder="Title" maxlength="20" tabindex=1>
			</div>
			<div class="input-group input-group">
				<span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
				<input name="address" type="text" class="form-control" placeholder="Address" maxlength="20" tabindex=1>
			</div>
			<input name="submit" class="btn btn-success" type="submit" value="Submit"/>
			<div id="lat"></div>
			<div id="lng"></div>
		</form>
	</div>
</body>
</html>