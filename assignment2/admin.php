<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 9/29/15
 * Time: 3:09 PM
 *
 * admin.php goes through each booking within roomBookings.xml
 * and adds a hidden form with a corresponding line specifying the booking
 * information to a list.
 *
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include ("htaccess/header.php");
?>
<div id="main">
    <h2>Current Bookings </h2>
    <ul class="bookingList">
        <?php
        $bookings = simplexml_load_file('xml/roomBookings.xml');
        foreach($bookings->booking as $booking) {
            $name = $booking->name;
            $number = $booking->number;
            $checkin = $booking->checkin->year."-".$booking->checkin->month."-".$booking->checkin->day;
            $checkout = $booking->checkout->year."-".$booking->checkout->month."-".$booking->checkout->day;
            echo "<li><form action='admin/deleteConfirm.php' method='post'>";
            echo "<input type='hidden' name='name' value='$name'>";
            echo "<input type='hidden' name='number' value='$number'>";
            echo "<input type='hidden' name='checkin' value='$checkin'>";
            echo "<input type='hidden' name='checkout' value='$checkout'>";
            echo "<input class='submit' type='submit' value='Delete Booking'>  <strong>$name</strong> - Room: $number from $checkin to $checkout</form></li>";
        }
        ?>
    </ul>

    <h3>Add Room</h3>
    <form action="admin/addRoom.php">
        <input class='submit' type="submit" value="Add Room">
    </form>

    <h3>Modify/Delete Rooms</h3>
    <form action="admin/modifyRoom.php">
        <input class='submit' type="submit" value="Modify Room">
    </form>

</div>

<?php include("htaccess/footer.php"); ?>