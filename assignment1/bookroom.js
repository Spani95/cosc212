/**
 * Created by: Nick Sparrow, 19-Aug-15.
 * Last Modified by: Nick Sparrow, 21/08/2015
 */

var BookRoom = (function(){
    "use strict";

    var pub = {};

    var i;

    /*Returns a list of objects containing all rooms: roomNum and price
    * @return list of all the rooms.*/
    function allRooms(){
        //List of all the hotel rooms
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET","hotelRooms.xml",false);
        xmlhttp.send();
        var xmlDoc = xmlhttp.responseXML;
        var rooms = xmlDoc.getElementsByTagName("hotelRoom");

        var roomNum;
        var price;
        var roomList = [];
        for(i = 0; i < rooms.length; i += 1) {
            roomNum = rooms[i].getElementsByTagName("number")[0].childNodes[0].nodeValue;
            price = rooms[i].getElementsByTagName("pricePerNight")[0].childNodes[0].nodeValue;
            roomList[i] = {
                room: roomNum,
                price: price
            };
        }
        return roomList;
    }

    /*List of objects containing booked rooms: roomNumber,
    * checkInDate and checkOutDate.
    * @return a list of booked rooms*/
    function bookedRooms() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "roomBookings.xml", false);
        xmlhttp.send();
        var xmlDoc = xmlhttp.responseXML;
        var bookedRoom = xmlDoc.getElementsByTagName("booking");

        var bookedRoomNum, dayCheckIn, monthCheckIn, yearCheckIn, dayCheckOut, monthCheckOut, yearCheckOut;
        var bookedList = [];
        for (i = 0; i < bookedRoom.length; i += 1) {
            bookedRoomNum = bookedRoom[i].getElementsByTagName("number")[0].childNodes[0].nodeValue;
            dayCheckIn = bookedRoom[i].getElementsByTagName("day")[0].childNodes[0].nodeValue;
            monthCheckIn = bookedRoom[i].getElementsByTagName("month")[0].childNodes[0].nodeValue;
            yearCheckIn = bookedRoom[i].getElementsByTagName("year")[0].childNodes[0].nodeValue;
            dayCheckOut = bookedRoom[i].getElementsByTagName("day")[1].childNodes[0].nodeValue;
            monthCheckOut = bookedRoom[i].getElementsByTagName("month")[1].childNodes[0].nodeValue;
            yearCheckOut = bookedRoom[i].getElementsByTagName("year")[1].childNodes[0].nodeValue;
            bookedList[i] = {
                room: bookedRoomNum,
                checkInDate: '0' + monthCheckIn.slice(-2) + '/' + dayCheckIn + '/' + yearCheckIn,
                checkOutDate: '0' + monthCheckOut.slice(-2) + '/' + dayCheckOut + '/' + yearCheckOut
            };
        }
        return bookedList;
    }

    /*List of objects containing all available rooms with: room, price
    * @return a list of all available rooms.*/
    function availableRooms() {
        var availableRoomList = [];
        var roomList = allRooms();
        var bookedList = bookedRooms();
        var count = 0;
        var checkIn = $("#checkInDate").val();
        var checkOut = $("#checkOutDate").val();
        var j, match;
        for (i = 0; i < roomList.length; i += 1) {
            match = false;
            for (j = 0; j < bookedList.length; j += 1) {
                if (bookedList[j].room === roomList[i].room && ((bookedList[j].checkInDate < checkIn && bookedList[j].checkOutDate > checkIn) || (bookedList[j].checkInDate < checkOut && bookedList[j].checkOutDate > checkOut) || (bookedList[j].checkInDate > checkIn && bookedList[j].checkOutDate < checkOut))){
                    match = true;
                    break;
                }
            }
            if (match === false) {
                availableRoomList[count] = roomList[i];
                count += 1;
            }
        }
        return availableRoomList;
    }

    /*makeItemHTML makes a ul with each li the value of the cookies name, room,
    * check in date and check out date which is then returned.
    * @param itemList, list of cookies.
    * @return a piece of html to be inserted into the bookroom.html.*/
    function makeItemHTML(itemList) {
        var html = "";
        html += "<ul><h3>Pending Bookings:</h3>";
        itemList.forEach(function (item) {
            html += "<li><strong>" + item.bName + "</strong> - Room: " + item.room + ", From: " + item.checkIn + ", To: " + item.checkOut + "</li>";
        });
        html += "</ul>";
        return html;
    }

    /*Is called on set up and when the book button is pressed.
    * Gets a list of all the cookies with the name pendingBooking and
    * if there is any cookies calls the makeItemHTML function on the
    * pending_bookings div to be displayed to user.*/
    function insertPending() {
        var itemList, pendingElement;
        itemList = Cookie.get("pendingBooking");
        pendingElement = document.getElementById("pending_bookings");
        if (itemList) {
            itemList = JSON.parse(itemList);
            pendingElement.innerHTML = makeItemHTML(itemList);
        }
    }

    /*Content to be inserted after "Find Room" button has been clicked
    * along with the Cookie set up when the "Book Room" button is clicked
    * provided that there is no errors i.e. no name entered.*/
    function contents() {
        //List of objects for all the available rooms with the rooms: room number and price.
        var availableRoomList = availableRooms();

        //Clearing the contents of the available rooms so that they can be input with the new values
        //after the find_room button is clicked again.
        $("#bookingContents").empty();

        var content = "";
        content += "<ul><li><label for='booking_name'><strong>Name:</strong></label><input type='text' id='booking_name'></li>";
        content += "<li><label for='roomSelected'><strong>Select Room:</strong></label><select id='roomSelected'>";
        for (i = 0; i < availableRoomList.length; i += 1) {
            content += "<option>" + availableRoomList[i].room + ": $" + availableRoomList[i].price + " per night</option>";
        }
        content += "</select></li><li><input type='button' value='Book Room' id='book'></li></ul>";
        $("#bookingContents").append(content);

        //Setting cookie and pending_bookings div.
        $("#book").click(function() {
            var bookedName = $("#booking_name").val();
            var room = $("#roomSelected").val().slice(3);
            var checkIn = $("#checkInDate").val();
            var checkOut = $("#checkOutDate").val();
            var itemList, newItem;

            //If a name has been entered.
            if(bookedName !== "") {
                $("#error_message").empty();
                itemList = Cookie.get("pendingBooking");
                if (itemList) {
                    itemList = JSON.parse(itemList);
                } else {
                    itemList = [];
                }
                newItem = {};
                newItem.bName = bookedName;
                newItem.room = room;
                newItem.checkIn = checkIn;
                newItem.checkOut = checkOut;
                itemList.push(newItem);
                Cookie.set("pendingBooking", JSON.stringify(itemList));
            }else{
                $("#error_message").empty();
                $("#error_message").append("<p>Please Enter a Name.</p>");
            }
            insertPending();
        });
    }

    /*Sets up up date pickers for the check in and check out.
    * Finds the current date for error checking when find_room button is clicked.
    * Contains function for the find_room click that does the error checking for the
    * dates and if it passes all the checks it calls the contents function.*/
    function selectRoom() {
        /*Creating DatePickers on the checkInDate and checkOutDate input elements.
         *DatePicker code from: https://jqueryui.com/datepicker/
         */
        $("#checkInDate").datepicker();
        $("#checkOutDate").datepicker();

        //Current date
        var d = new Date();
        var twoDigitMonth = '0' + (d.getMonth() + 1);
        var currentDate = twoDigitMonth.slice(-2) + "/" + ('0' + d.getDay()).slice(-2) + "/" + d.getFullYear();

        //Clicking the find_room button:
        $("#find_room").click(function() {
            var checkIn = $("#checkInDate").val();
            var checkOut = $("#checkOutDate").val();

            $("#error_message").empty();
            var message = "";
            if(checkIn === "" || checkOut === "") {
                message = "<p>Please select two dates.</p>";
                $("#bookingContents").empty();
                $("#error_message").append(message);
            }else if(checkIn > checkOut){
                message = "<p>Please select a valid check in and check out date.</p>";
                $("#bookingContents").empty();
                $("#error_message").append(message);
            }else if(checkIn < currentDate){
                message = "<p>Please select a valid check in date.</p>";
                $("#bookingContents").empty();
                $("#error_message").append(message);
            }else{
                contents();
            }
        });
    }

    pub.setup = function() {
        insertPending();
        selectRoom();
    };

    // Expose public interface
    return pub;
}());

$(document).ready(BookRoom.setup);