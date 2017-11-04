<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 9/30/15
 * Time: 11:06 AM
 *
 * addRoomValidation.php does checking to see if the values passed entered in
 * the addRoom form are acceptable if not an message is displayed.
 * If no errors are found the room is add to the hotelRoom.xml file
 * and a success message is displayed.
 */
$currentPage = basename($_SERVER['PHP_SELF']);
include("../htaccess/header.php");
include("../htaccess/validationFunctions.php");
include("../htaccess/sessionFunctions.php")
?>

<div id="main">
    <p class='backTrack'><a href='../admin.php'>Administration Home</a></p>
    <?php
    $noErrors = true;
    $hotelRooms = simplexml_load_file('../xml/hotelRooms.xml');
    foreach ($hotelRooms->hotelRoom as $hotelRoom) {
        $number = $hotelRoom->number;
        if ($number == $_POST['number']) {
            echo "<p>Room " . $_POST['number'] . " all ready exists.</p>";
            $noErrors = false;
            unsetSession("number");
        }
    }
    if(isEmpty($_POST['number']) || !isDigits($_POST['number'])) {
        echo "<p>Enter a valid room number</p>";
        $noErrors = false;
        unsetSession('number');
    } else {
        setSession('number');
    }
    if(isEmpty($_POST['roomType'])){
        echo "<p>Enter a room type.</p>";
        $noErrors = false;
        unsetSession('roomType');
    } else {
        setSession('roomType');
    }
    if(isEmpty($_POST['description'])){
        echo "<p>Enter a description.</p>";
        $noErrors = false;
        unsetSession('description');
    } else {
        setSession('description');
    }
    if(!isCurrency($_POST['pricePerNight'])){
        echo "<p>Enter valid price per night e.g. 100 or 100.00</p>";
        $noErrors = false;
        unsetSession('pricePerNight');
    } else {
        setSession('pricePerNight');
    }

    if($noErrors) {
        session_destroy();
        $hotelRooms = simplexml_load_file('../xml/hotelRooms.xml');
        $newRoom = $hotelRooms->addChild('hotelRoom');
        $newRoom->addChild('number', $_POST['number']);
        $newRoom->addChild('roomType', $_POST['roomType']);
        $newRoom->addChild('description', $_POST['description']);
        $newRoom->addChild('pricePerNight', $_POST['pricePerNight']);
        $hotelRooms->saveXML('../xml/hotelRooms.xml');
        echo "<h2>Success!!</h2>";
        echo "<p><strong>Added Room:</strong> ".$_POST['number'].": ".$_POST['roomType'].", $".$_POST['pricePerNight']." per Night.<br>".$_POST['description']."</p>";
    } else {
        echo "<p><strong>Return to <a href='addRoom.php'>adding room.</a></strong></p>";
    }
    ?>

</div>

<?php include("../htaccess/footer.php"); ?>