<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="z-index:1060;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Are your sure you want to delete this location:</h4>
      </div>
      <!--<div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" id="deleteLocationBtn" class="btn btn-primary">Delete</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var recipient;
        $("#deleteLocationBtn").click(function(){
            window.location = recipient;
        });
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            recipient = button.data('whatever');
            var locationName = button.data('location'); // Extract info from data-* attributes
            // alert(recipient);
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-title').html('Are your sure you want to delete this location: <br><a style="color:red;">' + locationName+"</a>");
           // modal.find('.modal-body input').val(recipient);
        });
    });
</script>
<script type="text/javascript">
            var havelocations=0;
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
               

                    var url="<?= base_url("api/locations/$id") ?>"+"/3"+"/"+offset.toString();
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
                                    <h3><a href="<?= site_url() ?>' + res.data[i].title + '">' + ( res.data[i].title.length > 15 ?  finalString.substring(0,12) + "..." : finalString.substring(0,12) ) + '</a></h3>\
                                    <div class="locations-date"><i class="fa fa-calendar"></i><span>Created:</span> ' + res.data[i].date + '</div>\
                                    <p> '+ res.data[i].address.substring(0,27) +'</p>\
                                </div>\
                            </div>\
                            <div class="recent-footer">\
                                <div class="row">\
                                    <div class="col-md-6">\
                                        <a class="locations-u" href="<?= site_url("location/update/") ?>'+"/"+'' + res.data[i].title + '">Edit Location</a>\
                                        <a class="locations-d" data-toggle="modal" data-target="#exampleModal" data-location="' + res.data[i].title + '" data-whatever="<?= site_url("location/delete_location/")?>/' + res.data[i].id + '">Delete Location</a>\
                                    </div>\
                                    <div class="col-md-6">\
                                        <a class="locations-v hidden" href="<?= site_url("location/askverify/" ) ?>"' + res.data[i].id + ' >Verify Location</a>\
                                    </div>\
                                    <div class="col-md-6">\
                                        <a class="locations-l" href="<?= site_url() ?>' + res.data[i].title + '">View Location</a>\
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

    <section class="container clearfix main-container">
        <div class="row">
            <?php if ($locations>0) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <a class='btn btn-primary' style="margin-left:14px;" href="<?= site_url("registerlocation") ?>">Register a new LocName</a>
                    </div>
                </div>
            <br>

            <div id="content">


            </div>
            <?php } else { ?>
                           <div class="section-content-note section-content-note-5 section-content-alert margin-0"><i class="fa fa-microphone"></i><span>Note:</span> You didn't create any locations yet. <a href="<?= site_url("registerlocation") ?>">Create one now</a>. </div>
            <?php } ?>
        </div>
      
    </section><!-- End main-container -->
    <?php if ($locations>0) { ?><div style="display:none;" id="no-more"></div><?php }?>
