<section class="container clearfix main-container">
    <div class="col-md-16">
        <?php if(count($notifications) != 0) { ?>
            <a href="<?= site_url("notifications/read_all") ?>">Mark all as read</a>
        <?php } ?>
        <?php if ($notifications) { ?>
            <?php foreach ($notifications as $notification) { ?>
                <div class="friends-container clearfix">
                    <div class="user-data col-md-10">
                        <h3>
                            <?php
                                $content = str_replace("friend_id", "<a href='" . site_url("friends/locations/" . $notification->friend_id) . "'>" . $notification->friend_name . "</a>", $notification->content);
                                $content = str_replace("location_id", "<a href='" . site_url($notification->location_title) . "'>" . $notification->location_title . "</a>", $content);
                                if($notification->read) {
                                    echo "<span style='color:green'>-Read-</span> ";
                                }
                                else {
                                    echo "<span style='color:red'>-Unread-</span> ";
                                }
                                echo $content;
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo $notification->date;
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                
                                $btnText = "";
                                switch($notification->call_to_action) {
                                    case "friend_profile":
                                        $btnText = "View Profile";
                                        break;
                                    case "location":
                                        $btnText = "View Location";
                                        break;
                                    case "create_location":
                                        $btnText = "Create Location";
                                        break;
                                }
                                echo "<a href='" . site_url("notifications/read_notification/" . $notification->id) . "'>$btnText</a>";
                                echo "<br/>";
                            ?>
                        </h3>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="section-content-note section-content-note-5 section-content-alert margin-0"><i class="fa fa-microphone"></i><span>Note:</span> You don't have any new notifications. </div>
        <?php } ?>
        <div class="pagination">
            <?= $links ?>
        </div>
    </div>
</section><!-- End main-container -->
