jQuery(document).ready(function ($) {
<<<<<<< HEAD
=======
    $('#embedMap').click(function(event){
        event.preventDefault();
        var locationTitle = $(this).attr('locationTitle')+'/';
        var mapType = $('select[name="type"]').val()+'/';
        var zoom = $('select[name="zoom"]').val()+'/';
        var width = $('input[name="width"]').val()+'/';
        var height = $('input[name="height"]').val();
        var iframeLink = site_url+'location/share/'+locationTitle+mapType+zoom+width+height;
        $('#embeded-map-section').show();
        $('#embeded-map .col-md-12').text('<iframe src="'+iframeLink+'"></iframe>');
    });
>>>>>>> ranya
    if (user_id !== false) {
        if ($.cookie('unSavedLocation'))
        {
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
<<<<<<< HEAD
=======

>>>>>>> ranya
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
<<<<<<< HEAD
=======
    /*Invite google friends*/
    $('#ifg').click(function(){
        openDialog(site_url+"api/google_connect?close=1", "Google Invite", 'height=600,width=600', function(){
            $.get(site_url+"api/google_invite", function (data){
                console.log(data);                
            });
        });
    });
    var openDialog = function(uri, name, options, closeCallback) {
        var win = window.open(uri, name, options);
        var interval = window.setInterval(function() {
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
>>>>>>> ranya
    $('.wrap-pop').on('click', '.hide-popup', function () {
        $(this).parents(".panel-pop").hide('slow');
        $('.wrap-pop').hide('fast');
        //$('.hide-popup').click();
<<<<<<< HEAD
    });
=======
    }); 
>>>>>>> ranya
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
    $("footer a[href='#']").on("click" , function(e) {
        e.preventDefault();
        alert("Coming Soon");
    });
    ///  End Amr Soliman
	
    jQuery(".panel-pop").each(function () {
        var panel_pop = jQuery(this);
        var panel_pop_h = panel_pop.outerHeight();
        panel_pop.css({"margin-top":-panel_pop_h/2});
    });

    jQuery(".navigation > ul > li.welcome").each(function(){	
        var jQuerysublist = jQuery(this).find('ul:first');		
        jQuery(this).hover(function() {
            jQuerysublist.stop().css({overflow:"hidden",height:"auto",display:"none"}).slideDown(200,function() {
                jQuery(this).css({overflow:"visible", height:"auto"});
            });
        },
        function(){	
            jQuerysublist.stop().slideUp(200,function() {	
                jQuery(this).css({overflow:"hidden", display:"none"});
            });
        });	
    });
	
<<<<<<< HEAD
=======
     /* feedback */
    jQuery("#open-feedback").click(function () {
        jQuery(".panel-pop-login").hide().animate({"top":"-100%"},500);
        jQuery(".panel-pop-register").hide().animate({"top":"-100%"},500);
        jQuery('.wrap-pop').hide();
        jQuery(".panel-pop-feedback").css('left','45%');
        jQuery(".panel-pop-feedback").show().animate({"top":"50%"},500);
        jQuery("body").prepend("<div class='wrap-pop' style='top:0;'></div>");
        wrap_pop();
        return false;
    });
    

>>>>>>> ranya
    /* Login */
    jQuery("li.login > a").click(function () {
        jQuery(".panel-pop-login").show().animate({"top":"50%"},500);
        jQuery("body").prepend("<div class='wrap-pop'></div>");
        wrap_pop();
        return false;
    });
	
    jQuery(".register_popup").click(function () {
        jQuery(".panel-pop.panel-pop-login").hide();
        jQuery(".wrap-pop").hide();
        jQuery(".panel-pop-register").show().animate({"top":"50%"},500);
        jQuery("body").prepend("<div class='wrap-pop' style='top:0;'></div>");
        wrap_pop();
        return false;
    });

    function wrap_pop() {
        jQuery(".wrap-pop").click(function () {
            jQuery(".panel-pop,.video-popup,.panel-pop-report").animate({"top":"-100%"},500).hide(function () {
                jQuery(this).animate({"top":"-100%"},500);
            });
            if (jQuery(this).hasClass("wrap-pop-video")) {
                player.pauseVideo();
            }
            jQuery(this).remove();
        });
    }
	
    /* section-recent */
    var vids = jQuery(".section-recent ul .col-md-6");
    for(var i = 0; i < vids.length; i+=4) {
        vids.slice(i, i+4).wrapAll('<li></li>');
    }

    if (jQuery(".section-recent").length) {
        jQuery(".section-recent ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: false});
    }
	
    /* Accordion & Toggle */
    jQuery(".accordion .accordion-title").each(function(){
        jQuery(this).click(function() {
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
        jQuery(".testimonials-slide ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true});
    }

    /* last-news */
    if (jQuery(".last-news").length) {
        jQuery(".last-news ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true});
    }

    /* last-news */
    jQuery(".section-4-number").each(function () {
        jQuery(this).appear(function() {
            var endNum = parseInt(jQuery(this).find(".section-number").text());
            jQuery(this).find(".section-number").countTo({
                from: 0,
                to: endNum,
                speed: 4000,
                refreshInterval: 60
            });
        },{accX: 0, accY: 0});
    });
	
    /* member-page-sidebar-recent */
    if (jQuery(".member-page-sidebar-recent").length) {
        jQuery(".member-page-sidebar-recent ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true});
    }

    var vids = jQuery(".member-page-sidebar-recent-2 ul .recent-loc");
    for(var i = 0; i < vids.length; i+=2) {
        vids.slice(i, i+2).wrapAll('<li></li>');
    }

    if (jQuery(".member-page-sidebar-recent-2").length) {
        jQuery(".member-page-sidebar-recent-2 ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true});
    }
	
    var vids = jQuery(".member-page-members ul .section-members");
    for(var i = 0; i < vids.length; i+=4) {
        vids.slice(i, i+4).wrapAll('<li></li>');
    }

    if (jQuery(".member-page-members").length) {
        jQuery(".member-page-members ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true});
    }

    if (jQuery(".section-content-images").length) {
        jQuery(".section-content-images ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true,pagerCustom: ".bx-pager"});
    }

    if (jQuery(".section-content-images-2").length) {
        jQuery(".section-content-images-2 ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true,pagerCustom: ".bx-pager"});
    }

    if (jQuery(".slide-about").length) {
        jQuery(".slide-about ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true});
    }
	
    jQuery(".testimonials-slide-2 li").each(function () {
        var testimonials = jQuery(this);
        var testimonials_w = testimonials.outerWidth();
        var testimonials_img = jQuery(".testimonials-img",testimonials).parent();
        testimonials_img.css({"margin-left":(testimonials_w-testimonials_img.outerWidth())/2});
    });
	
    if (jQuery(".testimonials-slide-2").length) {
        jQuery(".testimonials-slide-2 ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true});
    }

    jQuery("ul.tabs").tabs(".tab-inner-warp",{effect:"slide",fadeInSpeed:100});

    jQuery(".about-video").click(function () {
        jQuery(".video-popup").show().animate({"top":"50%"},500);
        jQuery("body").prepend("<div class='wrap-pop wrap-pop-video'></div>");
        wrap_pop();
        return false;
    });
	
    var video_none = jQuery(".video-popup");
    var video_none_w = jQuery(".video-popup").outerWidth();
    var video_none_h = jQuery(".video-popup").outerHeight();
    video_none.css({"margin-top":-(video_none_h)/2,"margin-left":-(video_none_w)/2});

    if (jQuery(".progressbar-percent").length) {
        jQuery(".progressbar-percent").each(function(){
            var $this = jQuery(this);
            var percent = $this.attr("attr-percent");
            $this.bind("inview", function(event, isInView, visiblePartX, visiblePartY) {
                if (isInView) {
                    $this.animate({ "width" : percent + "%"}, percent*20);
                }
            });
        });
    }
	
    var vids = jQuery(".related-locations ul .related-locations-item");
    for(var i = 0; i < vids.length; i+=2) {
        vids.slice(i, i+2).wrapAll('<li></li>');
    }

    if (jQuery(".related-locations").length) {
        jQuery(".related-locations ul").bxSlider({slideWidth: 1140,moveSlides: 1,maxSlides: 1,auto: true});
    }
	
    jQuery(".report-this").click(function () {
        jQuery(".panel-pop-report").show().animate({"top":"50%"},500);
        jQuery("body").prepend("<div class='wrap-pop'></div>");
        wrap_pop();
        return false;
    });
        
    jQuery(".form-js").submit(function () {
        var whatsubmit_l = true;
        var thisform = jQuery(this);
        jQuery('.required-error',thisform).remove();
        jQuery('.required-item',thisform).each(function () {
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
    var aboveHeight    = jQuery('.header-nav').outerHeight();
    var disabledSticky = jQuery('.header-nav').hasClass('disabled-sticky');
    if(!disabledSticky){
        jQuery(window).scroll(function(){
            if(jQuery(window).scrollTop() > aboveHeight ){
                jQuery('.header-nav').css({'top':'0'}).addClass('fixed-nav');
            } else {
                jQuery('.header-nav').css({'top':'auto'}).removeClass('fixed-nav');
            }
        });
    } else {
        jQuery('.header-nav').removeClass('fixed-nav');
    }
	
    var window_w = jQuery(window).width();	
    /* animated */
    jQuery(".animated").each( function() {
        var $this = jQuery(this);
        var animated = $this.attr("animate_attr");
        $this.bind("inview", function(event, isInView, visiblePartX, visiblePartY) {
            if (isInView) {
                $this.css("visibility","visible");
                $this.addClass(animated);
                if(animated.indexOf("fade") === -1) {
                    $this.css("opacity", "1");
                }
            }
        });
    });

<<<<<<< HEAD
    /* ************ */
=======
>>>>>>> ranya
    /* fixed header */
    var thinHeaderH = $('#top-thin-bar').outerHeight();
    $(window).scroll(function(){
        checkScrollTop();
    });
<<<<<<< HEAD
    $(window).resize(function() { checkScrollTop(); });

    checkScrollTop();
    function checkScrollTop(){
        if($(window).width() >= 991){
            if($(window).scrollTop() >= thinHeaderH){
                $('body').addClass('fixed-header');
            }
            if($(window).scrollTop() < thinHeaderH){
                $('body').removeClass('fixed-header');
            }
        } else {
=======

    checkScrollTop();
    function checkScrollTop(){
        if($(window).scrollTop() >= thinHeaderH){
            $('body').addClass('fixed-header');
        }
        if($(window).scrollTop() < thinHeaderH){
>>>>>>> ranya
            $('body').removeClass('fixed-header');
        }
    }

<<<<<<< HEAD
    /* *********** */
=======
>>>>>>> ranya
    /* why-locname */
    var slider = $('.section-2 .why-slider .slides'),
        sliderLeft = parseInt(slider.css('left')),
        slideW = slider.children().outerWidth(),
        crtSlide = 1,
        bulletIndex = 1;

    slider.children().outerWidth(slideW);
    slider.width(slideW * slider.children().length);
    slider.children().show();

    $(window).resize(function(){
        slideW = $('.why-slider').outerWidth();
        slider.children().outerWidth(slideW);
        slider.width(slideW * slider.children().length);
        slider.css('left',(1 - crtSlide) * slideW);
    });

    $('.section-2 .why-slider .why-arrow-right').click(function(){
        whySliderRight();
    });

    $('.section-2 .why-slider .why-arrow-left').click(function(){
        whySliderLeft();
    });

    function whySliderRight(steps){
        steps = steps || 1;
        if(!slider.is(':animated') && crtSlide != slider.children().length){
            $('.section-2 .bullets li').removeClass('current');
            $('.section-2 .bullets li').eq(crtSlide + steps - 1).addClass('current');
            $('.section-2 .why-slider .why-arrow-left').removeClass('disabled');
            sliderLeft = parseInt(slider.css('left'));
            slider.animate({left: sliderLeft - slideW*steps}, 800, function(){
                crtSlide += steps;
                if(crtSlide == slider.children().length) $('.section-2 .why-slider .why-arrow-right').addClass('disabled');
            });
        }
    }

    function whySliderLeft(steps){
        steps = steps || 1;
        if(!slider.is(':animated') && crtSlide != 1){
            $('.section-2 .bullets li').removeClass('current');
            $('.section-2 .bullets li').eq(crtSlide - 2 - steps + 1).addClass('current');
            $('.section-2 .why-slider .why-arrow-right').removeClass('disabled');
            sliderLeft = parseInt(slider.css('left'));
            slider.animate({left: sliderLeft + slideW*steps}, 800, function(){
                crtSlide -= steps;
                if(crtSlide == 1) $('.section-2 .why-slider .why-arrow-left').addClass('disabled');
            });
        }
    }

    $('.section-2 .bullets li').click(function(){
        bulletIndex = $('.section-2 .bullets li').index($(this)) + 1;
        if(!slider.is(':animated') && crtSlide != bulletIndex){
            if(bulletIndex > crtSlide){
                console.log(bulletIndex - crtSlide);
                whySliderRight(bulletIndex - crtSlide);
            } else {
                console.log(crtSlide - bulletIndex);
                whySliderLeft(crtSlide - bulletIndex);
            }
        }
    });

<<<<<<< HEAD
    /* ************ */
=======
>>>>>>> ranya
    /* testimonials */
    var testHide = $('.testimonials-hide'),
        testAnim = $('.testimonials-animator'),
        locHide = $('.recent-loc-hide'),
        locAnim = $('.recent-loc-animator'),
        testAnimTop = parseInt(testAnim.css('top')),
        locAnimTop = parseInt(locAnim.css('top')),
        testAnimStep = $('.section-3 .testimonials-cont .test-img').outerHeight() + 1 + 28* 2,
        locAnimStep = $('.section-3 .recent-loc-cont .loc-img').outerHeight() + 1 + 26* 2,
        testRemainClks = $('.section-3 .testimonials-animator .single-test').length - 3,
        locRemainClks = $('.section-3 .recent-loc-animator .single-loc').length - 4,
        testHideHeight = (28*2 + 1) * 2 + $('.section-3 .testimonials-cont .test-img').outerHeight() * 3,
        locHideHeight = (26*2 + 1) * 3 + $('.section-3 .recent-loc-cont .loc-img').outerHeight() * 4 + 2; // + 2 >> to make the two sections equal height

    testHide.height(testHideHeight);
    locHide.height(locHideHeight);
    $('.section-3 .single-test').show().height($('.section-3 .testimonials-cont .test-img').outerHeight());
    $('.section-3 .single-loc').show().height($('.section-3 .recent-loc-cont .loc-img').outerHeight());

    $('.section-3 .testimonials-cont .nav-btns .arrow-right').click(function(){
        testUp();
    });
<<<<<<< HEAD
    $('.section-3 .testimonials-cont .nav-btns .arrow-left').click(function(){
        testDown();
    });
    $('.section-3 .recent-loc-cont .nav-btns .arrow-right').click(function(){
        locUp();
    });
=======

    $('.section-3 .testimonials-cont .nav-btns .arrow-left').click(function(){
        testDown();
    });

    $('.section-3 .recent-loc-cont .nav-btns .arrow-right').click(function(){
        locUp();
    });

>>>>>>> ranya
    $('.section-3 .recent-loc-cont .nav-btns .arrow-left').click(function(){
        locDown();
    });

    function testUp(){
        if(!testAnim.is(':animated') && testRemainClks > 0){
            $('.section-3  .testimonials-cont .nav-btns .arrow-left').removeClass('disabled');
            testAnimTop = parseInt(testAnim.css('top'));
            testAnim.animate({top: testAnimTop - testAnimStep}, function(){
                testRemainClks --;
                if(testRemainClks == 0){
                    $('.section-3 .testimonials-cont .nav-btns .arrow-right').addClass('disabled');
                }
            });
        }
    }

    function testDown(){
        if(!testAnim.is(':animated') && testRemainClks < $('.section-3 .testimonials-animator .single-test').length - 3){
            $('.section-3 .testimonials-cont .nav-btns .arrow-right').removeClass('disabled');
            testAnimTop = parseInt(testAnim.css('top'));
            testAnim.animate({top: testAnimTop + testAnimStep}, function(){
                testRemainClks ++;
                if(testRemainClks == $('.section-3 .testimonials-animator .single-test').length - 3){
                    $('.section-3 .testimonials-cont .nav-btns .arrow-left').addClass('disabled');
                }
            });
        }
    }

    function locUp(){
        if(!locAnim.is(':animated') && locRemainClks > 0){
            $('.section-3 .recent-loc-cont .nav-btns .arrow-left').removeClass('disabled');
            locAnimTop = parseInt(locAnim.css('top'));
            locAnim.animate({top: locAnimTop - locAnimStep}, function(){
                locRemainClks --;
                if(locRemainClks == 0){
                    $('.section-3 .recent-loc-cont .nav-btns .arrow-right').addClass('disabled');
                }
            });
        }
    }

    function locDown(){
        if(!locAnim.is(':animated') && locRemainClks < $('.section-3 .recent-loc-animator .single-loc').length - 4){
            $('.section-3 .recent-loc-cont .nav-btns .arrow-right').removeClass('disabled');
            locAnimTop = parseInt(locAnim.css('top'));
            locAnim.animate({top: locAnimTop + locAnimStep}, function(){
                locRemainClks ++;
                if(locRemainClks == $('.section-3 .testimonials-animator .single-test').length - 4){
                    $('.section-3 .recent-loc-cont .nav-btns .arrow-left').addClass('disabled');
                }
            });
        }
    }


    // Adjust map height
    $('#maphomeinfo').height($(window).height() - $('#header').outerHeight());
    $(window).resize(function(){ $('#maphomeinfo').height($(window).height() - $('#header').outerHeight()); });








<<<<<<< HEAD



=======
>>>>>>> ranya
});