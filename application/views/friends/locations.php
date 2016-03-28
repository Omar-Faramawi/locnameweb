

<script type="text/javascript">
            var havelocations=0;
           var offset =0;
           var remain=0; 
           loadArticle(offset);
           function loadd()
           {
               loadArticle(++offset);
                       offset++;
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
               
                    if("<?=$page_title?>"=="Locations")
                    var url="<?= base_url("api/locations/$friend_id") ?>"+"/3"+"/"+offset.toString();
                    else
                     var url="<?= base_url("api/favorite/$friend_id") ?>"+"/3"+"/"+offset.toString();   
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
//                                 $("#content").append("<br/>");
//                                 $("#content").append(html.data[i].title);
//                                 $("#content").append("<br/>");
                                var finalString = ucfirst(res.data[i].title);
                                html = '<div class="col-md-4">\
                        <div class="recent-loc favorites locations">\
                            <div class="favorites-img">\
                                <img alt="' + res.data[i].title + '" src="<?= base_url("assets/uploads/locations/") ?>/' + res.data[i].title + '.png">\
                            </div>\
                            <div class="recent-content">\
                                <div>\
                                    <img alt="" src="<?= base_url("assets/images/categories") ?>/' + ((res.data[i].type) ? res.data[i].type: "general" )+'.png">\
                                </div>\
                                <div>\
                                    <h3><a href="<?= site_url() ?>' + res.data[i].title + '">' + finalString.substring(0,15) + '</a></h3>\
                                    <div class="locations-date"><i class="fa fa-calendar"></i><span>Created:</span> ' + res.data[i].date + '</div>\
                                    <p> '+ res.data[i].address.substring(0,27) +'</p>\
                                </div>\
                            </div>\
                            <div class="recent-footer">\
                                <div class="row">\
                                    <div class="col-md-6">\
                                        <a class="locations-v hidden" href="<?= site_url("location/askverify/" ) ?>"' + res.data[i].id + ' >Verify Location</a>\
                                    </div>\
                                    <div class="col-md-6">\
                                        <a class="locations-l" href="<?= site_url() ?>/' + res.data[i].title + '">View Location</a>\
                                    </div>\
                                </div>\
                                <div class="clearfix"></div>\
                            </div>\
                        </div>\
                    </div>';
                            
                            $("#content").append(html);  
                            
                            }
                            if(remain<=0)
                            {
                                if(!$("#no-more").is(':visible')){
                                    $("#no-more").append("<center><div style='width:30%;height:50px;font-size: 30px;'> No More Locations </div><center>").show();
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
<?php
if ($isFriend) {
    ?>
    <section class="container clearfix main-container">
        <div class="row">
            <?php if ($locations>0) { ?>
                <br>

            <div id="content">


            </div>
            <?php } else { ?>
                            <div class="alert alert-info" role="alert">This friend has not created any locations yet</div>
            <?php } ?>
        </div>
      
    </section><!-- End main-container -->

    <?php
} else {
    ?><div class="alert alert-danger" role="alert">This user is not your friend; you can't view this user's locations</div><?php
}
?>
 <?php if ($locations>0) { ?><div style="display:none;" id="no-more"></div><?php }?>
