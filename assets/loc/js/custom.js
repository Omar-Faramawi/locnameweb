jQuery(document).ready(function ($) {
    if($(window).width() <= 750) {
        $("#location-header").remove().insertAfter($("#location-map"));
    } else {
        $("#location-header").remove().insertBefore($("#location-map"));
    }

    $('#moreInfoClick').click(function(){
        $("#writeReview ul li:nth-child(1)").removeClass("active");
        $("#writeReview ul li:nth-child(2)").addClass("active");
        $("#writeReview .sec-body .tab-content #reviews").removeClass("active in");
        $("#writeReview .sec-body .tab-content #details").addClass("active in");
        //window.location="#writeReview";
        $('html,body').animate({
         scrollTop: $("#writeReview").offset().top - 120},
        'slow');
    });
    $('#embedMap').click(function (event) {
        event.preventDefault();
        var locationTitle = $(this).attr('locationTitle') + '/';
        var mapType = $('select[name="type"]').val() + '/';
        var zoom = $('select[name="zoom"]').val() + '/';
        var width = $('input[name="width"]').val() + '/';
        var height = $('input[name="height"]').val();
        var iframeLink = site_url + 'location/share/' + locationTitle + mapType + zoom + width + height;
        $('#embeded-map-section').show();
        $('#embeded-map .col-md-12').text('<iframe src="' + iframeLink + '"></iframe>');
    });
    if (user_id !== false) {
        if ($.cookie('unSavedLocation')) {
            var contents = $.cookie('unSavedLocation');
            console.log(contents);
            var data = jQuery.parseJSON(contents);
            var title = data[0];
            var lateVar = data[1];
            var langVar = data[2];
            var detailsVar = data[3];
            var address = data[4];
            var actual_address = data[5];
            var typeVar = data[6];
            var categoryVar = data[7];
            var duration_to = data[8];
            var duration_from = data[9];
            var passcode = data[10];
            var is_private = data[11];
            var is_event = data[12];
            var mobile = data[13];
            var website = data[14];
            var email = data[15];
            var building_number = data[16];
            var flat_number = data[17];
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
                    flat_number: flat_number
                },
                function (result) {
                    if (result == "true") {
                        $(location).attr('href', site_url + title);
                    }
                    else {
                        // $(location).attr('href', '');
                        $(".locregistererror").show();
                        $(".locregistererror").html(result);
                    }
                });
            $.removeCookie('unSavedLocation');
        }
    }
    $("#facebook_sync").click(function () {
        jQuery(".panel-pop-facebook").show().animate({"top": "25%"}, 500);
        $.get(site_url + "api/facebook_friends", function (data) {
            if (data && !data.message) {
                $('.panel-pop-facebook').empty();
                $('.panel-pop-facebook').prepend("<h3>Facebook Friends</h3>");
                $('<div/>', {
                    class: 'aleady-on',
                    text: data.length + " Friend added !"
                }).appendTo('.panel-pop-facebook');
            }
            else {
                $('.panel-pop-facebook').empty();
                $('<div/>', {
                    class: 'aleady-on',
                    text: "You currently don't have any Facebook Friends who are using LocName."
                }).appendTo('.panel-pop-facebook');
            }
        });
        jQuery("body").prepend("<div class='wrap-pop'></div>");
        wrap_pop();
    });

    $("#google_sync").click(function () {
        jQuery(".panel-pop-google").show().animate({"top": "25%"}, 500);
        $(".panel-pop-google").load(site_url + "api/google_connect", function (response, status, xhr) {
            if (xhr.status != "200") {
                $('.panel-pop-google').empty();
                $('<div/>', {
                    id: "google-error-message",
                    class: 'error-message'
                }).appendTo('.panel-pop-google');
                $("#google-error-message").html("This account is not linked to any Google+ Account");
            }
            else {
                $.get(site_url + "api/google_friends", function (data) {
                    if (data) {
                        $('.panel-pop-google').empty();
                        $('.panel-pop-google').prepend("<h3>Google+ Friends</h3>");
                        if (data[0] >= 0) {
                            $('<div/>', {
                                class: 'aleady-on',
                                text: data[0] + " Friend added !"
                            }).appendTo('.panel-pop-google');
                        }
                        if (data[1] > 0) {
                            $('.panel-pop-google').append("<h3>Do you like to invite more friends to share the fun with them ? ;)</h3>");
                            $('<div/>', {
                                id: "google_invite",
                                class: 'btn btn-success',
                                text: "Yes , Invite them All"
                            }).appendTo('.panel-pop-google');
                            $('<div/>', {
                                class: 'hide-popup btn btn-warning',
                                text: "No , Thanks"
                            }).appendTo('.panel-pop-google');
                        }
                    }
                    else {
                        $('.panel-pop-google').empty();
                        $('<div/>', {
                            class: 'aleady-on',
                            text: "No Friends were added"
                        }).appendTo('.panel-pop-google');
                    }
                });
            }
        });

        jQuery("body").prepend("<div class='wrap-pop'></div>");
        wrap_pop();
    });

    $('#do_manual_invite').click(function() {
        var emails = document.getElementById("emailsToInvite").value;

        $.post(site_url + "api/do_manual_invite", {emails: emails}, function(result) {
            console.log(result);
            alert("You have successfully invited " + result + " friend(s)");
            $('#suggestionsModal').modal('hide');
        });
    });

    $('#do_google_invite').click(function() {
        var chk_arr =  document.getElementsByName("invite_emails[]");
        var emails = [];

        for(i = 0; i < chk_arr.length; i++) {
            if(chk_arr[i].checked == true) {
                emails.push(chk_arr[i].value);
            }
        }

        $.post(site_url + "api/do_google_invite", {emails: emails}, function(result) {
            //console.log(result);
            alert("You have successfully invited " + result + " friend(s)");
            jQuery(".wrap-pop").hide();
            jQuery(".panel-pop-invite").hide();
            wrap_pop();
        });
    });
    /*Invite windows Live friends*/
    $("#ifwl").click(function(){
         openDialog("https://login.live.com/oauth20_authorize.srf?client_id=0000000040156539&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri=http://dev.locname.com/user/friends", "Windows Live Invite", 'height=600,width=600', function(data){

         });
    });
    /*Invite google friends*/
    $('#ifg, #ifg2').click(function () {
        openDialog(site_url + "api/google_connect?close=1", "Google Invite", 'height=600,width=600', function () {
            $.get(site_url + "api/google_invite", function (data) {
                console.log(data);
                var content = "";
                for(var i = 0; i < data.length; i++) {
                    if(data[i] !== "") {
                        content += "<input type='checkbox' name='invite_emails[]' value='" + data[i] + "' />" + data[i] + "<br />";
                    }
                }
                $('#invite_emails').html(content);

                jQuery(".wrap-pop").hide();
                jQuery(".panel-pop-invite").show().animate({"top": "30%"}, 500);
                jQuery("body").prepend("<div class='wrap-pop' style='top:0;'></div>");
                wrap_pop();
                return false;
            });
        });
    });

    var openDialog = function (uri, name, options, closeCallback) {
        var win = window.open(uri, name, options);
        var interval = window.setInterval(function () {
            try {
                if (win == null || win.closed) {
                    window.clearInterval(interval);
                    closeCallback(win);
                }
            }
            catch (e) {
            }
        }, 1000);
        return win;
    };
    /**/
    $('body').on('click', '.hide-popup', function () {
        $(this).parents(".panel-pop").hide('slow');
        $('.wrap-pop').hide('fast');
        $('.hide-popup').click();
    });
    $('body').on('click', '#google_invite', function () {
        $.post(site_url + "api/google_invite", function (data) {
            console.log(data[0]);
            if (data[0] > 0) {
                $('.hide-popup').click();
            }
            else {
                $('#google-error-message').text("Error , Please try again later.");
            }

        });
    });
    $("footer a[href='#']").on("click", function (e) {
        e.preventDefault();
        alert("Coming Soon");
    });
    ///  End Amr Soliman

    jQuery(".panel-pop").each(function () {
        var panel_pop = jQuery(this);
        var panel_pop_h = panel_pop.outerHeight();
        panel_pop.css({"margin-top": -panel_pop_h / 2});
    });

    jQuery(".navigation > ul > li.welcome").each(function () {
        var jQuerysublist = jQuery(this).find('ul:first');
        jQuery(this).hover(function () {
                jQuerysublist.stop().css({overflow: "hidden", height: "auto", display: "none"}).slideDown(200, function () {
                    jQuery(this).css({overflow: "visible", height: "auto"});
                });
            },
            function () {
                jQuerysublist.stop().slideUp(200, function () {
                    jQuery(this).css({overflow: "hidden", display: "none"});
                });
            });
    });

    /* feedback */
    jQuery("#open-feedback").click(function () {
        jQuery(".panel-pop-login").hide().animate({"top": "-100%"}, 500);
        jQuery(".panel-pop-register").hide().animate({"top": "-100%"}, 500);
        jQuery('.wrap-pop').hide();
        jQuery(".panel-pop-feedback").css('left', '45%');
        jQuery(".panel-pop-feedback").show().animate({"top": "50%"}, 500);
        jQuery("body").prepend("<div class='wrap-pop' style='top:0;'></div>");
        wrap_pop();
        return false;
    });


    /* Login */
    jQuery("li.login > a").click(function () {
        jQuery(".panel-pop-login").show().animate({"top": "50%"}, 500);
        jQuery("body").prepend("<div class='wrap-pop'></div>");
        wrap_pop();
        return false;
    });

    /* Register */
    jQuery(".register_popup").click(function () {
        jQuery(".panel-pop.panel-pop-login").hide();
        jQuery(".wrap-pop").hide();
        jQuery(".panel-pop-register").show().animate({"top": "50%"}, 500);
        jQuery("body").prepend("<div class='wrap-pop' style='top:0;'></div>");
        wrap_pop();
        return false;
    });

    function wrap_pop() {
        jQuery(".wrap-pop").click(function () {
            jQuery(".panel-pop,.video-popup,.panel-pop-report").animate({"top": "-100%"}, 500).hide(function () {
                jQuery(this).animate({"top": "-100%"}, 500);
            });
            if (jQuery(this).hasClass("wrap-pop-video")) {
                player.pauseVideo();
            }
            jQuery(this).remove();
        });
    }

    /* section-recent */
    var vids = jQuery(".section-recent ul .col-md-6");
    for (var i = 0; i < vids.length; i += 4) {
        vids.slice(i, i + 4).wrapAll('<li></li>');
    }

    if (jQuery(".section-recent").length) {
        jQuery(".section-recent ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: false});
    }

    /* Accordion & Toggle */
    jQuery(".accordion .accordion-title").each(function () {
        jQuery(this).click(function () {
            if (jQuery(this).parent().parent().hasClass("toggle-accordion")) {
                jQuery(this).parent().find("li:first .accordion-title").addClass("active");
                jQuery(this).toggleClass("active");
                jQuery(this).next(".accordion-inner").slideToggle();
            } else {
                if (jQuery(this).next().is(":hidden")) {
                    jQuery(this).parent().parent().find(".accordion-title").removeClass("active").next().slideUp(200);
                    jQuery(this).toggleClass("active").next().slideDown(200);
                }
            }
            return false;
        });
    });

    /* testimonials */
    if (jQuery(".testimonials-slide").length) {
        jQuery(".testimonials-slide ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true});
    }

    /* last-news */
    if (jQuery(".last-news").length) {
        jQuery(".last-news ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true});
    }

    /* last-news */
    jQuery(".section-4-number").each(function () {
        jQuery(this).appear(function () {
            var endNum = parseInt(jQuery(this).find(".section-number").text());
            jQuery(this).find(".section-number").countTo({
                from: 0,
                to: endNum,
                speed: 4000,
                refreshInterval: 60
            });
        }, {accX: 0, accY: 0});
    });

    /* member-page-sidebar-recent */
    if (jQuery(".member-page-sidebar-recent").length) {
        jQuery(".member-page-sidebar-recent ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true});
    }

    var vids = jQuery(".member-page-sidebar-recent-2 ul .recent-loc");
    for (var i = 0; i < vids.length; i += 2) {
        vids.slice(i, i + 2).wrapAll('<li></li>');
    }

    if (jQuery(".member-page-sidebar-recent-2").length) {
        jQuery(".member-page-sidebar-recent-2 ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true});
    }

    var vids = jQuery(".member-page-members ul .section-members");
    for (var i = 0; i < vids.length; i += 4) {
        vids.slice(i, i + 4).wrapAll('<li></li>');
    }

    if (jQuery(".member-page-members").length) {
        jQuery(".member-page-members ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true});
    }

    if (jQuery(".section-content-images").length) {
        jQuery(".section-content-images ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true, pagerCustom: ".bx-pager"});
    }

    if (jQuery(".section-content-images-2").length) {
        jQuery(".section-content-images-2 ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true, pagerCustom: ".bx-pager"});
    }

    if (jQuery(".slide-about").length) {
        jQuery(".slide-about ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true});
    }

    jQuery(".testimonials-slide-2 li").each(function () {
        var testimonials = jQuery(this);
        var testimonials_w = testimonials.outerWidth();
        var testimonials_img = jQuery(".testimonials-img", testimonials).parent();
        testimonials_img.css({"margin-left": (testimonials_w - testimonials_img.outerWidth()) / 2});
    });

    if (jQuery(".testimonials-slide-2").length) {
        jQuery(".testimonials-slide-2 ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true});
    }

    jQuery("ul.tabs").tabs(".tab-inner-warp", {effect: "slide", fadeInSpeed: 100});

    jQuery(".about-video").click(function () {
        jQuery(".video-popup").show().animate({"top": "50%"}, 500);
        jQuery("body").prepend("<div class='wrap-pop wrap-pop-video'></div>");
        wrap_pop();
        return false;
    });

    var video_none = jQuery(".video-popup");
    var video_none_w = jQuery(".video-popup").outerWidth();
    var video_none_h = jQuery(".video-popup").outerHeight();
    video_none.css({"margin-top": -(video_none_h) / 2, "margin-left": -(video_none_w) / 2});

    if (jQuery(".progressbar-percent").length) {
        jQuery(".progressbar-percent").each(function () {
            var $this = jQuery(this);
            var percent = $this.attr("attr-percent");
            $this.bind("inview", function (event, isInView, visiblePartX, visiblePartY) {
                if (isInView) {
                    $this.animate({ "width": percent + "%"}, percent * 20);
                }
            });
        });
    }

    var vids = jQuery(".related-locations ul .related-locations-item");
    for (var i = 0; i < vids.length; i += 2) {
        vids.slice(i, i + 2).wrapAll('<li></li>');
    }

    if (jQuery(".related-locations").length) {
        jQuery(".related-locations ul").bxSlider({slideWidth: 1140, moveSlides: 1, maxSlides: 1, auto: true});
    }

    jQuery(".report-this").click(function () {
        jQuery(".panel-pop-report").show().animate({"top": "50%"}, 500);
        jQuery("body").prepend("<div class='wrap-pop'></div>");
        wrap_pop();
        return false;
    });
    jQuery(".share-this").click(function () {
        jQuery(".panel-pop-sharing").show().animate({"top": "50%"}, 500);
        jQuery("body").prepend("<div class='wrap-pop'></div>");
        wrap_pop();
        return false;
    });
     jQuery("#share").click(function () {
        $("#share").text("Sharing ...");
        $('#share').prop('disabled', true);
         var friends=[];
         var user = $("#user").val();
         var loc=$("#location").val();
        $('#friends input:checked').each(function() {
           friends.push(this.value);
        });
        $.post(site_url + "api/share_location", {friends:friends,user:user,location:loc}, function(result) {
            console.log(result);
            $("#share").text("Share");
            $('#share').prop('disabled', false);
            jQuery(".panel-pop-sharing").hide().animate({"top": "50%"}, 500);
            jQuery(".wrap-pop").remove();
            alert("You have successfully shared location " + result + " with your friend(s)");
        });

        return false;
    });

    jQuery(".form-js").submit(function () {
        var whatsubmit_l = true;
        var thisform = jQuery(this);
        jQuery('.required-error', thisform).remove();
        jQuery('.required-item', thisform).each(function () {
            var required = jQuery(this);
            if (required.val() === "") {
                required.after('<span class=required-error>Please fill the required field.</span>');
                whatsubmit_l = false;
            }
        });
        return whatsubmit_l;
    });

    jQuery(".file-fake").change(function () {
        var file_fake = jQuery(this);
        file_fake.parent().find(".button").text(file_fake.val());
    });

    jQuery(".privacy").change(function () {
        var privacy = jQuery(this);
        if (privacy.val() == 1) {
            privacy.parent().parent().parent().find(".passcode").slideDown();
        } else {
            privacy.parent().parent().parent().find(".passcode").slideUp();
        }
    });

    jQuery(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });

    jQuery(".location-typeXX").change(function () {

        var type = jQuery(this);
        if (type.val() == "business") {
            type.parent().parent().parent().find(".locationBusiness").slideDown();
            type.parent().parent().parent().find(".locationPersonal").slideUp();
            type.parent().parent().parent().find(".event-all").slideUp();
        } else if (type.val() == "personal") {
            type.parent().parent().parent().find(".locationBusiness").slideUp();
            type.parent().parent().parent().find(".locationPersonal").slideDown();
            type.parent().parent().parent().find(".event-all").slideUp();
        } else if (type.val() == "event") {
            type.parent().parent().parent().find(".locationBusiness").slideUp();
            type.parent().parent().parent().find(".locationPersonal").slideUp();
            type.parent().parent().parent().find(".event-all").slideDown();
        } else {
            type.parent().parent().parent().find(".locationBusiness").slideUp();
            type.parent().parent().parent().find(".locationPersonal").slideUp();
            type.parent().parent().parent().find(".event-all").slideUp();
        }
    });

    /* Header fixed */
    var aboveHeight = jQuery('.header-nav').outerHeight();
    var disabledSticky = jQuery('.header-nav').hasClass('disabled-sticky');
    if (!disabledSticky) {
        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() > aboveHeight) {
                jQuery('.header-nav').css({'top': '0'}).addClass('fixed-nav');
            } else {
                jQuery('.header-nav').css({'top': 'auto'}).removeClass('fixed-nav');
            }
        });
    } else {
        jQuery('.header-nav').removeClass('fixed-nav');
    }

    var window_w = jQuery(window).width();
    /* animated */
    jQuery(".animated").each(function () {
        var $this = jQuery(this);
        var animated = $this.attr("animate_attr");
        $this.bind("inview", function (event, isInView, visiblePartX, visiblePartY) {
            if (isInView) {
                $this.css("visibility", "visible");
                $this.addClass(animated);
                if (animated.indexOf("fade") === -1) {
                    $this.css("opacity", "1");
                }
            }
        });
    });

    /* fixed header */
    var thinHeaderH = $('#top-thin-bar').outerHeight();
    $(window).scroll(function () {
        checkScrollTop();
    });

    $(window).resize(function () {
        checkScrollTop();
    });

    checkScrollTop();
    function checkScrollTop() {
        if ($(window).width() >= 991) {
            if ($(window).scrollTop() >= thinHeaderH) {
                $('body').addClass('fixed-header');
            }
            if ($(window).scrollTop() < thinHeaderH) {
                $('body').removeClass('fixed-header');
            }
        } else {
            $('body').removeClass('fixed-header');
        }
    }

    /* why-locname */
    var slider = $('.section-2 .why-slider .slides'),
        sliderLeft = parseInt(slider.css('left')),
        slideW = slider.children().outerWidth(),
        crtSlide = 1,
        bulletIndex = 1;

    slider.children().outerWidth(slideW);
    slider.width(slideW * slider.children().length);
    slider.children().show();

    $(window).resize(function () {
        slideW = $('.why-slider').outerWidth();
        slider.children().outerWidth(slideW);
        slider.width(slideW * slider.children().length);
        slider.css('left', (1 - crtSlide) * slideW);
    });

    $('.section-2 .why-slider .why-arrow-right').click(function () {
        whySliderRight();
    });

    $('.section-2 .why-slider .why-arrow-left').click(function () {
        whySliderLeft();
    });

    function whySliderRight(steps) {
        steps = steps || 1;
        if (!slider.is(':animated') && crtSlide != slider.children().length) {
            $('.section-2 .bullets li').removeClass('current');
            $('.section-2 .bullets li').eq(crtSlide + steps - 1).addClass('current');
            $('.section-2 .why-slider .why-arrow-left').removeClass('disabled');
            sliderLeft = parseInt(slider.css('left'));
            slider.animate({left: sliderLeft - slideW * steps}, 800, function () {
                crtSlide += steps;
                if (crtSlide == slider.children().length) $('.section-2 .why-slider .why-arrow-right').addClass('disabled');
            });
        }
    }

    function whySliderLeft(steps) {
        steps = steps || 1;
        if (!slider.is(':animated') && crtSlide != 1) {
            $('.section-2 .bullets li').removeClass('current');
            $('.section-2 .bullets li').eq(crtSlide - 2 - steps + 1).addClass('current');
            $('.section-2 .why-slider .why-arrow-right').removeClass('disabled');
            sliderLeft = parseInt(slider.css('left'));
            slider.animate({left: sliderLeft + slideW * steps}, 800, function () {
                crtSlide -= steps;
                if (crtSlide == 1) $('.section-2 .why-slider .why-arrow-left').addClass('disabled');
            });
        }
    }

    $('.section-2 .bullets li').click(function () {
        bulletIndex = $('.section-2 .bullets li').index($(this)) + 1;
        if (!slider.is(':animated') && crtSlide != bulletIndex) {
            if (bulletIndex > crtSlide) {
                console.log(bulletIndex - crtSlide);
                whySliderRight(bulletIndex - crtSlide);
            } else {
                console.log(crtSlide - bulletIndex);
                whySliderLeft(crtSlide - bulletIndex);
            }
        }
    });

    /* testimonials */
    var testHide = $('.testimonials-hide'),
        testAnim = $('.testimonials-animator'),
        locHide = $('.recent-loc-hide'),
        locAnim = $('.recent-loc-animator'),
        testAnimTop = parseInt(testAnim.css('top')),
        locAnimTop = parseInt(locAnim.css('top')),
        testAnimStep = 80 + 1 + 28 * 2,
        locAnimStep = 48 + 1 + 26 * 2,
        testRemainClks = $('.section-3 .testimonials-animator .single-test').length - 3,
        locRemainClks = $('.section-3 .recent-loc-animator .single-loc').length - 4,
        testHideHeight = (28 * 2 + 1) * 2 + 80 * 3,
        locHideHeight = (26 * 2 + 1) * 3 + 48 * 4 + 2; // + 2 >> to make the two sections equal height

    testHide.height(testHideHeight);
    locHide.height(locHideHeight);
    $('.section-3 .single-test').show().height(80);
    $('.section-3 .single-loc').show().height(48);

    $('.section-3 .testimonials-cont .nav-btns .arrow-right').click(function () {
        testUp();
    });

    $('.section-3 .testimonials-cont .nav-btns .arrow-left').click(function () {
        testDown();
    });
    $('.section-3 .recent-loc-cont .nav-btns .arrow-right').click(function () {
        locUp();
    });
    $('.section-3 .recent-loc-cont .nav-btns .arrow-left').click(function () {
        locDown();
    });

    function testUp() {
        if (!testAnim.is(':animated') && testRemainClks > 0) {
            $('.section-3  .testimonials-cont .nav-btns .arrow-left').removeClass('disabled');
            testAnimTop = parseInt(testAnim.css('top'));
            testAnim.animate({top: testAnimTop - testAnimStep}, function () {
                testRemainClks--;
                if (testRemainClks == 0) {
                    $('.section-3 .testimonials-cont .nav-btns .arrow-right').addClass('disabled');
                }
            });
        }
    }

    function testDown() {
        if (!testAnim.is(':animated') && testRemainClks < $('.section-3 .testimonials-animator .single-test').length - 3) {
            $('.section-3 .testimonials-cont .nav-btns .arrow-right').removeClass('disabled');
            testAnimTop = parseInt(testAnim.css('top'));
            testAnim.animate({top: testAnimTop + testAnimStep}, function () {
                testRemainClks++;
                if (testRemainClks == $('.section-3 .testimonials-animator .single-test').length - 3) {
                    $('.section-3 .testimonials-cont .nav-btns .arrow-left').addClass('disabled');
                }
            });
        }
    }

    function locUp() {
        if (!locAnim.is(':animated') && locRemainClks > 0) {
            $('.section-3 .recent-loc-cont .nav-btns .arrow-left').removeClass('disabled');
            locAnimTop = parseInt(locAnim.css('top'));
            locAnim.animate({top: locAnimTop - locAnimStep}, function () {
                locRemainClks--;
                if (locRemainClks == 0) {
                    $('.section-3 .recent-loc-cont .nav-btns .arrow-right').addClass('disabled');
                }
            });
        }
    }

    function locDown() {
        if (!locAnim.is(':animated') && locRemainClks < $('.section-3 .recent-loc-animator .single-loc').length - 4) {
            $('.section-3 .recent-loc-cont .nav-btns .arrow-right').removeClass('disabled');
            locAnimTop = parseInt(locAnim.css('top'));
            locAnim.animate({top: locAnimTop + locAnimStep}, function () {
                locRemainClks++;
                if (locRemainClks == $('.section-3 .testimonials-animator .single-test').length - 4) {
                    $('.section-3 .recent-loc-cont .nav-btns .arrow-left').addClass('disabled');
                }
            });
        }
    }


    // Adjust map height
    $('#maphomeinfo').height($(window).height() - $('#header').outerHeight());
    $(window).resize(function () {
        $('#maphomeinfo').height($(window).height() - $('#header').outerHeight());
    });

    // home-google-map
    $(document).on('mousedown', '#mapScrollingHelper', function () {
        $(this).hide();
    });

    $(window).scroll(function () {
        $('#mapScrollingHelper').show();
    });
    $(document).on('click', '.goToHomeMap', function (e) {
        if(this.id=="regscroll")
        {
        e.preventDefault();
        $('body').animate({scrollTop: 0});
        }
    });

    /* ************* */
    /* location-page */
    if(window.innerWidth < 450) {
        $('#location-map .show-directions').click();
    }
    $(document).on('click', '#location-map .show-directions', function () {
        var dirOpen = $(this),
            dirCont = $("#location-map .loc-directions"),
            dirClose = $('#location-map .hide-directions');

        if (!dirOpen.hasClass('opened')) {
            dirOpen.fadeOut(function () {
                dirCont.animate({right: 0}, function () {
                    dirCont.niceScroll({
                        autohidemode: false,
                        railalign: 'right',
                        cursorwidth: '8px',
                        cursorborder: '1px solid #e5e5e5',
                        cursorborderradius: 0,
                        cursorcolor: '#fff',
                        background: '#f6f6f6'
                    });
                    dirClose.show().animate({right: '35%'});
                    dirOpen.addClass('opened');
                });
            });
        }
    });

    $(document).on('click', '#location-map .hide-directions', function () {
        var dirClose = $(this),
            dirCont = $("#location-map .loc-directions"),
            dirOpen = $('#location-map .show-directions');

        if (dirOpen.hasClass('opened')) {
            dirClose.animate({right: 0}, 200, function () {
                dirClose.fadeOut();
            });
            dirCont.getNiceScroll().remove();
            dirCont.delay(200).animate({right: '-50%'}, function () {
                dirOpen.fadeIn().removeClass('opened');
            });
        }
    });

    /* location -gallery */
    $('#loc-gallery .gal-item').colorbox({transition: "fade"});

    $('#loc-gallery .hider').slick({
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1
    });

    /* location tabs */
    $('.section-with-title .nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        $('.section-with-title .with-scrollbar').getNiceScroll().remove();
        $('.section-with-title .with-scrollbar').niceScroll({
            autohidemode: false,
            railalign: 'right',
            cursorwidth: '8px',
            cursorborder: '1px solid #e5e5e5',
            cursorborderradius: 0,
            cursorcolor: '#fff',
            background: '#f6f6f6'
        });
    });

    $('.section-with-title .with-scrollbar').niceScroll({
        autohidemode: false,
        railalign: 'right',
        cursorwidth: '8px',
        cursorborder: '1px solid #e5e5e5',
        cursorborderradius: 0,
        cursorcolor: '#fff',
        background: '#f6f6f6'
    });

    $('.section-with-title .with-scrollbar').getNiceScroll().resize();

    $(document).on('click', '#navigateWithMobileLink', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#navigateWithMobile").offset().top - 150
        }, 1500);
    });

    $(document).on('click', '#writeReviewLink', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#writeReview").offset().top - 150
        }, 1500);

        $("#writeReview ul li:nth-child(2)").removeClass("active");
        $("#writeReview ul li:nth-child(1)").addClass("active");
        $("#writeReview .sec-body .tab-content #details").removeClass("active in");
        $("#writeReview .sec-body .tab-content #reviews").addClass("active in");
        //window.location="#writeReview";
        $('html,body').animate({
         scrollTop: $("#writeReview").offset().top - 120},
        'slow');
    });

    if($('#location-map .loc-directions').css('position') === 'relative'){
        $('#location-map .loc-directions').niceScroll({
            autohidemode: false,
            railalign: 'right',
            cursorwidth: '8px',
            cursorborder: '1px solid #e5e5e5',
            cursorborderradius: 0,
            cursorcolor: '#fff',
            background: '#f6f6f6'
        });
    }

    /* about-press */
    $(window).resize(function () {
        adjustPressSlider();
    });

    $('.press .press-arrow-right').hover(function(){
        if(windowLoaded) {
            var thum_cont = $(this).parent().find('.press-logos');
            var thum_cont_l = parseInt(thum_cont.css('left'));
            var max_right = thum_cont.width() - thum_cont.parent().width()+10;
            var ani_time = ((max_right+thum_cont_l)/max_right)*$(this).parent().find('.press-logos').width()* press_ul_width / press_ul_parent_width ;
            $('.press .press-arrow-left').removeClass('disabled');
            thum_cont.animate({left:-max_right},ani_time,"linear", function () {
                if(parseInt(thum_cont.css('left')) == -max_right) {
                    $('.press .press-arrow-right').addClass('disabled');
                }
            });
        }
    },function(){
        var thum_cont = $(this).parent().find('.press-logos');
        thum_cont.clearQueue();
        thum_cont.stop();
    });

    $('.press .press-arrow-left').hover(function(){
        var thum_cont = $(this).parent().find('.press-logos');
        var thum_cont_l = parseInt(thum_cont.css('left'));
        var max_right = thum_cont.width() - thum_cont.parent().width()+10;
        var max_left = 0;
        var ani_time = ((max_left-thum_cont_l)/max_right)*$(this).parent().find('.press-logos').width()* press_ul_width / press_ul_parent_width ;
        $('.press .press-arrow-right').removeClass('disabled');
        thum_cont.animate({left:0},ani_time,"linear", function () {
            if(parseInt(thum_cont.css('left')) == max_left) {
                $('.press .press-arrow-left').addClass('disabled');
            }
        });
    },function(){
        var thum_cont = $(this).parent().find('.press-logos');
        thum_cont.clearQueue();
        thum_cont.stop();
    });

    // about-side-nav
    $('.about-sec').each(function () {
        var secInView = $('.wide-section-title', this).inView(),
            secId = $(this).attr('id');
        if(secInView) {
            $('a.' + secId + '-link').addClass('active');
        }
    });

    $(window).scroll(function () {
        $('.about-side-nav a').removeClass('active');

        $('.about-sec').each(function () {
            var secInView = $('.wide-section-title', this).inView(),
                secId = $(this).attr('id');
            if(secInView) {
                $('a.' + secId + '-link').addClass('active');
            }
        });
    });

    // warning message close
    $(document).on('click', '.msg-close', function () {
        $('header .warning-message').fadeOut(function () {
            $('header .warning-message').remove();
        });
    });

});

var press_ul_width = 0, press_ul_parent_width = $('.press-logos-cont').width(), windowLoaded = false;

$(window).load(function () {
    windowLoaded = true;
    adjustPressSlider();
});
function adjustPressSlider() {
    $('.press-logos li').each(function(){ press_ul_width += $(this).outerWidth() + 1; });

    if(press_ul_width > press_ul_parent_width) {
        $('.press-logos').width(press_ul_width);
        $('.press').removeClass('centered');
    } else {
        $('.press').addClass('centered');
    }
}

$.fn.inView = function () {
    'use strict';

    var win = $(window),
        obj = $(this),
        scrollPosition = win.scrollTop(),
        visibleArea = win.scrollTop() + win.height(),
        objEndPos = (obj.offset().top + 50);

    return (visibleArea >= objEndPos && scrollPosition <= objEndPos ? true : false);
};
