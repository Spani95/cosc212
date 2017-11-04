<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 10/1/15
 * Time: 9:16 PM
 *
 * modifyRoomValidation.php first checks to see if the new number is empty or if it
 * matches the room that is specified to be modified if it is the new number is
 * set to 'roomNumber'. If it is not empty and does'nt match the specified room
 * it goes through all the room numbers in hotelRooms.xml and if it finds a match
 * a error message is thrown.
 * When checking the description and pricePerNight it does it in a foreach loop so that
 * if the either of them are empty they can be set to their original value.
 * If there are no errors found a hidden form is created containing the information to be changed to.
 * An message is produced asking if they would like to modify the room to the specified value and if confirmed
 * they are redirected to modifyRoomConfirmed.php.
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include("../htaccess/header.php");
include("../htaccess/validationFunctions.php");
include("../htaccess/sessionFunctions.php")
?>
    <div id="main">
        <p class="backTrack"><a href="../admin.php">Administration Home</a></p>
        <?php
        $noErrors = true;
        $hotelRooms = simplexml_load_file('../xml/hotelRooms.xml');

        if(isEmpty($_POST['number']) || ($_POST['number'] == $_POST['roomNumber'])) {
            $_POST['number'] = $_POST['roomNumber'];
        } else {
            foreach ($hotelRooms->hotelRoom as $hotelRoom) {
                $number = $hotelRoom->number;
                if ($number == $_POST['number']) {
                    echo "<p>Room " . $_POST['number'] . " all ready exists.</p>";
                    $noErrors = false;
                    unsetSession("number");
                } else {
                    setSession('number');
                }
            }
        }
        foreach ($hotelRooms->hotelRoom as $hotelRoom) {
            $number = $hotelRoom->number;
            if ($number == $_POST['roomNumber']) {
                if (isEmpty($_POST['description'])) {
                    $_POST['description'] = $hotelRoom->description;
                } else {
                    setSession('description');
                }
                if (isEmpty($_POST['pricePerNight'])) {
                    $_POST['pricePerNight'] = $hotelRoom->pricePerNight;
                }
            }
        }

        if(!isCurrency($_POST['pricePerNight'])){
            echo "<p>Enter valid price per night e.g. 100 or 100.00</p>";
            $noErrors = false;
            unsetSession('pricePerNight');
        } else {
            setSession('pricePerNight');
        }

        if ($noErrors) {
            session_destroy();
            $roomNumber = $_POST['roomNumber'];
            $number = $_POST['number'];
            $roomType = $_POST['roomType'];
            $description = $_POST['description'];
            $pricePerNight = $_POST['pricePerNight'];
            echo "<p><strong>Modify Room: ".$_POST['roomNumber']."<br>To:</strong> ".$_POST['number'].": ".$_POST['roomType'].", $".$_POST['pricePerNight']." per Night.<br>".$_POST['description']."?</p>";
            echo "<form action='modifyRoomConfirmed.php' method='post'>";
            echo "<input type='hidden' name='roomNumber' value='$roomNumber'>";
            echo "<input type='hidden' name='number' value='$number'>";
            echo "<input type='hidden' name='roomType' value='$roomType'>";
            echo "<input type='hidden' name='description' value='$description'>";
            echo "<input type='hidden' name='pricePerNight' value='$pricePerNight'>";
            echo "<input class='submit' type='submit' value='Confirm Modification!'></form>";
        } else {
            echo "<p><strong>Return to <a href='modifyRoom.php'>modifying/delete room.</a></strong></p>";
        }

        ?>
    </div>

<?php include("../htaccess/footer.php"); ?>