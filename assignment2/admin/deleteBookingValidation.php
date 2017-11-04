<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 10/1/15
 * Time: 9:51 PM
 *
 * deleteBookingValidation.php goes through each booking within roomBookings.xml
 * and if the name, number, checkin and checkout from the user match the
 * contents of a booking a hidden form is created with those values along
 * with a message asking if they want to delete that booking. If the form is
 * submitted you get sent to the confirmation page were the booking is deleted.
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include("../htaccess/header.php");
?>

<div id="main">
    <p class="backTrack"><a href="../admin.php">Administration Home</a></p>
    <?php
    $bookings = simplexml_load_file('../xml/roomBookings.xml');
    foreach($bookings->booking as $booking) {
        $name = $booking->name;
        $number = $booking->number;
        $checkin = $booking->checkin->year."-".$booking->checkin->month."-".$booking->checkin->day;
        $checkout = $booking->checkout->year."-".$booking->checkout->month."-".$booking->checkout->day;
        if ($_POST['name'] == $name && $_POST['number'] == $number && $_POST['checkin'] == $checkin && $_POST['checkout'] == $checkout) {
            echo "<p><strong>Delete Booking For:</strong> $name - Room: $number from $checkin to $checkout?</p>";
            echo "<form action='deleteBookingConfirmed.php' method='post'>";
            echo "<input type='hidden' name='name' value='$name'>";
            echo "<input type='hidden' name='number' value='$number'>";
            echo "<input type='hidden' name='checkin' value='$checkin'>";
            echo "<input type='hidden' name='checkout' value='$checkout'>";
            echo "<input class='submit' type='submit' value='Confirm Deletion!'></form>";
        }
    }
    ?>
</div>

<?php include("../htaccess/footer.php"); ?>
