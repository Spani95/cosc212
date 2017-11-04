<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 10/1/15
 * Time: 6:35 PM
 *
 * addTypeValidation.php does checking to see if the values passed entered in
 * the addType form are acceptable if not an message is displayed.
 * If no errors are found the room is add to the roomTypes.xml file
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
    if(isEmpty($_POST['id'])) {
        echo "<p>Enter a valid room type.</p>";
        $noErrors = false;
        unsetSession('id');
    } else {
        setSession('id');
    }

    if(isEmpty($_POST['typeDescription'])){
        echo "<p>Enter a description.</p>";
        $noErrors = false;
        unsetSession('typeDescription');
    } else {
        setSession('typeDescription');
    }

    if((!isDigits($_POST['maxGuests'])) || ($_POST['maxGuests'] >= 15)) {
        if ($_POST['maxGuests'] >= 15) {
            echo "<p>Max Guests can not exceed 15</p>";
        } else {
            echo "<p>Enter valid max guests value.</p>";
        }
        $noErrors = false;
        unsetSession('maxGuests');
    } else {
        setSession('maxGuests');
    }
    if($noErrors) {
        session_destroy();
        $roomTypes = simplexml_load_file('../xml/roomTypes.xml');
        $newType = $roomTypes->addChild('roomType');
        $newType->addChild('id', $_POST['id']);
        $newType->addChild('description', $_POST['typeDescription']);
        $newType->addChild('maxGuests', $_POST['maxGuests']);
        $roomTypes->saveXML('../xml/roomTypes.xml');
        echo "<h2>Success!!</h2>";
        echo "<p><strong>Added Room Type:</strong> ".$_POST['id'].", <strong>Max Guests:</strong> ".$_POST['maxGuests'].",<br><strong>Type Description:</strong> ".$_POST['typeDescription']."</p>";
    } else {
        echo "<p><strong>Return to <a href='addRoom.php'>adding room.</a></strong></p>";
    }
    ?>
</div>

<?php include("../htaccess/footer.php"); ?>