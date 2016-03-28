<div class="header-locname">
    <section class="container clearfix">
        <div>
            <h3>LocName gives your location a short, unique name which you can share with your friends and clients so they can easily find your address!</h3>
            <a href="<?= site_url("registerlocation") ?>">Register a new LocName</a>
            <div class="clearfix"></div>
        </div>
    </section>

</div><!-- End header-locname -->

<div class="header-search header-search-2">
    <section class="container clearfix">
        <div>
            <form method="GET" action="<?= site_url("location/redirect") ?>" id="topSearch">
                <input type="text" name="title" placeholder="Search LocNames" data-provide="typeahead" autocomplete="off" id="appendedInputButton" value="" >
                <button type="submit"><i class="fa fa-search"></i></button>
                <div class="clearfix"></div>
                <div class="section-content-note section-content-note-5 section-content-alert margin-0 hide" id="LocationNotFound" ><i class="fa fa-microphone"></i><span>Note :</span> This is NOT a registered LocName, would you like to <a  href="<?= site_url("registerlocation")?>">register</a> it?!.</div>
            </form>
        </div>
    </section>
</div><!-- End header-search -->

<section class="container clearfix">
    <div class="header-search-index-2" id="close-find-what">Didn’t find what you’re looking for? Try our <a href="javascript:void(0)" id="openAdvancedSearch" >Advanced Search</a> Now!.</div>
</section>

<div class="header-search hide" id="advancedSearchContainer" >
    <section class="container clearfix">
        <div>
            <form  action="<?= site_url("search/index") ?>" method="get" >

                <input placeholder="Mobile Number" name="mobile" type="text" >
                <div class="select-div">
                    <select id="countrySearch" name="country" >
                        <option value="0">Choose Country</option>
                        <?php foreach ($countries as $country) { ?>
                            <option value="<?= $country->country_name ?>" data-value="<?= $country->country_name ?>" ><?= $country->country_name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="select-div">
                    <select name="type" id="seachLocationType">
                        <option value="0">Select Type</option>
                        <option value="public">Public</option>
                        <option value="business">Business</option>
                        <option value="personal">Personal</option>
                        <option value="event">Event</option>
                    </select>
                </div>

				<input placeholder="Owner Name" name="username" type="text" >

                <button type="submit"><i class="fa fa-search"></i></button>
                <div class="clearfix"></div>
            </form>
        </div>
    </section>
</div>