var geocoder = new google.maps.Geocoder();
var latitude = 0;
var longitude = 0;
var latLng = 0;

$(document).ready(function() {
    $('.nav-tabs li a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
      $('#locnamedetails').addClass('hidden');
      if($(this).hasClass('newlocname')){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showdemoPosition, showDemoError);
        }
        else {
            alert("Geolocation is not supported by this browser.");
        }
      }
    });
    $("#existingsubmit").click(function (e){
        e.preventDefault();
        $("#existingsubmit").addClass('disabled');
        var title = $('#existingTitle').val();
        jQuery.ajax ({
        type: "POST",
        url: '/api_sample.php',
        data: {functionname: 'ExistingLocName', arguments: [title]}, 
            complete:function(data) {
                var resultObj = jQuery.parseJSON(data.responseText);
                if (resultObj['response'].status=="fail"){
                    alert("Errors happen all the time");
                    $("#existingsubmit").removeClass('disabled');
                }
                else{
                    $("#existingsubmit").removeClass('disabled');
                    showOutput(resultObj['response']);
                }
            },
            error: function () {
                alert("Errors happen all the time");
                $("#existingsubmit").removeClass('disabled');
            },
        });
    });

    $("#newsubmit").click(function (e){
        alert("This is a demo page, You can't create a LocName through it");
        e.preventDefault();
        // $("#newsubmit").addClass('disabled');
        // var email = $('#user_email').val();
        // var firstname = $('#user_firstname').val();
        // var lastname = $('#user_lastname').val();
        // var title = $('#loc_title').val();
        // var country = $('#loc_country').val();
        // var state = $('#loc_state').val();
        // var address = $('#loc_address').val();
        // var buildingno = $('#loc_bn').val();
        // var flatno = $('#loc_fn').val();
        // var lat = $('#loc_lat').val();
        // var lng = $('#loc_lng').val();
        // jQuery.ajax ({
        // type: "POST",
        // url: '/api_sample.php',
        // data: {functionname: 'NewLocName', arguments: [email,firstname,lastname,title,country,state,address,buildingno,flatno,lat,lng]}, 
        //     complete:function(data) {
        //         var resultObj = jQuery.parseJSON(data.responseText);
        //         if (resultObj['response'].status=="fail"){
        //             alert("Errors happen all the time");
        //             $("#newsubmit").removeClass('disabled');
        //         }
        //         else{
        //             showOutput(resultObj['response']);
        //             $("#newsubmit").removeClass('disabled');
        //         }
        //     },
        //     error: function () {
        //         alert("Errors happen all the time");
        //         $("#newsubmit").removeClass('disabled');
        //     },
        // });
    });
});
function showOutput(resultObj){
    $('#locnamedetails').removeClass('hidden');
    // $('#demoform').remove();
    var title = resultObj.location.title;
    var country =  resultObj.location.country;
    var city =  resultObj.location.city;
    var address =  resultObj.location.address;
    var buildingno =  resultObj.location.building_number;
    var flatno =  resultObj.location.flat_number;
    var lat =  resultObj.location.latitude;
    var lng =  resultObj.location.longitude;
    var short_code =  resultObj.location.short_code;
    $('#locname_title').text(title);
    $('#locname_shortcode').text(short_code);
    $('#locname_buildingno').text(buildingno);
    $('#locname_flatno').text(flatno);
    $('#locname_address').text(address);
    demoshow(lat,lng);
}
function demoshow(lat,lng) {
    latLng = new google.maps.LatLng(lat, lng);
    var map = new google.maps.Map(document.getElementById('locnamemap'), {
        zoom: 18,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    map.getCenter();
    // google.maps.event.trigger(map, "resize");
    var marker = new google.maps.Marker({
        position: latLng,
        title: 'Point A',
        map: map,
        draggable: false
    });
}
function updateDemoMarkerPosition(latLng) {
    getdemoAddress(latLng);
    latitude = latLng.lat();
    longitude = latLng.lng();

    $('#loc_lat').val(latitude);
    $('#loc_lat').html(latitude);

    $('#loc_lng').val(longitude);
    $('#loc_lng').html(longitude);
}
function demoinitialize(gecode) {
    if (gecode == 0)
    {
        latLng = new google.maps.LatLng(latitude, longitude);
        getdemoAddress(latLng);
    }

    var map = new google.maps.Map(document.getElementById('apidemomap'), {
        zoom: 18,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    map.getCenter();
    // google.maps.event.trigger(map, "resize");
    var marker = new google.maps.Marker({
        position: latLng,
        title: 'Point A',
        map: map,
//        icon: "assets/main/img/LocPin.png",
        draggable: true
    });

    google.maps.event.addListener(map, 'dblclick', function(event) {
        marker.position = event.latLng;
        updateDemoMarkerPosition(event.latLng);
        getdemoAddress(event.latLng);
    });

    google.maps.event.addListener(marker, 'dragend', function() {
        updateDemoMarkerPosition(marker.getPosition());
        getdemoAddress(marker.getPosition());
    });
}


function showDemoError(error) {

    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }

}

function showdemoPosition(position) {

    latitude = position.coords.latitude;
    longitude = position.coords.longitude;

    $('#loc_lat').val(latitude);
    $('#loc_lat').html(latitude);

    $('#loc_lng').val(longitude);
    $('#loc_lng').html(longitude);

    demoinitialize(0);
}

function getdemoAddress(pos) {
    geocoder.geocode({
        latLng: pos
    }, function(responses) {
        if (responses && responses.length > 0) {
            var address = "";
            var city = "";
            var region = "";
            var country = "";
            for (var i=0; i<responses[0].address_components.length; i++)
            {
                if (responses[0].address_components[i].types[0] == "administrative_area_level_1") {
                        region = responses[0].address_components[i].long_name;
                        continue;
                    }
                if (responses[0].address_components[i].types[0] == "country") {
                        country = responses[0].address_components[i].long_name;
                        continue;
                    }
                address += responses[0].address_components[i].long_name + " - ";
            }
            address = address.substring(0, address.length - 3);
            // alert(responses[0].address_components[0].long_name);
            // alert(responses[0].address_components[1].long_name);
            // alert(responses[0].address_components[2].long_name);
            // alert(responses[0].address_components[3].long_name);
            // alert(responses[0].address_components[4].long_name);
            $("#loc_address").val(address);
            $("#loc_country").val(country);
            $("#loc_state").val(region);
            // $("#details").val(address);
        } else {
            $('#loc_address').text('Cannot determine address at this location.');
            //$('#details').text('Cannot determine address at this location.');
        }
    });
}

