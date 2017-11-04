<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 9/29/15
 * Time: 6:05 PM
 *
 * validateBooking.php has a small amount of checking to see if the
 * name and dates are valid. These are mainly redundant and insignificant as
 * the java script does the majority of the checking.
 * If there were no errors found a new booking is created in roomBookings.xml
 * and a success message is produced.
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include("../htaccess/header.php");
include("../htaccess/sessionFunctions.php");
include("../htaccess/validationFunctions.php");
?>

<div id="main">
    <h3>Booking Validation</h3>

    <?php
    $noErrors = true;
    if (isEmpty($_POST["bookingName"])) {
        echo "<p> No given name.</p>";
        $noErrors = false;
        unsetSession("bookingName");
    } elseif (!isString($_POST['bookingName'])) {
        echo "<p>Not a valid name.</p>";
        $noErrors = false;
        unsetSession("bookingName");
    } else {
        setSession('bookingName');
    }

    if (!validDates($_POST['checkinDate'], $_POST['checkoutDate'])) {
        echo "<p>Not valid dates</p>";
        $noErrors = false;
    }

    if ($noErrors) {
        session_destroy();
        $bookings = simplexml_load_file('../xml/roomBookings.xml');
        $newBooking = $bookings->addChild('booking');
        $newBooking->addChild('number', $_POST['roomSelection']);
        $newBooking->addChild('name', $_POST['bookingName']);

        $checkin = $newBooking->addChild('checkin');
        $checkout = $newBooking->addChild('checkout');

        $checkindate = explode('-', $_POST['checkinDate']);
        $checkin->addChild('day', $checkindate[2]);
        $checkin->addChild('month', $checkindate[1]);
        $checkin->addChild('year', $checkindate[0]);

        $checkoutdate = explode('-', $_POST['checkoutDate']);
        $checkout->addChild('day', $checkoutdate[2]);
        $checkout->addChild('month', $checkoutdate[1]);
        $checkout->addChild('year', $checkoutdate[0]);

        $count = 0;
        foreach($bookings as $i) {
            if($count == (count($bookings) - 1)) {
                $name = $i->name;
                $number = $i->number;
                $checkin = $i->checkin->year . "-" . $i->checkin->month . "-" . $i->checkin->day;
                $checkout = $i->checkout->year . "-" . $i->checkout->month . "-" . $i->checkout->day;
                echo "<p>$name - Room: $number from $checkin to $checkout</p>";
            } else {
                $count++;
            }
        }
        $bookings->saveXML('../xml/roomBookings.xml');
        echo "<p>Booking was a success. <a href='../book.php'>Book another room?</a> </p>";
    }

    ?>
</div>

<?php include("../htaccess/footer.php"); ?>