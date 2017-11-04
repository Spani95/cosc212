<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 10/2/15
 * Time: 2:28 PM
 *
 * deleteRoomConfirmed.php goes through each room within hotelRooms.xml
 * and if the number from the user match the number of a room the room
 * is completely removed from hotelRooms.xml.
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include("../htaccess/header.php");
?>
<div id="main">
    <p class="backTrack"><a href="../admin.php">Administration Home</a></p>
    <?php
    $hotelRooms = simplexml_load_file('../xml/hotelRooms.xml');
    foreach($hotelRooms->hotelRoom as $hotelRoom) {
        $number = $hotelRoom->number;
        if ($number == $_POST['number']) {
            unset($hotelRoom->name[0]);
            unset($hotelRoom->number[0]);
            unset($hotelRoom->roomType[0]);
            unset($hotelRoom->description[0]);
            unset($hotelRoom->pricePerNight[0]);
            unset($hotelRoom[0]);
            $hotelRooms->saveXML('../xml/hotelRooms.xml');
            echo "<h2>Room Deleted!!</h2>";
        }
    }
    ?>
</div>

<?php include("../htaccess/footer.php"); ?>