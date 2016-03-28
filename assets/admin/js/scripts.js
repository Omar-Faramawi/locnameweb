$(document).ready(function() {



    $('.datetimepicker').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
    });

    $('#add-locname').click(function() {
        $('#step1').show('blind', 500);
    });



    $('#add-locname').click(function() {
        scrollToElement('#step1', 300);
    });

    $('#choose-place').click(function() {
        scrollToElement('#step2', 300);
    });

    $('#tostep3').click(function() {
        scrollToElement('#step3', 300);
    });

    $('#tostep4').click(function() {
        scrollToElement('#step4', 300);
    });


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
            $(".autherror").html(data);
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
            },
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
            if (output == 'available')
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
        var title = $('#title').val();
        $.post(site_url + "/api/checkname", {title: title}, function(output) {
            $('#check_name').html(output);
            $('#check_name').show();
            if (output == 'available')
                $('#check_name').attr('class', 'label label-success span1 inline-note');
            else
                $('#check_name').attr('class', 'label label-important span1 inline-note');
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
        $.post(site_url + "/api/checkname", {title: title}, function(output) {
            $('#check_name').html(output);
            $('#check_name').show();
            if (output == 'available') {

                $("#LocationNotFound").show();
            }
            else {
                $("#LocationNotFound").hide("fast");
                window.location.href = site_url + title;
                return true;
            }


        });
    });



    $("#registerForm #first_name , #registerForm #last_name").on("keyup", function(e) {
        var firstName = $("#registerForm #first_name").val();
        var lastName = $("#registerForm #last_name").val();
        var username = firstName + lastName;
        $("#registerForm #username").val(username.replace(/\s+/g, ''));
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
    
    $(".InviteWithEmails").on("click" , function() {
         var mails = $("#InvitedEmails").val();
         $.post(site_url + "/user/sendinvitationMail" , { emails : mails  }  , function(e){
                $("#InvitedEmails").val("");
                $("#InvitedEmailsMessage").show();
         });
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
            if (data != "available") {
                $("#regForm #email").closest('.control-group').removeClass('success').removeClass('valid').addClass('error');

            }
        }

    });

    return isSuccess;
}


var geocoder = new google.maps.Geocoder();
var latitude = 37.4419;
var longtude = 122.1419;
var latLng;

function getaddress(pos) {
    geocoder.geocode({
        latLng: pos
    }, function(responses) {
        if (responses && responses.length > 0) {
            var address = responses[0].formatted_address;
            //  alert(responses[0].address_components[0].long_name);
            //   alert(responses[0].address_components[1].long_name);
            //  alert(responses[0].address_components[2].long_name);
            //  alert(responses[0].address_components[3].long_name);
            //  alert(responses[0].address_components[4].long_name);
            $("#address").val(address);
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
    longtude = latLng.lng();

    $('#lat').val(latitude);
    $('#lat').html(latitude);

    $('#lang').val(longtude);
    $('#lang').html(longtude);

}

function initialize(gecode) {
    if (gecode == 0)
    {
        latLng = new google.maps.LatLng(latitude, longtude);
        getaddress(latLng);
    }

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 18,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var marker = new google.maps.Marker({
        position: latLng,
        title: 'Point A',
        map: map,
        icon: "assets/main/img/LocPin.png",
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

function getPosition() {
    showstep2();
    //Auto Detect Code 
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    }
    else {
        alert("Geolocation is not supported by this browser.");
    } //end og auto detect Code 
}

function showPosition(position) {


    latitude = position.coords.latitude;
    longtude = position.coords.longitude;

    $('#lat').val(latitude);
    $('#lat').html(latitude);

    $('#lang').val(longtude);
    $('#lang').html(longtude);

    initialize(0);
}

function geocodePosition() {
    showstep2();
    var search = $('#country :selected').attr("data-value");
    search += ",";
    search += $('#city :selected').attr("data-value");
    search += ",";
    search += $("#searchKeywords").val();


    geocoder.geocode({
        'address': search
    }, function(responses) {
        if (responses && responses.length > 0) {
            //map.setCenter(responses[0].geometry.location);
            latLng = responses[0].geometry.location;
            updateMarkerPosition(latLng);
            initialize(1);

        } else {
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
function showstep2() {
    $('#step2').show('blind', 1000);
}
function showstep3() {
    $('#step3').show('blind', 1000);
}

function showstep4(checklogin) {
    var isvalid = addLocationValidate();

    if (isvalid == false)
        return false;
		
    checklogin = typeof checklogin !== 'undefined' ? checklogin : 0;

    if (checklogin == 0)
	{
        $('#step4').show('blind', 1000);
		scrollToElement('#step4', 300);
	}
    else
    {
        CreateLocation();
    }
}


function getMyLocation(ToWhere)
{


    window.ToWhere = ToWhere;
    if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(showMyPosition);
//        $("#getmethere").click();

    }
    else {
        alert("Geolocation is not supported by this browser.");
    }



}                                  
function showMyPosition(position)
{

    var innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;
    // $("input#current-lat").val(position.coords.latitude);
    //$("input#current-long").val(position.coords.longitude);
    var href = site_url + "location/takeme/" + window.ToWhere + "?lat=" + position.coords.latitude + "&long=" + position.coords.longitude;
    $("#getmethere").attr("href", href);
    location.href = href;
}




function CreateLocation() {

    var title = $('#AddLocation  .locNamebox').val();
    var lateVar = $('#AddLocation #lat').val();
    var langVar = $('#AddLocation  #lang').val();
    var detailsVar = $(' #AddLocation #details').val();
    var address = $('#AddLocation  #address').val();
    var typeVar = $('#AddLocation  .locationType').val();
    var categoryVar = $('#AddLocation  #locationCategory').val();
    var duration_to = $('#AddLocation  #duration_to').val();
    var duration_from = $('#AddLocation  #duration_from').val();
    var passcode = $('#AddLocation  #passcode').val();
    // var is_private = $('#is_private').is(":checked") ? 1 : 0;
    var is_private = $('#AddLocation #is_private').val();
    var is_event = $('#AddLocation #is_event').is(":checked") ? 1 : 0;
    var mobile = $('#AddLocation #mobile').val();

    $.post(site_url + "/location/create", {
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
    },
            function(result) {

                if (result == "true")
                {
                    //window.location.href = site_url +"/location/view/"+title;
                    $(location).attr('href', site_url + title);
                }
                else {
                    // $(location).attr('href', '');
//                    alert(result);
                    $(".locregistererror").show();
                    $(".locregistererror").html(result);
                }

            });

}

function addLocationValidate() {
    $('form#addLocation').validate({
        rules: {
            title: {
                minlength: 3,
                maxlength: 15,
                required: true
            },
            details: {
                minlength: 3,
                required: false
            },
            type: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    var valid = $("#AddLocation").parsley('validate');
	return valid;
}

$(function() {
    $('#AddLocation').submit(function(e) {
        e.preventDefault();
        if ($("#AddLocation").parsley('validate')) {
            $(this).submit();
        } else {
            return false;
        }
    });
});

function newPopup(url) {
    popupWindow = window.open(
            url, 'popUpWindow', 'height=500,width=600,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}


function addToFavourites(location) {

    $.post(site_url + "/favourite/create", {location: location}, function(data) {
        if (data == "true") {
            $("#addToFav").html("added successfully");
            return true;
        } else if (data == "founded") {

            return $("#addToFav").html("you have added this location before");
        }

        $("#addToFav").html("You have to logged in first .");
        $("#addToFav").attr("href", site_url + "/auth/login");

    });

}


function updatelocationCoordinates(lat, lng) {
    $("#latitude").val(lat);
    $("#longitude").val(lng);
}



function locationType(e) {

//    var parent = e.target.parentNode;
    var type = e.target.value;
//    console.log(type);
    if (type == "event") {
        $("#is_event").val("1");
        $(".durationRow").show();
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
        $('select.locationCategory').show();
//        $('select.locationCategory').html("");
        $('select.locationCategory').html(html);
    });
}

//////////////////////////////////

$('#appendedInputButton').typeahead({
    source: function(query, process) {
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
    minLength: 2,
    updater: function(item) {
        var item = JSON.parse(item);
        console.log(item.name);
        $('#hiddenID').val(item.id);
        return item.name;
    }
});


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

//////////////////////

// SCROOLTO FUNCTION
function scrollToElement(selector, time, verticalOffset) {
    time = typeof (time) != 'undefined' ? time : 1000;
    verticalOffset = typeof (verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = $(selector);
    offset = element.offset();
    offsetTop = offset.top + verticalOffset;
    $('html, body').animate({
        scrollTop: offsetTop
    }, time);
}
$(document).ready(function($) {
    $('#directionsDiv').perfectScrollbar({
        wheelSpeed: 20,
    });
});
