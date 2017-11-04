/**
 * Created by: Nick Sparrow, 19-Aug-15.
 * Last Modified by: Nick Sparrow, 21/08/2015
 */

var adminJs = (function(){
    "use strict";

    var pub;

    pub = {};

    function showBooked(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET","roomBookings.xml",false);
        xmlhttp.send();
        var xmlDoc = xmlhttp.responseXML;
        var bookedRooms = xmlDoc.getElementsByTagName("booking");
        var i;
        var bookedList = [];
        var bookedName, bookedRoomNum, dayCheckIn, monthCheckIn, yearCheckIn, dayCheckOut, monthCheckOut, yearCheckOut;
        for(i = 0; i < bookedRooms.length; i += 1){
            bookedName = bookedRooms[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;
            bookedRoomNum = bookedRooms[i].getElementsByTagName("number")[0].childNodes[0].nodeValue;
            dayCheckIn = bookedRooms[i].getElementsByTagName("day")[0].childNodes[0].nodeValue;
            monthCheckIn = bookedRooms[i].getElementsByTagName("month")[0].childNodes[0].nodeValue;
            yearCheckIn = bookedRooms[i].getElementsByTagName("year")[0].childNodes[0].nodeValue;
            dayCheckOut = bookedRooms[i].getElementsByTagName("day")[1].childNodes[0].nodeValue;
            monthCheckOut = bookedRooms[i].getElementsByTagName("month")[1].childNodes[0].nodeValue;
            yearCheckOut = bookedRooms[i].getElementsByTagName("year")[1].childNodes[0].nodeValue;
            bookedList[i] = {name: bookedName, room: bookedRoomNum, checkInDate: '0' + monthCheckIn.slice(-2) + '/' + dayCheckIn + '/' + yearCheckIn, checkOutDate: '0' + monthCheckOut.slice(-2) + '/' + dayCheckOut + '/' + yearCheckOut};
        }
        var content = "";
        for(i = 0; i < bookedList.length; i += 1){
            content += "<li><strong>" + bookedList[i].name + "</strong> - Room: " + bookedList[i].room + ", From: " + bookedList[i].checkInDate + ", To: " + bookedList[i].checkOutDate + "</li>";
        }
        $("#bookings").append(content);
    }

    pub.setup = function() {
        showBooked();
    };

    // Expose public interface
    return pub;
}());

$(document).ready(adminJs.setup);
