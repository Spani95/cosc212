<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 9/30/15
 * Time: 11:13 AM
 *
 * modifyRoom.php contains has two forms within it.
 * The first is to modify a existing room.
 * The room number, type, description and pricePerNight can all be modified.
 * If no new room number, type, description or pricePerNight are entered they values
 * are set to what they were originally(this is done in the modifyRoomValidation.php page).
 *
 * The second is a form that asks for a room with a select tag containing all the room from
 * hotelRoom.php when submitted the specified room is posted onto the deleteRoomValidation.php page.
 */
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
include("../htaccess/header.php");
?>

<div id="main">
    <p class="backTrack"><a href="../admin.php">Administration Home</a></p>
    <h3>Modify Room</h3>
    <form class="roomMisc" action="modifyRoomValidation.php" method="post">
        <fieldset>
            <legend>Modify a Room</legend>
            <p>
                <label>Change Room:</label>
                <select name="roomNumber"<?php
                if (isset($_SESSION['roomNumber'])) {
                    $room = $_SESSION['roomNumber'];
                }?>>
                    <?php
                    $hotelRooms = simplexml_load_file('../xml/hotelRooms.xml');
                    foreach($hotelRooms->hotelRoom as $hotelRoom) {
                        $number = $hotelRoom->number;
                        if ($number === $room) {
                            echo "<option value='$number' selected>$number</option>";
                        } else {
                            echo "<option value='$number'>$number</option>";
                        }
                    }
                    ?>
                </select>
            </p>
            <p>
                <label>New Room Number:</label>
                <input type="text" name="number"<?php
                if (isset($_SESSION['number'])) {
                    $number = $_SESSION['number'];
                    echo "value='$number'";
                }
                ?>>
            </p>
            <p>
                <label>New Room Type:</label>
                <select name="roomType"<?php
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
                <label>New Description:</label>
                <textarea name="description" rows="4"><?php
                    if (isset($_SESSION['description'])) {
                        $description = $_SESSION['description'];
                        echo "$description";
                    }
                    ?></textarea>
            </p>
            <p>
                <label>New Price Per Night:</label>
                <input type="text" name="pricePerNight"<?php
                if (isset($_SESSION['pricePerNight'])) {
                    $pricePerNight = $_SESSION['pricePerNight'];
                    echo "value='$pricePerNight'";
                }
                ?>>
            </p>
            <input class='submit' type="submit" value="Modify Room">
        </fieldset>
    </form>

    <h3>Delete Room</h3>

    <form class="roomMisc" action="deleteRoomValidation.php" method="post">
        <fieldset>
            <p>
                <label>Delete Room:</label>
                <select name="number">
                    <?php
                    $hotelRooms = simplexml_load_file('../xml/hotelRooms.xml');
                    foreach($hotelRooms->hotelRoom as $hotelRoom) {
                        $number = $hotelRoom->number;
                        echo "<option value='$number'>$number</option>";
                    }
                    ?>
                </select>
            </p>
            <input class='submit' type="submit" value="Delete Room">
        </fieldset>
    </form>

</div>

<?php include("../htaccess/footer.php"); ?>
