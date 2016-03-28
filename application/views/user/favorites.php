

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
                    var url="<?= base_url("api/locations/$id") ?>"+"/3"+"/"+offset.toString();
                    else
                     var url="<?= base_url("api/favorite/$id") ?>"+"/3"+"/"+offset.toString();   
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
                            console.log(res);
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
                                    <h3><a href="<?= site_url() ?>' + res.data[i].title + '">' + finalString + '</a></h3>\
                                    <div class="locations-date"><i class="fa fa-calendar"></i><span>Created:</span> ' + res.data[i].date + '</div>\
                                    <p> '+ res.data[i].address.substring(0,27) +'</p>\
                                </div>\
                            </div>\
                            <div class="recent-footer">\
                                <div><i class="fa fa fa-briefcase"></i><span>Type :</span> ' + ((res.data[i].type) ? res.data[i].type: "general" )+'</div>\
                                <a class="favorites-x delete-fav"  href="<?= site_url("favourite/delete/")?>/' + res.data[i].favoriteId + '" ><i class="fa fa-times"></i></a>\
                                <a class="favorites-view" style="margin-bottom:10px;" href="<?= site_url() ?>/' + res.data[i].title + '">View</a>\
                                <div class="clearfix"></div>\
                            </div>\
                        </div>\
                    </div>';
                            
                            $("#content").append(html);  
                            
                            }
                             if(remain<=0)
                            {
                                if(!$("#no-more").is(':visible')){
                                    $("#no-more").append("<center><div style='width:30%;height:50px;font-size: 30px;'> No More Favorite Locations </div><center>").show();
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
        <div class="row">
            <?php if ($locations>0) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <a class='btn btn-primary' href="<?= site_url("registerlocation") ?>">Register a new LocName</a>
                    </div>
                </div>
            <br>

            <div id="content">


            </div>
            <?php } else { ?>
        <div class="section-content-note section-content-note-5 section-content-alert margin-0"><i class="fa fa-microphone"></i><span>Note:</span> you didn't add any locations in your favorites. </div>
            <?php } ?>
        </div>
      
    </section><!-- End main-container -->
     <?php if ($locations>0) { ?><div id="no-more" style="display: none"></div><?php }?>
