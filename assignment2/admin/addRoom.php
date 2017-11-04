<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 9/30/15
 * Time: 11:04 AM
 *
 * addRoom.php contains has two forms within it.
 * The first is a form to create a new type of room that when submitted is
 * its values are posted onto the addTypeValidation.php page.
 *
 * The second is to add a new room.
 * The new room is formed with a number, roomType, description and pricePerNight.
 * RoomType searches all the types of rooms in roomTypes.xml that are identified by
 * their tag name 'id' after which they are added to the select tag as an option.
 * When the the add room form is submitted you are redirected to addRoomValidation.php.
 */
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
include("../htaccess/header.php");
?>

<div id="main">
    <p class="backTrack"><a href="../admin.php">Administration Home</a></p>
    <h3>Add Room Type</h3>
    <form class="roomMisc" action="addTypeValidation.php" method="post">
        <fieldset>
            <legend>Add Room Type</legend>
            <p>
                <label for="id">Room Type ID:</label>
                <input type="text" name="id" id="id" <?php
                if (isset($_SESSION['id'])) {
                    $id = $_SESSION['id'];
                    echo "value='$id'";
                }
                ?>>
            </p>
            <p class="description">
                <label>Room Type Description:</label>
                <textarea name="typeDescription" rows="2"><?php
                    if (isset($_SESSION['typeDescription'])) {
                        $typeDescription = $_SESSION['typeDescription'];
                        echo "$typeDescription";
                    }
                    ?></textarea>
            </p>
            <p>
                <label for="maxGuests">Max Guests:</label>
                <input type="text" name="maxGuests" id="maxGuests" <?php
                if (isset($_SESSION['maxGuests'])) {
                    $maxGuests = $_SESSION['maxGuests'];
                    echo "value='$maxGuests'";
                }
                ?>>
            </p>
            <input class='submit' type="submit" value="Add Room Type">
        </fieldset>
    </form>
    <h3>Add a Room</h3>
    <form class="roomMisc" action="addRoomValidation.php" method="post">
        <fieldset>
            <legend>Add a Room</legend>
            <p>
                <label for="number">Room Number:</label>
                <input type="text" name="number" id="number" <?php
                if (isset($_SESSION['number'])) {
                    $number = $_SESSION['number'];
                    echo "value='$number'";
                }
                ?>>
            </p>
            <p>
                <label for="roomType">Room Type:</label>
                <select name="roomType" id="roomType" <?php
                if (isset($_SESSION['roomType'])) {
                    $type = $_SESSION['roomType'];
                }?>>
                    <?php
                    $roomTypes = simplexml_load_file('../xml/roomTypes.xml');
                    foreach($roomTypes->roomType as $room) {
                        $id = $room->id;
                        if ($id === $type) {
                            echo "<option value='$id' selected>$id</option>";
                        } else {
                            echo "<option value='$id'>$id</option>";
                        }
                    }
                    ?>
                </select>
            </p>
            <p class="description">
                <label>Description:</label>
                <textarea name="description" rows="4"><?php
                    if (isset($_SESSION['description'])) {
                        $description = $_SESSION['description'];
                        echo "$description";
                    }
                    ?></textarea>
            </p>
            <p>
                <label for="pricePerNight">Price Per Night:</label>
                <input type="text" name="pricePerNight" id="pricePerNight" <?php
                if (isset($_SESSION['pricePerNight'])) {
                    $pricePerNight = $_SESSION['pricePerNight'];
                    echo "value='$pricePerNight'";
                }
                ?>>
            </p>
            <input class='submit' type="submit" value="Add Room">
        </fieldset>
    </form>
</div>

<?php include("../htaccess/footer.php"); ?>