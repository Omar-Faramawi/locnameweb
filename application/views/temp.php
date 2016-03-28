    <div class="container main-content">

        <div class="pg-header">
          <h3 class="pg-title">Passcode</h3>
          <p>Find how can you reach this place</p>
        </div>

        <!-- PASSCODE -->
        <a href="#passcode" data-toggle="modal">Use this Link and Code under it to run your Passcode</a>
         
        <!-- Modal -->
        <div id="passcode" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <div class="pg-header">
              <h3 class="pg-title">Passcode</h3>
              <p>Find how can you reach this place</p>
            </div>
          </div>
          <div class="modal-body">
            <form action="" method="POST">

            <div id="login-panel">
            <div id="infoMessage"><?php echo $message; ?></div>

            <div class="passcode-input text-center">
                <input type="password" name="passcode" required="required" class="input span3 alpha">
                <input type="submit" value="Validate"  class="btn btn-info"/>
                <p>Some Contects should go here [ example what is locname ?]</p>
            </div>
    
            </div>

            </form>
          </div>
        </div>

        <!-- ABOUT US PAGE STARTS HERE -->
        <div class="pg-header">
          <h3 class="pg-title">About Us</h3>
          <p>Text about us</p>
        </div>
        <div class="text-center row-fluid">
            <img src="<?= base_url("assets/main") ?>/img/logo.png" alt="logo" class=""/>
            <div class="about-us">
                <h3>What is LocName.com</h3>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo autem cum reprehenderit dolorem vel perferendis nisi voluptas culpa impedit odio harum consequatur minima nesciunt dolore sequi non consequuntur molestias cupiditate.</p>

                <hr>

              <div class="row-fluid">
                <div class="span4">
                <i class="fa fa-users icon-large fa-3x"></i>
                <h3 class="main-hd">Share With Friends</h3>
                <p class="lead">Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus</p>
                </div><!-- /.span4 -->
                <div class="span4">
                <i class="fa fa-heart icon-large fa-3x"></i>
                <h3 class="main-hd">Collect Favorites</h3>
                <p class="lead">Duis mollis, , tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                </div><!-- /.span4 -->
                <div class="span4">
                <i class="fa fa-map-marker icon-large fa-3x"></i>
                <h3 class="main-hd">How To Go ?</h3>
                <p class="lead">Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod seamet risus.</p>
                </div><!-- /.span4 -->
              </div>

            </div>
        </div>
        <!-- ABOUT US PAGE ENDS HERE -->

        <!-- TERMS AND CONDITIONS STARTS HERE -->
        <div class="pg-header">
          <h3 class="pg-title">Terms & Conditions</h3>
          <p>Text Terms</p>
        </div>
        <div class="row-fluid">

            <ul>
                <li><a href="#term-one">Terms - Conditions 1</a></li>
                <li><a href="#term-two">Terms - Conditions 2</a></li>
                <li><a href="#term-three">Terms - Conditions 3</a></li>
            </ul>

            <hr>

            <div id="term-one" class="row-fluid">
                <h4 class="main-hd">Terms - Conditions 1 Header</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti quod consectetur recusandae dignissimos omnis dolorem nesciunt illo officia quidem excepturi. Odit inventore culpa porro sunt aspernatur quasi reprehenderit delectus veniam.</p>
            </div>

            <hr>

            <div id="term-two" class="row-fluid">
                <h4 class="main-hd">Terms - Conditions 1 Header</h3>
                <p>Customers have the right to own more than one LOCNAME account in LOCNAME network , Customers are also entitled to transfer ownership
                of these accounts from his personal property to someone else's property under the terms set in this agreement .
                </p>
                <div class="alert">The company has the right to withdraw the number and re-sell it again to another customer after 90 days from the date of expiry.
                Client is not entitled to claim any sums of money (the credit of the account at the moment of cancellation) were exists in the account after the expiry of this period to 90 days.</div>  
            </div>

            <hr>

            <div id="term-three" class="row-fluid">
                <h4 class="main-hd">Terms - Conditions 1 Header</h3>
                <p>Each client binding and before purchasing or registrating the ownership of his account , whether through our official website or our official branches agents or distributors, to provide correct personal data and non-fraudulent and that for security reasons and it's are as follows: (First name - last name - phone number - e-mail - full address) and other important data.
                <div class="alert">
                <ul>
                <li>The company has the right to disconnect all lines that do not registered any unused data, or false or incorrect.</li>
                <li>We should point out that this disconnection may occur within 30 days from the date of the first call.</li>
                <li>The company has the right to withdraw the number and re-sell it again to another client after 90 days from the date of expiration or disconnection .</li>
                <li>Client is not entitled to claim any money or doing any legal action as a result of this chapter</li>
                </ul>
            </div>
        </div>
        <!-- TERMS AND CONDITIONS ENDS HERE -->

        <!-- CONTACT US PAGE STARTS HERE -->
        <div class="pg-header">
          <h3 class="pg-title">Contact Us</h3>
          <p>We’re happy to answer any questions you have or provide you with an estimate. Just send us a message in the form below.</p>
        </div>
        <div class="row-fluid">

            <div class="span6 form-horizontal">

                <div class="control-group">
                <label class="control-label" for="inputEmail">Name</label>
                <div class="controls">
                    <?php echo form_input($username); ?>
                </div>
                </div>

                <div class="control-group">
                <label class="control-label" for="inputPassword">Email</label>
                <div class="controls">
                    <?php echo form_input($email); ?>
                </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Message</label>
                    <div class="controls">
                        <textarea class="textarea span7" required="" name="" id="" placeholder="Write here a brief Description what is that locName about"></textarea>
                    </div>
                </div>

                <div class="control-group">
                <div class="controls">
                    <input type="submit" value="Send"  class="btn btn-info login-loc-register btn-large span7"/> 
                </div>
                </div>

            </div>

            <div class="span5 offset1">
                <h3 class="main-hd">Contact Us</h3>
                <ul>
                    <li>
                        <p class="lead">
                            EMAIL: <a href="info@locname.com">info@locname.com</a>
                        </p>
                    </li>
                    <li>
                        <p class="lead">
                            ADDRESS: Combadi Ltd. - 1 Kings Avenue - London - N21 3NA - England
                        </p>
                    </li>
                </ul>
                <hr>
                <h3 class="main-hd">Follow Us</h3>
                <ul class="inline">
                    <li><a href="#"><i class="fa fa-facebook-square fa-5x"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter-square fa-5x"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin-square fa-5x"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram fa-5x"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- CONTACT US PAGE ENDS HERE -->

    </div>