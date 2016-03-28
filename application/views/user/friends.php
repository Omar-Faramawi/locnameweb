<script type="text/javascript">
$('.panel-pop').css('max-height', '500px');
$('.panel-pop').css('overflow', 'auto');
           var offset =0;
           var remain=0; 
           loadArticle(offset);
           function loadd()
           {
               loadArticle(++offset);
                     
           }
            $(window).scroll(function(){
                    
                   var wintop = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height();
                              var  scrolltrigger = 0.95;

                           if  ((wintop/(docheight-winheight-300)) > scrolltrigger&&remain>0) {
                             //console.log('scroll bottom');
                         
                               loadArticle(++offset);
                     
                    }
                    
            });
 
            function loadArticle(offset){
                    $("#loadingimg").remove();


                    var url="<?= base_url("api/friends/$id") ?>"+"/5"+"/"+offset.toString();
                    
                    $.ajax({
                        url: url,
                        type:'GET',
                        
                        data: "",
                       beforeSend: function (xhr) {
                                       $("#content").append("<center><img id='loadingimg' src='<?= base_url("assets/loading45.gif") ?>' /></center>");
                                   },
                        success: function(res){
                            $("#loadingimg").remove();
                            remain=res.remaining;
                            var html;
                            for(var i=0;i<res.data.length;i++ )
                            {
                                 var photo;
                                 var element;
                                if(res.data[i].photo!==null&&res.data[i].photo!=="0")
                                {
                                  if((res.data[i].photo).substring(0,4)==="http")
                                         photo=res.data[i].photo;
                                    else
                                        photo='<?=base_url("assets")  ?>/'+res.data[i].photo+'';
                                    element='<img alt="'+res.data.first_name+'" src="'+photo+'" width="50">';
                             
                                }
                                else 
                                    element='<i class="fa fa-user"></i>';


                                
                            html = '<div class="friends-container clearfix">\n\
                                        <div class="profile-img col-md-2">'+element+'\n\
                                        </div>\n\
                                        <div class="user-data col-md-10">\
                                            <h3>' + res.data[i].first_name +" "+res.data[i].last_name +'</h3>\
                                            <div class="more-data col-md-6">\
                                                <i class="fa fa-map-marker"></i>\
                                                <span><a href="<?= site_url("friends/locations/" ) ?>/'+res.data[i].id+'">'+res.data[i].locations+'</a> </span>\
                                            </div>\n\
                                            <div class="more-data col-md-6">\
                                                <i class="fa fa-star"></i>\
                                                <span><a href="<?= site_url("friends/favourites/" ) ?>/'+res.data[i].id+'">'+res.data[i].favorites+'</a></span>\
                                            </div> \
                                        </div>\
                                    </div>\
                                        ';
                            
                            
                            ///////////////////////////////////////////////////////////////////////
                            
                            $("#content").append(html);  
                            
                            }
                           if(remain<=0)
                            {
                                if(!$("#no-more").is(':visible')){
                                    $("#no-more").append("<center><div style='width:30%;height:50px;font-size: 30px;'> No More Friends </div><center>").show();
                                }
                            }
                           
                        },
                        error:function(){
                             $("#loadingimg").remove();
                            
                            
                            
                    }
                    });
                return false;
            }
             
</script>



<section class="container clearfix main-container">
    <div class="panel-pop panel-pop-sync_contacts panel-pop-google text-center">
        <img src="<?= base_url("assets/main/img/sloading.gif"); ?>" alt="Loading Contacts" >
    </div>
    <div class="panel-pop panel-pop-sync_contacts panel-pop-facebook text-center">
        <img src="<?= base_url("assets/main/img/sloading.gif"); ?>" alt="Loading Contacts" >
    </div>
    <div class="col-md-8">
        <?php if ($friends) { ?>
        <div id="content" ></div>

        <?php } else { ?>
            <div class="section-content-note section-content-note-5 section-content-alert margin-0"><i class="fa fa-microphone"></i><span>Note:</span> You don't have any friends on LocName. </div>
        <?php } ?>
        <div class="pagination">
           
        </div>
    </div>
    <?php
-    $client_id     = '0000000040158220';
-    $client_secret = '0xubbx7IabjLSq4HBzNczUpYQZmwtisx';
-    $redirect_uri  = site_url('friends/invite_windows_live_friends');
-    $url = 'https://login.live.com/oauth20_authorize.srf?client_id='.$client_id.'&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri='.$redirect_uri;
    ?>
    
    <div class="col-md-4 sync-contacts">
      <a class="btn btn-danger" id="ifg">Invite Friends g+</a><br><br>
      <a class="btn btn-yahoo" href="/friends/invite_yahoo_friends" >Invite Friends Yahoo</a><br><br>
      <a class="btn btn-custom" href="<?php echo $url;?>">Invite Friends Windows Live</a>
        <h2 class="text-center">
            Sync Your Contacts
        </h2>
        <div>
            <a class="col-md-6 text-right">
                <i id="facebook_sync" class="fa fa-facebook"></i>
            </a>
            <a class="col-md-6 text-left" href="JavaScript:newPopup('<?= site_url("api/google_connect?close=1") ?>');">
                <i id="google_sync" class="fa fa-google-plus"></i>
            </a>
        </div>
    </div>
</section><!-- End main-container -->
<?php if ($friends) { ?><div id="no-more" style="display: none"></div><?php }?>
<?php 
if ($this->session->userdata('invite_emails')) {
    $emails = $this->session->userdata('invite_emails');
    $content = "";
    foreach ($this->session->userdata('invite_emails') as $key) {
      $content .= "<input type='checkbox' name='invite_yahoo_emails[]' value='" . $key . "' />" . $key . "<br />";
    }
    $this->session->unset_userdata('invite_emails');
    $wrap_pop = "<div class='wrap-pop' style='top:0;'></div>";
    echo "
      <script type='text/javascript'>
        $('.panel-pop-invite h3').text('Invite Yahoo Friends');
        $('.panel-pop-invite .panel-pop-content form input[type=\"submit\"]').attr('id','do_yahoo_invite');
        $('#invite_emails').html(\"".$content."\");
        jQuery('.wrap-pop').hide();
        jQuery('.panel-pop-invite').show().animate({'top': '30%'}, 500);
        jQuery('body').prepend(\"".$wrap_pop."\");
        wrap_pop();
      </script>
    ";
}
?>
<script type='text/javascript'>
  $('#do_yahoo_invite').on('click', function(){
    var chk_arr =  document.getElementsByName("invite_yahoo_emails[]");
        var emails = [];

        for(i = 0; i < chk_arr.length; i++) {
            if(chk_arr[i].checked == true) {
                emails.push(chk_arr[i].value);
            }
        }
        
        $.post(site_url + "api/do_yahoo_invite", {emails: emails}, function(result) {
            //console.log(result);
            alert("You have successfully invited " + result + " friend(s)");
            jQuery(".wrap-pop").hide();
            jQuery(".panel-pop-invite").hide();
            wrap_pop();
        });
  });
</script>

<?php 
if ($this->session->userdata('invite_live_emails')) {
    $emails = $this->session->userdata('invite_live_emails');
    $content = "";
    foreach ($this->session->userdata('invite_live_emails') as $key) {
      $content .= "<input type='checkbox' name='invite_live_emails[]' value='" . $key . "' />" . $key . "<br />";
    }
    $this->session->unset_userdata('invite_live_emails');
    $wrap_pop = "<div class='wrap-pop' style='top:0;'></div>";
    echo "
      <script type='text/javascript'>
        $('.panel-pop-invite h3').text('Invite Windows Live Friends');
        $('.panel-pop-invite .panel-pop-content form input[type=\"submit\"]').attr('id','do_live_invite');
        $('#invite_emails').html(\"".$content."\");
        jQuery('.wrap-pop').hide();
        jQuery('.panel-pop-invite').show().animate({'top': '30%'}, 500);
        jQuery('body').prepend(\"".$wrap_pop."\");
        wrap_pop();
      </script>
    ";
}
?>

<script type='text/javascript'>
  $('#do_live_invite').on('click', function(){
    var chk_arr =  document.getElementsByName("invite_live_emails[]");
        var emails = [];

        for(i = 0; i < chk_arr.length; i++) {
            if(chk_arr[i].checked == true) {
                emails.push(chk_arr[i].value);
            }
        }
        
        $.post(site_url + "api/do_live_invite", {emails: emails}, function(result) {
            //console.log(result);
            alert("You have successfully invited " + result + " friend(s)");
            jQuery(".wrap-pop").hide();
            jQuery(".panel-pop-invite").hide();
            wrap_pop();
        });
  });
</script>