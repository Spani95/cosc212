<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 9/29/15
 * Time: 3:08 PM
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include ("htaccess/header.php");
?>
    <div id="main">
        <h2>Welcome</h2>
        <p><strong>Welcome to Sparrow's Grand Hotel</strong>. We offer affordable accommodation
            for high quality modern rooms with services such as free WiFi, enthusiastic
            staff and a excellent location in the centre of
            town. Enquire now to <a href="book.php">make a booking</a>.
        </p>
    </div>

<?php include("htaccess/footer.php"); ?>