<?php
/**
 * Created by PhpStorm.
 * User: nsparrow
 * Date: 9/29/15
 * Time: 4:09 PM
 *
 * header.php is included at the top of every page in the site for a uniform look.
 *
 */
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <!--Username: nsparrow, id: Spani321 4742998, file: index.html-->
    <meta charset="utf-8">
    <title>Sparrow's Grand Hotel</title>
    <?php if($currentPage === 'index.php' || $currentPage === 'rooms.php' || $currentPage === 'book.php' || $currentPage === 'admin.php') {
        echo "<link rel='stylesheet' type='text/css' href='css/styleSheet.css'>";
    } else {
        echo "<link rel='stylesheet' type='text/css' href='../css/styleSheet.css'>";
    }

    if(isset($scriptList) && is_array($scriptList)){
        foreach ($scriptList as $script){
            echo "<script src='js/$script'></script>";
        }
    }
    ?>
</head>

<body>
<!--Header-->
<div id="header">
    <h1>Grand Hotel</h1>

    <!--Navigation bar-->
    <nav>
        <ul id="nav_bar">
            <?php
            if ($currentPage === 'index.php') {
                echo "<li>Home";
            } else {
                if($currentPage === 'index.php' || $currentPage === 'rooms.php' || $currentPage === 'book.php' || $currentPage === 'admin.php') {
                    echo "<li><a href='index.php'>Home</a>";
                } else {
                    echo "<li><a href='../index.php'>Home</a>";
                }
            }

            if ($currentPage === 'rooms.php') {
                echo "<li>Rooms";
            } else {
                if($currentPage === 'index.php' || $currentPage === 'rooms.php' || $currentPage === 'book.php' || $currentPage === 'admin.php') {
                    echo "<li><a href='rooms.php'>Rooms</a>";
                } else {
                    echo "<li><a href='../rooms.php'>Rooms</a>";
                }
            }

            if ($currentPage === 'book.php') {
                echo "<li>Book a Room";
            } else {
                if($currentPage === 'index.php' || $currentPage === 'rooms.php' || $currentPage === 'book.php' || $currentPage === 'admin.php') {
                    echo "<li><a href='book.php'>Book a Room</a>";
                } else {
                    echo "<li><a href='../book.php'>Book a Room</a>";
                }
            }
            ?>
        </ul>
    </nav>
</div>

