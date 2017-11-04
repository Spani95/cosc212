<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 10/2/15
 * Time: 2:58 PM
 *
 * modifyRoomConfirmed.php goes through each room within hotelRooms.xml
 * and if the number from the user matches the new number of a room the room
 * contents are removed from hotelRooms.xml and then the room is formed again
 * with the new values.
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
        $roomType = $hotelRoom->roomType;
        $description = $hotelRoom->description;
        $pricePerNight = $hotelRoom->pricePerNight;
        if ($_POST['roomNumber'] == $number) {
            unset($number[0]);
            unset($roomType[0]);
            unset($description[0]);
            unset($pricePerNight[0]);

            $hotelRoom->addChild('number', $_POST['number']);
            $hotelRoom->addChild('roomType', $_POST['roomType']);
            $hotelRoom->addChild('description', $_POST['description']);
            $hotelRoom->addChild('pricePerNight', $_POST['pricePerNight']);
        }
    }
    $hotelRooms->saveXML('../xml/hotelRooms.xml');
    echo "<h2>Success!!</h2>";
    ?>
</div>

<?php include("../htaccess/footer.php"); ?>