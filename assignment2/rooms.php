<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 9/29/15
 * Time: 3:09 PM
 *
 * room.php goes through each room within hotelRooms.xml and adds the values for the number,
 * roomType, description and pricePerNight to a list to be displayed.
 *
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include ("htaccess/header.php");
?>
<div id="main">
    <h2>Rooms We Offer</h2>
    <ul id="roomList">
        <?php
        $hotelRooms = simplexml_load_file('xml/hotelRooms.xml');
        foreach($hotelRooms->hotelRoom as $hotelRoom){
            $number = $hotelRoom->number;
            $roomType = $hotelRoom->roomType;
            $description = $hotelRoom->description;
            $pricePerNight = $hotelRoom->pricePerNight;
            echo "<li><strong>$number:</strong> $roomType, $$pricePerNight per Night.<br>$description</li>";
        }
        ?>
    </ul>
</div>

<?php include("htaccess/footer.php"); ?>