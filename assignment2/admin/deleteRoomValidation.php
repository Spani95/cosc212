<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 10/2/15
 * Time: 1:00 PM
 *
 * deleteRoomValidation.php goes through each booking within roomBookings.xml
 * and if the number from a booking matches the room trying to be deleted a hidden
 * form is created with the values of the booking and a message asking if they
 * want to delete the booking thats in the room trying to be deleted if 'Delete Booking'
 * is submitted your redirected to deleteBookingValidation.php.
 * If there are no bookings found for the room that is trying to be deleted another hidden
 * form is created containing the number of the room. An message is produced asking if they
 * would like to delete the specified room and if confirmed they are redirected to
 * deleteRoomConfirmed.php.
 *
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include("../htaccess/header.php");
include("../htaccess/validationFunctions.php");
include("../htaccess/sessionFunctions.php")
?>
<div id="main">
    <p class="backTrack"><a href="../admin.php">Administration Home</a></p>
    <ul class='bookingList'>
    <?php
    $noErrors = true;
    $bookings = simplexml_load_file('../xml/roomBookings.xml');
    foreach($bookings->booking as $booking) {
        $name = $booking->name;
        $number = $booking->number;
        $checkin = $booking->checkin->year."-".$booking->checkin->month."-".$booking->checkin->day;
        $checkout = $booking->checkout->year."-".$booking->checkout->month."-".$booking->checkout->day;
        if ($number == $_POST['number']) {
            echo "<form action='deleteBookingValidation.php' method='post'>";
            echo "<input type='hidden' name='name' value='$name'>";
            echo "<input type='hidden' name='number' value='$number'>";
            echo "<input type='hidden' name='checkin' value='$checkin'>";
            echo "<input type='hidden' name='checkout' value='$checkout'>";
            if($noErrors) {
                echo "<h3>Room Has Existing Bookings</h3>";
            }
            echo "<li><input class='submit' type='submit' value='Delete Booking'>  <strong>$name</strong> - Room: $number from $checkin to $checkout</form></li>";
            $noErrors = false;
        }
    }

    if($noErrors) {
        $number = $_POST['number'];
        echo "<p><strong>Delete Room:</strong> $number</p>";
        echo "<form action='deleteRoomConfirmed.php' method='post'>";
        echo "<input type='hidden' name='number' value='$number'>";
        echo "<input class='submit' type='submit' value='Confirm Deletion!'></form>";
    } else {
        echo "<p><strong>Return to <a href='modifyRoom.php'>modifying/delete room.</a></strong></p>";
    }
    ?>
    </ul>

</div>

<?php include("../htaccess/footer.php"); ?>