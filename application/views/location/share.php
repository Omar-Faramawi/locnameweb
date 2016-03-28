<html>
    <head>
        <title><?= $location->title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

        <link rel="stylesheet" href="<?= base_url("assets/main") ?>/css/bootstrap.css" type="text/css"/>
        <link rel="stylesheet" href="<?= base_url("assets/main") ?>/css/bootstrap-responsive.min.css" type="text/css"/>
        
        <script src="<?= base_url("assets/main") ?>/js/jquery.js" type="text/javascript"></script>

        <script>
            window.site_url = "<?= site_url() ?>";
            function getMyLocation(ToWhere) {
                window.ToWhere = ToWhere;
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showMyPosition);
                    //$("#getmethere").click();
                }
                else {
                    alert("Geolocation is not supported by this browser.");
                }
            }
            function showMyPosition(position) {
                var innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
                var href = site_url + "location/share/" + window.ToWhere + "?action=takeme&lat=" + position.coords.latitude + "&long=" + position.coords.longitude;
                //$("#getmethere").attr("href", href);
                document.getElementById("getMeThere").setAttribute("href", href);
                location.href = href;
            }
            
            function addToFav(title) {
                $.post("<?= site_url("api/add_favorite") ?>" , {title : title})
                    .done(function(result) {
                        if(result === "fav") {
                            $("#fav_text").text ("Unfavorite");
                        }
                        else if(result === "unfav") {
                            $("#fav_text").text("Add to favorites");
                        }
                        else {
                            alert("You are not logged in to LocName");
                        }
                    });
            }
        </script>
    </head>
    <body>
        <div id="locationContainer" class="container main-content">
            <?php echo $map['js']; ?>
            <div id="locname-map">
                <?php echo $map['html']; ?>
            </div>
                <?php
                    if($isFavorite) {
                        $fav_text = "Unfavorite";
                    }
                    else {
                        $fav_text = "Add to favorites";
                    }
                ?>

            <div class="locname-info row-fluid">
                <div class="span6" style="">
                    <a class="btn btn-large btn-success" id="getMeThere" onclick="getMyLocation('<?= $location->title ?>')" href="javascript:void(0)"><i class="icon-arrow-up"></i> Take Me There</a>
                    <a class="btn btn-large btn-warning" id="addToFav" onclick="addToFav('<?= $location->title ?>')" href="javascript:void(0)"><i class="icon-star"></i> <span id="fav_text"><?= $fav_text ?></span></a>
                    <a class="btn btn-large btn-info" id="share" onclick="" href="javascript:void(0)"><i class="icon-share"></i> Share</a>
                </div>
            </div>
        </div>

        <div id="directionsDiv"></div>

        <input type="hidden" id="current-lat" value="" >
        <input type="hidden" id="current-long" value="" >

    </body>
</html>
