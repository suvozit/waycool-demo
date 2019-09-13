<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script type="text/javascript">
    $(document).on('click', '.social-popup', function(e) {
        var $this = $(this)
        if ($this.is('a')) e.preventDefault();
        var $btn = $this;
        var oAuthURL = $btn.attr('href');
        win = window.open(oAuthURL, '_blank', 'modal=yes,alwaysRaised=yes,width=500,height=700');
        checkConnect = setInterval(function() {
            if (!win || !win.closed) return;
            clearInterval(checkConnect);
            window.location.reload();
        }, 100);
    });
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaC_q69tAwFjlsZwQpMFnS4uzqQnwZDM4&libraries=places"></script>
<script>
    $(document).ready(function () {
        google.maps.event.addDomListener(window, 'load', initialize);
    });

    function initialize() {
        var input = document.getElementById('inputLocation');
        var autocomplete = new google.maps.places.Autocomplete(input);
    }
</script>
