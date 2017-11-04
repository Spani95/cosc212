/**
 * Created by: Nick Sparrow, 19-Aug-15.
 * Last Modified by: Nick Sparrow, 21/08/2015
 */

var Rooms = (function () {
    "use strict";

    var pub;

    pub = {};

    /*Inserts the data in the hotelRooms.xml content into the rooms.html
     * main content section.*/
    function showRooms() {
        var i;
        var room = "";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "hotelRooms.xml", false);
        xmlhttp.send();
        var xmlDoc = xmlhttp.responseXML;
        var rooms = xmlDoc.getElementsByTagName("hotelRoom");

        var roomNum, bedType, description, price;
        for (i = 0; i < rooms.length; i += 1) {
            roomNum = rooms[i].getElementsByTagName("number")[0].childNodes[0].nodeValue;
            bedType = rooms[i].getElementsByTagName("roomType")[0].childNodes[0].nodeValue;
            description = rooms[i].getElementsByTagName("description")[0].childNodes[0].nodeValue;
            price = rooms[i].getElementsByTagName("pricePerNight")[0].childNodes[0].nodeValue;
            room += "<p><strong>" + roomNum + ": " + bedType + "</strong><br />" + description + " <strong>$" + price + "</strong></p>";
        }
        $("#rooms_to_book").append(room);
    }

    pub.setup = function() {
        showRooms();
    };

    // Expose public interface
    return pub;
}());

$(document).ready(Rooms.setup);
