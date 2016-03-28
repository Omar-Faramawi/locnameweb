<div id="header" class="">
    <div class="container">

    <!-- SHOW THIS IN OTHER PAGES
    <a href="<?= site_url() ?>" class="pull-left">
        <img src="<?= base_url("assets/main") ?>/img/locname-logo.png" alt="logo" class="logo"/>
    </a>
    SHOW THIS IN OTHER PAGES -->

    <?php if(!$this->ion_auth->logged_in()) { ?>

    <div class="pull-right">
        <ul class="inline">

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class='fa fa-sign-in'></span>
                    Login</a>
                <ul class="dropdown-menu dropdown-login">
                    
                    <form action="<?= site_url("auth/login") ?>"  method="post" > 
                        <label>Email</label>
                        <input type="text" placeholder="Email Address"  name="identity"  id="identityinput" class="input-xlarge" data-toggle="tooltip"  data-placement="left" title="Enter Your Email Address" >
                        <label>Password</label>
                        <input type="password" name="password"  id="password" placeholder="Password" class="input-xlarge" data-toggle="tooltip"  data-placement="left" title="EnterYour Password" >
                        <a href="<?= site_url("auth/forgot_password")?>" class="btn btn-link">Forgot password?</a>
                        <button type="submit" class="btn btn-success btn-block btn-large">Submit</button>
                    </form>
                    
                    <div class="ui horizontal divider">OR</div>
                    
                    <div class="text-center login-social">
                        
                        <div>
                            <a class="btn btn-social btn-facebook" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Facebook/home") ?>');">
                                <i class="fa fa-facebook"></i> Sign in with Facebook
                            </a>
                        </div>
                        
                        <div class="hide">
                            <a class="btn btn-social btn-google-plus" href="<?= base_url("assets/main/img/googlelogin.png") ?>">
                                <i class="fa fa-google-plus"></i> Sign in with Google Plus
                            </a>
                        </div>

                    </div>

                </ul>

            </li>

            <li>
                <a href="<?= site_url("auth/register") ?>" class="item">
                    <span class='fa fa-user'></span>
                    Register
                </a>
            </li>

        </ul>
    </div>

    <?php }  else  { ?>

    <div class="pull-right">
        <ul class="inline">
            <li><?= userPhoto( array("class" => "img-circle" , "style" => "max-width:50px;") ) ?></li>
            <li><a href="<?= site_url("user/update") ?>"><i class="fa fa-user"></i> Update Profile</a></li>
            <li><a href="<?= site_url("user/locations") ?>"><i class="fa fa-map-marker"></i> Locations</a></li>
            <li><a href="<?= site_url("favourite") ?>"><i class="fa fa-heart"></i> Favorites</a></li>
            <li><a href="<?= site_url("user/followers/me") ?>"><i class="fa fa-twitter"></i> Followers</a></li>
            <li><a href="<?= site_url("user/followers") ?>"><i class="fa fa-heart"></i> Following</a></li>
            
            <?php if($user->provider == "Facebook") { ?>
            <li class="hide" ><a href="<?= site_url("user/mutualFriends") ?>"><i class="fa fa-heart"></i> mutual </a></li>
            <?php } ?>
            <li><a href="<?= site_url("auth/logout") ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </div>

    <?php } ?>
</div>
</div>