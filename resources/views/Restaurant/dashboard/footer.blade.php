<?php
use App\Models\AppSetting;
$appsettings = AppSetting::all()->toArray();

?>

<footer id="footer" class="footer">
    <div class="copyright"> &copy; Copyright  <a href="https://afroel.com/" target="_blank"><strong><span>Afroel Technology</span></strong></a> All Rights Reserved</div>
 </footer>
 <script>
    document.getElementById('get-location').addEventListener('click', function () {
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
    }, function (error) {
        alert('Error getting location: ' + error.message);
    });
} else {
        alert('Geolocation is not supported by this browser.');
    }
});
 </script>
