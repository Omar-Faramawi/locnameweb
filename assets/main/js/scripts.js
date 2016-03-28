var flag=true;
$(document).ready(function() {
    $(document).on('change', '#password-on-map', function(){
        if($(this).prop('checked') === false){
            $('input#passwordInfobox').hide();
            $('.arrow-left').css('margin-top','-186px');
            $('.arrow-left').css('margin-bottom', '151px');
        } else {
            $('input#passwordInfobox').show();
            $('.arrow-left').css('margin-top','-225px');
            $('.arrow-left').css('margin-bottom', '188px');
        }
    });
    $('#search-in-nav').click(function(){
        window.location = site_url+$(".header-search").val();
    });
    /* Check if browser geoloaction is enabled and detect browser type*/
    getLocation();
    $(".embedded-this").on("click", function() {
        $(".embedded-body").slideToggle();
    });

    $('a#openAdvancedSearch').click(function() {
        $('div#advancedSearchContainer').removeClass('hide').show('blind', 500);
		$('div#close-find-what').hide('blind', 500);
    });

    $('#add-locname').click(function() {
        $('#step1').removeClass('hide').show('blind', 500);
    });

    $('#googleMapURL').on("change", function() {
        var url = $('#googleMapURL').val();
        var LatLang = url.split("/");
        LatLang = LatLang[6].split(",");
        console.log(LatLang);
    });
    $('#checkall').on("click",function(){
        $(".checkmailsettings").prop("checked", true);
    });
    $('#uncheckall').on("click",function(){
        $(".checkmailsettings").prop("checked", false);
    });
//    $('#add-locname').click(function() {
//        scrollToElement('#step1', 300);
//    });
//
//    $('#choose-place').click(function() {
//        scrollToElement('#step2', 300);
//    });
//
//    $('#tostep3').click(function() {
//        scrollToElement('#step3', 300);
//    });

//    $('#tostep4').click(function() {
//        scrollToElement('#step4', 300);
//    });


//$('#passcode').modal();

//$('.collapse').collapse('toggle');





//    $('#country , #countrySearch').change(function(e) { //any select change on the dropdown with id country trigger this code
//        e.preventDefault();
//        var country = $('#country').val();
//        $.getJSON("/api/getCityByCountry/" + country, function(data) {
//
//            var html = '';
//            var len = data.length;
//            for (var i = 0; i < len; i++) {
//                html += '<option value="' + data[i].id + '"  data-value="' + data[i].city + '"  >' + data[i].city + '</option>';
//            }
//            $('select#city').show();
//            $('select#city').html("");
//            $('select#city').append(html);
//
//
//        });
//    });

    $(".locationType").on("change", function(e)
    {
        locationType(e);
    });


    $(".login-loc-login-home").on("click", function(e) {
        e.preventDefault();
        var identity = $("#identity").val();
        var password = $("#userpassword").val();
        $.post(site_url + "api/checkauth", {identity: identity, password: password}, function(data) {
            if (data == "true") {
                CreateLocation();
                return true;
                //result = '<a  onclick="CreateLocation()" class="btn btn-success btn-large" id="add-locname" href="#"> Register a New LocName </a>';
                //$("#finishing").html(result);
                //return true;
            }
            $("span.autherror").html(data);
            $("div.autherror").show();
        });
    });

    $('#is_eventXX').on("change", function(e) {
        var is_event = $('#is_event').is(":checked") ? 1 : 0;
        if (is_event) {
            $(".durationRow").show();
        } else {
            $(".durationRow").hide();
            $("#duration_from").val("");
            $("#duration_to").val("");
        }
    });

    $('#is_private').on("change", function(e) {
//        var is_private = $('#is_private').is(":checked") ? 1 : 0;
        var is_private = $('#is_private').val();
        if (is_private == 1) {
            $(".isPrivateRow").show();
        } else {
            $(".isPrivateRow").hide();
            $("#passcode").val("");

        }
    });

    $("#passcodeValidate").on("click", function() {
        $.ajax({
            type: "POST",
            url: site_url + "location/checkpass/",
            data: {passcode: $("#passcodeinput").val(), "title": $("#passLocationTitle").val()},
            success: function(data) {
                if (data == 1) {
                    $("#passcodecontainer").slideUp("slow", function() {
                        $("#locationContainer").slideDown();
                        $("#passcodecontainer").remove();
                        $("#infoMessage").slideUp();
                    });
                } else {
                    $("#infoMessage").slideDown();
                }
            }
        });
    });

    $('#check_name').hide();
    $('#bussinesstype').hide();
    $('#from').hide();
    $('#to').hide();
    $('#url').hide();

    $('#category').change(function(e) { //any select change on the dropdown with id country trigger this code
        e.preventDefault();
        var val = $('#category').val();
        //alert(val);
        if (val == 1)
        {
            $('#bussinesstype').show();
            $('#from').hide();
            $('#to').hide();
            $('#url').show();
        }
        else if (val == 2)
        {
            $('#bussinesstype').hide();
            $('#from').show();
            $('#to').show();
            $('#url').hide();
        }
        else
        {
            $('#bussinesstype').hide();
            $('#from').hide();
            $('#to').hide();
            $('#url').hide();
        }
    });

    $('#searchbtn').click(function(e) {
        e.preventDefault();
        var search = $('#searchtext').val();
        window.location.href = site_url + "/location/view/" + search;

        return;
        $.post("checkname", {name: search}, function(output) {
            if (output === 'available')
                $('#Error').show();
            else
                $(location).attr('href', search);
        });

    });
    $("#searchform").submit(function(e) {
        e.preventDefault();
        var search = $('#searchtext').val();
        window.location.href = site_url + search;
    });

    $('.locNamebox').keyup(function(e) {
        e.preventDefault();
        var title = $(this).val();
        $.post(site_url + "api/checkname", {title: title}, function(output) {

            if (output === 'available') {
                $('.name-available-not').hide();
                $('.name-available-yes').show();
                $("#address2").parent().css('margin-top', '31px');
            }

            else {
                $('.name-available-not').html('<i class="fa fa-times"> </i>' + output);
                $('.name-available-not').show();
                $('.name-available-yes').hide();
                $("#address2").parent().css('margin-top', '31px');
            }
        });
    });

    $("#title2").keyup(function(e) {
        e.preventDefault();
        var title = $(this).val();
        $.post(site_url + "api/checkname", {title: title}, function(output) {

            if (output === 'available') {
                $('.name-available-not').hide();
                $('.name-available-yes').show();
                $("#address4").parent().css('margin-top', '31px');
            }

            else {
                $('.name-available-not').html('<i class="fa fa-times"> </i>' + output);
                $('.name-available-not').show();
                $('.name-available-yes').hide();
                $("#address4").parent().css('margin-top', '31px');
            }
        });
    });


    /**
     * Search result
     * alert with not found if place not founded
     * redirect to location
     */

    $("form#topSearch").on("submit", function(e) {

        var title = $('form#topSearch input[name=title]').val();
        e.preventDefault();
        $.post(site_url + "api/checkname", {title: title}, function(output) {
            $('#check_name').html(output);
            $('#check_name').show();
            if (output === 'available') {

                $("#LocationNotFound").removeClass("hide").hide().slideDown();
            }
            else {
                $("#LocationNotFound").addClass("hide").slideUp();
                window.location.href = site_url + title;
                return true;
            }
        });
    });

    $("#regForm #first_name , #regForm #last_name").on("keyup", function(e) {
        var firstName = $("#regForm #first_name").val();
        var lastName = $("#regForm #last_name").val();
        var username = $("#regForm #username").val();
        //if(username !== "" && username !== (firstName + " " + lastName)) {
            $("#regForm #username").val(firstName + " " + lastName);
        //}
    });

    $('#regForm').validate({
        rules: {
            first_name: {
                minlength: 2,
                required: true
            },
            last_name: {
                minlength: 2,
                required: true
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: site_url + 'api/checkEmailValidation/',
                    type: "post"
                }
            },
            password: {
                minlength: 6,
                required: true
            },
            password_confirm: {
                equalTo: "#password_regform"
            },
            terms: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element.addClass('valid')
                    .closest('.control-group').removeClass('error').addClass('success');
        }
    });

    $("a#followUser").on("click", function(e) {
        $this = $(this);
        e.preventDefault();
        $.post(site_url + "user/follow", {user_id: $this.attr("userid")}, function(e) {
            $this.text("Followed");
        });
    });

    $(".InviteWithEmails").on("click", function(e) {
        e.preventDefault();
        var mails = $("#InvitedEmails").val();
        $.post(site_url + "/user/sendinvitationMail", {emails: mails}, function(e) {
            $("#InvitedEmails").val("");
            $("#InvitedEmailsMessage").show();
        });
    });

     $('#learn-enable-browser-location').on("click",function(){
        //Detect browser type
        var nVer = navigator.appVersion;
        var nAgt = navigator.userAgent;
        var browserName  = navigator.appName;
        var fullVersion  = ''+parseFloat(navigator.appVersion); 
        var majorVersion = parseInt(navigator.appVersion,10);
        var nameOffset,verOffset,ix;

        // In Opera 15+, the true version is after "OPR/" 
        if ((verOffset=nAgt.indexOf("OPR/"))!=-1) {
         $('#enable-for-opera').show();
        }
        // In older Opera, the true version is after "Opera" or after "Version"
        else if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
        $('#enable-for-opera').show();
        }
        // In MSIE, the true version is after "MSIE" in userAgent
        else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
            $('#enable-for-ie').show();
        }
        // In Chrome, the true version is after "Chrome" 
        else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
            $('#enable-for-chrome').show();
        }
        // In Safari, the true version is after "Safari" or after "Version" 
        else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
            $('#enable-for-safari').show();
        }
        // In Firefox, the true version is after "Firefox" 
        else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
            $('#enable-for-firefox').show();
        }
     });

});
//      #################      End of Document Ready  #############################################
function EmailValidation() {

    var $url = site_url + 'api/checkEmailValidation/';
    var isSuccess = false;
    $.ajax({
        type: "POST",
        url: $url,
        data: {email: $("#regForm #email").val()},
        async: false,
        success: function(data) {
            isSuccess = msg === "true" ? true : false;
            if (data !== "available") {
                $("#regForm #email").closest('.control-group').removeClass('success').removeClass('valid').addClass('error');

            }
        }

    });

    return isSuccess;
}


var geocoder = new google.maps.Geocoder();
var latitude = 0;
var longitude = 0;
var latLng;
var viewport;

function getaddress(pos) {
    geocoder.geocode({
        latLng: pos
    }, function(responses) {
        if (responses && responses.length > 0) {
            var address = responses[0].formatted_address;
            //  alert(responses[0].address_components[0].long_name);
            //  alert(responses[0].address_components[1].long_name);
            //  alert(responses[0].address_components[2].long_name);
            //  alert(responses[0].address_components[3].long_name);
            //  alert(responses[0].address_components[4].long_name);
            $("#address").val(address);
            $("#actual_address").val(address);
            // $("#details").val(address);
        } else {
            $('#address').text('Cannot determine address at this location.');
            //$('#details').text('Cannot determine address at this location.');
        }
    });
}

function updateMarkerPosition(latLng) {
    getaddress(latLng);
    latitude = latLng.lat();
    longitude = latLng.lng();

    $('#lat').val(latitude);
    $('#lat').html(latitude);

    $('#lng').val(longitude);
    $('#lng').html(longitude);
}

function initialize(gecode) {
    if (gecode === 0) {
        latLng = new google.maps.LatLng(latitude, longitude);
        getaddress(latLng);
    }

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 18,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    map.getCenter();
    
    if((gecode === 1)) {
        map.fitBounds(viewport);
    }

    var marker = new google.maps.Marker({
        position: latLng,
        title: 'Point A',
        map: map,
        draggable: true
    });

    google.maps.event.addListener(map, 'dblclick', function(event) {
        marker.position = event.latLng;
        updateMarkerPosition(event.latLng);
        getaddress(event.latLng);
    });

    google.maps.event.addListener(marker, 'dragend', function() {
        updateMarkerPosition(marker.getPosition());
        getaddress(marker.getPosition());
    });
}

function closeAllSteps() {
    $('#step1').addClass('hide');
    $('#step2').addClass('hide');
    $('#step3').addClass('hide');
    $('#step4').addClass('hide');
}

function getPosition(lat,lng) {
    closeAllSteps();
    showstep2();
    if(lat && lng){
        showPosition({coords:{latitude:lat,longitude:lng}});
    }
    else
   {
       //Auto Detect Code
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        }
        else {
            alert("Geolocation is not supported by this browser.");
        } //end of auto detect Code
    }
}

function showPosition(position) {

    latitude = position.coords.latitude;
    longitude = position.coords.longitude;

    $('#lat').val(latitude);
    $('#lat').html(latitude);

    $('#lng').val(longitude);
    $('#lng').html(longitude);

    initialize(0);
}

function geocodePosition() {
    showstep2();
    var search = "";
    if(jQuery.trim($('#country :selected').attr("data-value")) != ""){
        search = jQuery.trim($('#country :selected').attr("data-value"));    
        search += ",";
    }
    //var search = jQuery.trim($('#country :selected').attr("data-value"));
    if(jQuery.trim($('#city :selected').text()) != "Choose City"){
        search += jQuery.trim($('#city :selected').text());    
        search += ",";
    }
    //search += $('#city :selected').text();
    search += $("#searchKeywords").val().replace(/\s+/g, ' ');

    var lat = $('#lat').val();
    var lng = $('#lng').val();
    var url = $('#googleMapURL').val();
    
    if(search.length < 2) {
        if( lat != "" && lng != "" && !isNaN(lat) && !isNaN(lng) ) {
            search = lat + "," + lng;
        }
        else if (url.length > 10 && isUrl(url))
        {
            var LatLng = url.split("/");
            search = LatLng[6].split(",");
            search = search[0].replace("@", "") + "," + search[1];
        }
    }

    geocoder.geocode({
        'address': search
    }, function(responses) {
        if (responses && responses.length > 0) {
            //map.setCenter(responses[0].geometry.location);
            latLng = responses[0].geometry.location;
            viewport = responses[0].geometry.viewport;
            updateMarkerPosition(latLng);
            initialize(1);

        } else {
            $("#step2").addClass("hide");
            scrollToElement('#step1', 300);
            alert('Cannot determine address at this location.');
        }
    });
}

function showError(error) {
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
function showstep1() {
    closeAllSteps();
    $('#step1').removeClass('hide').show('blind', 1000);
    scrollToElement('#step1', 300);
}
function showstep2() {
    $('#step2').removeClass('hide').show('blind', 1000);
    scrollToElement('#step2', 300);
}
function showstep3() {
    $('#step3').removeClass('hide').show('blind', 1000);
    scrollToElement('#step3', 300);
}

function showstep4(checklogin) {
    if($('.name-available-not').is(':visible'))
        return false;

    var isvalid = addLocationValidate();

    if (isvalid == false)
        return false;

    checklogin = typeof checklogin !== 'undefined' ? checklogin : 0;

    if (checklogin == 0)
    {
        var data = [];

        data.push($('#AddLocation  .locNamebox').val() );
        data.push($('#AddLocation #lat').val() );
        data.push($('#AddLocation #lang').val() );
        data.push($('#AddLocation #details').val() );
        data.push($('#AddLocation #address').val() );
        data.push($('#AddLocation .locationType').val() );
        data.push($('#AddLocation #locationCategory').val() );
        data.push($('#AddLocation #duration_to').val() );
        data.push($('#AddLocation #duration_from').val() );
        data.push($('#AddLocation #passcode').val() );
        data.push($('#AddLocation #is_private').val() );
        data.push($('#AddLocation #is_event').is(":checked") ? 1 : 0 );
        data.push($('#AddLocation #mobile').val() );
        var myString = JSON.stringify(data);
        $.cookie('unSavedLocation', myString);
        $('#step4').removeClass('hide').show('blind', 1000);
            scrollToElement('#step4', 300);
    }
    else
    {
        CreateLocation();
    }
}

function getMyLocation(ToWherelng,ToWherelat)
{
    window.ToWherelng = ToWherelng;
    window.ToWherelat=ToWherelat;
  if(flag)
  {
      
    if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(showMyPosition);
        // $("#getmethere").click();
        flag=false;
    }
    else
    {
        alert("Geolocation is not supported by this browser.");
    }
  }
}

function showMyPosition(position)
{
     var directionsService = new google.maps.DirectionsService();
     var directionsDisplay = new google.maps.DirectionsRenderer();

     var map = new google.maps.Map(document.getElementById('map'), {
       zoom:7,
       mapTypeId: google.maps.MapTypeId.ROADMAP
     });

     directionsDisplay.setMap(map);
     directionsDisplay.setPanel(document.getElementById('directionsDiv'));
     var request = {
            origin: ""+position.coords.latitude+','+position.coords.longitude+"",
            destination: ""+window.ToWherelat+','+window.ToWherelng+"",
            travelMode: google.maps.DirectionsTravelMode.DRIVING
     };

     directionsService.route(request, function(response, status) {
       if (status == google.maps.DirectionsStatus.OK) {
         directionsDisplay.setDirections(response);
       }
     });  
    
}

function updatelocationCoordinates(lat, lng) {
    $("#latitude").val(lat);
    $("#longitude").val(lng);
}

function CreateLocation() {
    $("form#AddLocation").submit();
    return true;

    var title = $('#AddLocation .locNamebox').val();
    var lateVar = $('#AddLocation #lat').val();
    var langVar = $('#AddLocation #lng').val();
    var detailsVar = $('#AddLocation #details').val();
    var address = $('#AddLocation #address').val();
    var actual_address = $('#AddLocation #actual_address').val();
    var typeVar = $('#AddLocation .locationType').val();
    var categoryVar = $('#AddLocation #locationCategory').val();
    var duration_to = $('#AddLocation #duration_to').val();
    var duration_from = $('#AddLocation #duration_from').val();
    var passcode = $('#AddLocation #passcode').val();
    // var is_private = $('#is_private').is(":checked") ? 1 : 0;
    var is_private = $('#AddLocation #is_private').val();
    var is_event = $('#AddLocation #is_event').is(":checked") ? 1 : 0;
    var mobile = $('#AddLocation #mobile').val();
    var website = $('#AddLocation #locationWebsite').val();
    var email = $('#AddLocation #locationMail').val();
    var building_number = $('#AddLocation #building_number').val();
    var flat_number = $('#AddLocation #flat_number').val();
    var postal_code=$('#AddLocation #postal_code').val();
    
    $.post(site_url + "location/create", {
        title: title,
        latitude: lateVar,
        longitude: langVar,
        details: detailsVar,
        type: typeVar,
        category_id: categoryVar,
        is_private: is_private,
        passcode: passcode,
        duration_from: duration_from,
        duration_to: duration_to,
        is_event: is_event,
        mobile: mobile,
        address: address,
        actual_address: actual_address,
        email: email,
        website: website,
        building_number: building_number,
        flat_number: flat_number,
        postal_code:postal_code
    },
	function(result) {
        console.log(result);
        if (result == "true")
        {
            //window.location.href = site_url +"/location/view/"+title;
            $(location).attr('href', site_url + title);
        }
        else
        {
            // $(location).attr('href', '');
            $(".locregistererror").show();
            $(".locregistererror").html(result);
        }
	});
}

window.ParsleyConfig = {
    errorsWrapper: '<div></div>',
    errorTemplate: '<span class="required-error"></span>'
};

function addLocationValidate() {

    $('form#addLocation').validate({
        rules: {
            title: {
                minlength: 3,
                maxlength: 15,
                required: true
            },
            address: {
                minlength: 3,
                required: true
            },
//            details: {
//                minlength: 3,
//                required: true
//            },
            type: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).parents('.col-md-8').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parents('.col-md-8').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'required-error',
        errorPlacement: function(error, element) {

            if (element.parent('.col-md-8').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    var valid = $("#AddLocation").parsley().validate();
    return valid;
}

$(function() {
    $('#AddLocationXXX').submit(function(e) {
        e.preventDefault();
        if ($("#AddLocation").parsley('validate')) {
            $(this).submit();
        } else {
            return false;
        }
    });
});

function newPopup(url) {
    popupWindow = window.open(url, 'popUpWindow', 'height=500,width=600,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
}

/*function addToFavourites(location) {
    $.post(site_url + "favourite/test", {location: location}, function(data) {
        if (data == "true") {
            $("#addToFav").html("added successfully");
            return true;
        } else if (data == "founded") {

            return $("#addToFav").html("you have added this location before");
        }
		else { alert('aa'); }
        $("#addToFav").html("You have to logged in first .");
        $("#addToFav").attr("href", site_url + "/auth/login");
    });
}*/

function locationType(e) {

//    var parent = e.target.parentNode;
    var type = e.target.value;
//    console.log(type);
    if (type == "event") {
        $("#is_event").val("1");
        $(".durationRow").show();
        $(".durationRow").removeClass("hide");
    } else {
        $("#is_event").val("0");
        $(".durationRow").hide();
        $("#duration_from").val("");
        $("#duration_to").val("");
    }

    $.getJSON("/api/getCategoryByType/" + type, function(data) {
        var html = '';
        var len = data.length;
        for (var i = 0; i < len; i++) {
            html += '<option value="' + data[i].id + '"  data-value="' + data[i].title + '"  >' + data[i].title + '</option>';
        }
        $("#locationCategoryLbl").show();
        $(".locationCategoryDiv").show();
        $('select.locationCategory').show();
        $('select.locationCategory').html(html);
    });
}

function isUrl(string) {
    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return regexp.test(string);
}
//////////////////////////////////​
/*$('input#appendedInputButton').typeahead({
    source: function(query, process) {
        //console.log(query);
        var $url = site_url + 'api/autocompleteLocations/' + query;
        var $items = new Array;
        $items = [""];
        $.ajax({
            url: $url,
            dataType: "json",
            type: "GET",
            success: function(data) {
                console.log(data);
                $.map(data, function(data) {
                    var group;
                    group = {
                        id: data.id,
                        name: data.title,
                        country: data.country,
                        toString: function() {
                            return JSON.stringify(this);
                            //return this.app;
                        },
                        toLowerCase: function() {
                            return this.name.toLowerCase();
                        },
                        indexOf: function(string) {
                            return String.prototype.indexOf.apply(this.name, arguments);
                        },
                        replace: function(string) {
                            var value = '';
                            value += this.name;
                            value += ", " + this.country;
                            if (typeof (this.level) != 'undefined') {
                                value += ' <span class="pull-right muted">';
                                value += this.level;
                                value += '</span>';
                            }
                            return String.prototype.replace.apply('<p>' + value + '</p>', arguments);
                        }

                    };
                    $items.push(group);
                });

                process($items);
            }
        });
    },
    property: 'name',
    items: 10,
    minLength: 1,
    updater: function(item) {
        var item = JSON.parse(item);
        //console.log(item.name);
        $('#hiddenID').val(item.id);
		window.location = site_url+item.name;
        return item.name;
    }
});
/*var uber = {render: $.fn.typeahead.Constructor.prototype.render};
$.extend($.fn.typeahead.Constructor.prototype, {
    render: function(items) {
        uber.render.call(this, items);
        this.$menu.append('<li style="text-align:center;background-color:#efefef;padding-bottom:5px;padding-top:5px;"><a href="#" onclick="alert(123)">Show More</a></li>');
        return this;
    }
});*/
////////// Rating //////////
//we bind only to the rateit controls within the location div
$('#backing2b').bind('rated reset', function(e) {
    var ri = $(this);

    //if the use pressed reset, it will get value: 0 (to be compatible with the HTML range control), we could check if e.type == 'reset', and then set the value to  null .
    var value = ri.rateit('value');
    var locationID = ri.data('locationID'); // if the product id was in some hidden field: ri.closest('li').find('input[name="productid"]').val()
    console.log(value);

    //maybe we want to disable voting?
    ri.rateit('readonly', true);

    $.ajax({
        url: site_url + 'location/rate', //your server side script
        data: {id: locationID, value: value}, //our data
        type: 'POST',
        success: function(data) {
            $('#response').append('<li>' + data + '</li>');

        },
        error: function(jxhr, msg, err) {
            $('#response').append('<li style="color:red">' + msg + '</li>');
        }
    });
});

// Delete

//we bind only to the rateit controls within the products div
$('#ratings .rateit').bind('rated reset', function(e) {
    var ri = $(this);

    //if the use pressed reset, it will get value: 0 (to be compatible with the HTML range control), we could check if e.type == 'reset', and then set the value to  null .
    var value = ri.rateit('value');
    var locationID = ri.data('locationid'); // if the product id was in some hidden field: ri.closest('li').find('input[name="productid"]').val()
    console.log(locationID);
    //maybe we want to disable voting?
//         ri.rateit('readonly', true);

    $.ajax({
        url: site_url + 'location/rate',
        data: {locationID: locationID, value: value}, //our data
        type: 'POST',
        success: function(data) {
            $('#response').append('<li>' + data + '</li>');

        },
        error: function(jxhr, msg, err) {
            $('#response').append('<li style="color:red">' + msg + '</li>');
        }
    });
});


////////////////////////////review/////////////////////////
$('#addreview').click( function(e) {
    var review=$('#reviewarea').val().replace(/\s+/g, ' ');
    var locationID=$('#locationid').val();
    if(review !="" && review !=null && review!=" ")
    {
     $.ajax({
        url: site_url + 'location/review',
        data: {locationID: locationID, review: review}, //our data
        type: 'POST',
        success: function(data) {
            $('#response').append('<li>' + data + '</li>');
            $('#reviewarea').val("");

        },
        error: function(jxhr, msg, err) {
            $('#response').append('<li style="color:red">' + msg + '</li>');
        }
    });}
else e.preventDefault();
    });
    
 
//////////////////////

function passcodeRemoval() {
    document.querySelector("section.breadcrumbs").remove();
    var pp = document.querySelector(".main-container");
    pp.setAttribute("class", pp.className.replace("container", "") + " section-passcode");
}

////////////////////////
//////////////////////

// SCROLLTO FUNCTION
function scrollToElement(selector, time, verticalOffset) {
    time = typeof (time) != 'undefined' ? time : 1000;
    verticalOffset = typeof (verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = $(selector);
    offset = element.offset();
    offsetTop = offset.top - 100 + verticalOffset;
    $('html, body').animate({
        scrollTop: offsetTop
    }, time);
}

function resetFile() {
    var control = $("#photo");
    control.replaceWith( control = control.clone( true ) );
}

function validateFileType(fileName) {
    type = fileName.substr(fileName.lastIndexOf(".") + 1);
    if(type !== "jpg" && type !== "jpeg" && type !== "png" && type !== "gif")
    {
        alert("Invalid File Type. Please Select a Valid File...");
        resetFile();
    }
}
function gallery(e){
    if(e.files && e.files[0]){
        for (var i = 0; i < e.files.length; i++){
            var type = e.files[i].name.substr(e.files[i].name.lastIndexOf(".") + 1);
            if(type !== "jpg" && type !== "jpeg" && type !== "png" && type !== "gif")
            {
                $("#files-names ul").append("<li style='color:red;'>" + e.files[i].name + "</li>");    
            }else{
                $("#files-names ul").append("<li>" + e.files[i].name + "</li>");    
            }
        }
    }
}
function pullAjax() {
    var a;
    try {
        a = new XMLHttpRequest();
    } catch (b) {
        try {
            a = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (b) {
            try {
                a = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (b) {
                alert("Your browser broke!");
                return false;
            }
        }
    }
    return a;
}

function populate_cities(x, url) {
    obj = pullAjax();
    var cities_list = document.getElementById('city');
    obj.onreadystatechange = function() {
        if (obj.readyState === 4) {
            var tmp = obj.responseText;
            if (tmp !== "") {
                cities = tmp.split(',');
                clean_cities(cities_list);
                if (cities.length > 0) {
                    for (var i = 0; i < cities.length; i++) {
                        if (cities[i] !== "") {
                            citiessep = cities[i].split(':');
                            append_city(citiessep[0], citiessep[1]);
                        }
                    }
                }
            }
        }
    };
    obj.open("GET", url + "/" + x.value, true);
    obj.send(null);
}

function append_city(city_text, city_value) {
    var cities_list = document.getElementById('city');
    cities_list.options[cities_list.options.length] = new Option(city_text, city_value, false, false);
}

function clean_cities() {
    var cities_list = document.getElementById('city');
    cities_list.options.length = 1;
}

function getLocation(){
    if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(showPos,showErr);
    }
    else{
        document.getElementById('geolocerror').style.display = 'block';
        document.getElementById('geolocation-error').innerHTML="Geolocation is not supported by this browser.";
    }
}
function showPos(position)
  {}
function showErr(error)
  {
      document.getElementById('geolocerror').style.display = 'block';
  switch(error.code) 
    {
    case error.PERMISSION_DENIED:
      document.getElementById('geolocation-error').innerHTML="You have to enable the browser location.";
      break;
    case error.POSITION_UNAVAILABLE:
      document.getElementById('geolocation-error').innerHTML="Location information is unavailable.";
      break;
    case error.TIMEOUT:
      document.getElementById('geolocation-error').innerHTML="The request to get user location timed out.";
      break;
    case error.UNKNOWN_ERROR:
      document.getElementById('geolocation-error').innerHTML="An unknown error occurred.";
      break;
    }
  }