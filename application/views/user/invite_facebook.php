
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
    FB.init({
        appId: '1376235535961215',
        cookie: true,
        status: true,
        xfbml: true
    });

    function FacebookInviteFriends()
    {
        FB.ui({
            method: 'apprequests',
            message: 'Thanks <?= $user->username ?> for inviting your friends'
        });
    }


    function send_invitation(fb_frnd_id) {
        FB.ui({method: 'apprequests',
            message: 'Locname .',
            to: fb_frnd_id
        },
        function(response) {
            console.log(response);
        });
    }


</script>



<section class="section-content section-login">
		<div class="section-content-head">
			<i class="fa fa-ticket"></i>
			<div>
				<h3>Invite Your Friends !</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-6">
				<div class="head-title section-content-title"><h3><span>Invite Through Emails</span></h3></div>
				<form method="post" action="">
					<div class="user-email margin-0">
                                               
                                               
                                               <input type="email" id="InvitedEmails" placeholder="Email Account / s">
						<i class="fa fa-indent"></i>
					</div>
					<div class="clearfix"></div>
                                        <input type="submit" class="InviteWithEmails" value="Invite Now">
                                                                                       <div id="InvitedEmailsMessage"  style="display: none" class="section-content-note section-content-note-3 section-content-alert"><i class="fa fa-check"></i><span>Success :</span>Thanks for inviting your friends </div>

					<div class="clearfix"></div>
				</form>
			</div>
			<div class="col-md-6">
				<div class="head-title section-content-title"><h3><span>Invite Through Social Networks</span></h3></div>
				<a class="facebook-account" href="javascript:void(0)"  onclick="FacebookInviteFriends();">Facebook Account</a>
				 
			</div>
		</div>
	</section>


 