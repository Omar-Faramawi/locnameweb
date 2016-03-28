<script>
    var reload = true;
    if (opener.document.getElementById('AddLocation') && opener.document.getElementById('lng').value.length > 2) {
        reload = false;
        opener.document.getElementById('finishing').innerHTML = '<img src="<?= base_url("assets/main/img/sloading.gif"); ?>" />';
        opener.document.getElementById('finishing').innerHTML = '<a onclick="CreateLocation()" class="btn btn-success btn-large hide" id="add-locname-hidden" href="#"> Register a New LocName </a>';
        opener.document.getElementById("add-locname-hidden").click();
    }
    if (reload === true) {
        window.opener.location.reload(false);
    }
    window.close();
</script>
