<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=0.7; maximum-scale=1.0; user-scalable=false;" />
		<title>LocName | Your Address Simplified |</title>
		<link href="custom.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="wrap">
			<div class="container">
				<div id="logo">
					<a href="http://www.locname.com"><img src="images/logo.png" alt="" /></a>
				</div>
				<h3 class="myh3">Your Address Simplified</h3>
				<div class="button15">
					<?php
						$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
					?>
					<a id="app_url" href="
					<?php
						if(stripos($ua,'android') !== false) {
							echo "https://play.google.com/store/apps/details?id=com.locname.v2";
						}
						else if(stripos($ua,'iphone') !== false || stripos($ua,'ipad') !== false || stripos($ua,'ipod') !== false) {
							echo "https://itunes.apple.com/eg/app/locname/id832556410?mt=8";
						}
						else {
							echo $_SERVER['HTTP_REFERER'];
						}
					?>
					">
						<img src="images/button.png" alt="" />
					</a>
				</div>
				<h3>or</h3>
				<div class="ome_p"><a href="<?php echo $_SERVER['HTTP_REFERER'];?>"><img src="images/go_link.png" alt=""></a></div>
				<div class="clearfix"></div>
				<div class="device_image">
					<a href="http://www.locname.com"><img src="images/mobile.png" alt="" /></a>
				</div>
			</div>
		</div>
	</body>
</html>
