
<section class="container clearfix main-container">
	<section class="section-content section-login">
		<div class="section-content-head">
			<i class="fa fa-user"></i>
			<div>
				<h3>Forgot Password</h3>
				<p>Please enter your email address so that we can send you an email to reset your password. </p>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php echo form_open("auth/forgot_password");?>
			<div class="row">
				<div class="col-md-6">
					<div class="user-email margin-0">
						<?php echo form_input($email);?>
						<i class="fa fa-indent"></i>
					</div>
				</div>
				<div class="col-md-6">
					<input type="submit" class="margin-0" value="Get Your Password" />
				</div>
			</div>
			<div class="clearfix"></div>
			<?php echo form_close();?>
	</section><!-- End section-content -->
</section><!-- End main-container -->
