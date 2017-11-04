<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 10/1/15
 * Time: 10:28 PM
 *
 * deleteBookingConfirmed.php goes through each booking within roomBookings.xml
 * and if the name, number, checkin and checkout from the user match
 * the contents of a booking that booking is completely removed.
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
                unset($booking->name[0]);
                unset($booking->number[0]);
                unset($booking->checkin->year[0]);
                unset($booking->checkin->month[0]);
                unset($booking->checkin->day[0]);
                unset($booking->checkin[0]);
                unset($booking->checkout->year[0]);
                unset($booking->checkout->month[0]);
                unset($booking->checkout->day[0]);
                unset($booking->checkout[0]);
                unset($booking[0]);
                $bookings->saveXML('../xml/roomBookings.xml');
                echo "<h2>Booking Deleted!!</h2>";
            }
        }
        ?>
    </div>

<?php include("../htaccess/footer.php"); ?>