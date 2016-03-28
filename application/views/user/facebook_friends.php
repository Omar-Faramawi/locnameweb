<table class="table table-hover table-striped">

    <tr>
        <th>#</th>
        <th>username</th>
        <th>Action</th>
    </tr>

    <?php foreach ($friends as $friend) { ?>
        <tr>
            <td><img  alt="<?= $friend->displayName ?>"  src="<?= $friend->photoURL ?>" /></td>
            <td><?= $friend->displayName ?></td>
            <td>
                <?php if (is_follwing($friend->user_id)) { ?>
                    <a href="javascript:void(0)" id="followUser"  userid="<?= $friend->user_id ?>" ><i class="fa fa-check-square-o"></i></a>

                <?php } else { ?>
                    <a href="#" id="followUser"  userid="<?= $friend->user_id ?>" >Follow</a>
                <?php } ?>
            </td>

        </tr>
    <?php } ?>

</table>





<div class="row">
    <?php foreach ($friends as $friend) { ?>
        <div class="col-md-3">
            <section class="section-content section-members">
                <div class="members-img"><img  alt="<?= $friend->displayName ?>"  src="<?= $friend->photoURL ?>" /></div>
                <div class="section-members-content">

                    <h3> 
                        <?php if (is_follwing($friend->user_id)) { ?>
                            <a href="javascript:void(0)" id="followUser"  userid="<?= $friend->user_id ?>" ><i class="fa fa-check-square-o"></i></a>

                        <?php } else { ?>
                            <a href="#" id="followUser"  userid="<?= $friend->user_id ?>" >Follow</a>
                        <?php } ?>            
                    </h3>

                </div>
            </section>
        </div>
    <?php } ?>

</div>
<div class="pagination">
    <?php // echo $links ?>
</div><!-- End pagination -->
