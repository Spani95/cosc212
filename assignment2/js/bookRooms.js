/**
 * Interim booking functions for hotel rooms.
 * These functions provide the ability to search form available rooms by date range.
 * Rooms can be 'booked' and these bookings are stored in a cookie.
 * Permanant changes to the booking list (stored in XML on the server-side) are part of Assignmnent 2.
 * These locally stored bookings are also displayed on the HTML page.
 *
 * Created by: Steven Mills, 18/08/2014
 * Last Modified by: Steven Mills 08/09/2015
 */

/*jslint browser: true, for: true, this: true */
/*global $ Cookie*/

/**
 * Module pattern for room booking functions
 */
var BookRooms = (function () {

    'use strict';

    var pub = {}; // Public interface to the module

    /**
     * Convert an XML date to a string.
     *
     * Dates in the XML files are stored as day, month, and year elements.
     * Given a DOM node refering to a date, this function produces a string representing the date.
     * Dates are formatted yyyy-mm-dd to allow easy sorting and comparison.
     *
     * @param xmlDate An XML DOM representing a date.
     * @ return The date in yyyy-mm-dd format.
     */
    function makeDateFromXML(xmlDate) {
        var dd, mm, yyyy;
        dd = $(xmlDate).find("day").text();
        if (dd < 10) {
            dd = '0' + dd;
        }
        mm = $(xmlDate).find("month").text();
        if (mm < 10) {
            mm = '0' + mm;
        }
        yyyy = $(xmlDate).find("year").text();
        return yyyy + '-' + mm + '-' + dd;
    }

    /**
     * Check if a room is available for a given date.
     *
     * This function checks a booking request against the existing bookings.
     * If the booking overlaps with an existing one, then the room is not available.
     *
     * @return true if the room is available, false otherwise
     */
    function checkAvailable(room, checkin, checkout, bookings) {
        var i;
        for (i = 0; i < bookings.length; i += 1) {
            if (bookings[i].number === room) {
                if ((bookings[i].checkin < checkout) && (bookings[i].checkout > checkin)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Extract existing bookings from XML.
     *
     * @param data XML data (DOM) representing some bookings.
     * @return The bookings as an array of JavaScript objects.
     */
    function parseBookingXML(data) {
        var bookings = [];
        $(data).find("booking").each(function () {
            var booking = {};
            booking.number = $($(this).find("number")[0]).text();
            booking.checkin = makeDateFromXML($($(this).find("checkin")[0]));
            booking.checkout = makeDateFromXML($($(this).find("checkout")[0]));
            bookings.push(booking);
        });
        return bookings;
    }

    /**
     * Extract hotel rooms from XML.
     *
     * @param data XML data (DOM) representing some hotel rooms.
     * @return The hotel rooms as an array of JavaScript objects.
     */
    function parseRoomXML(data) {
        var rooms = [];
        $(data).find("hotelRoom").each(function () {
            var room = {};
            room.number = $($(this).find("number")[0]).text();
            room.type = $($(this).find("roomType")[0]).text();
            room.price = $($(this).find("pricePerNight")[0]).text();
            rooms.push(room);
        });
        return rooms;
    }

    /**
     * Set up the room selection and booking form.
     *
     * The pending bookings are stored in a cookie.
     * This function reads that cookie and displays a list of pending bookings.
     */
    function setupBookRoom(checkin, checkout) {
        // Need to read in several XML files, so chain them together in a series
        var rooms, bookings;
        $.ajax({
            type: "GET",
            url: "xml/hotelRooms.xml",
            cache: false,
            success: function (data) {
                rooms = parseRoomXML(data);
            }
        }).done(function () {
            $.ajax({
                type: "GET",
                url: "xml/roomBookings.xml",
                cache: false,
                success: function (data) {
                    bookings = parseBookingXML(data);
                }
            }).done(function () {
                rooms.forEach(function (room) {
                    if (checkAvailable(room.number, checkin, checkout, bookings)) {
                        $("#roomSelection").append($("<option>").attr("value", room.number).text(room.number + ': ' + room.price));
                    }
                });
                $("#bookRoomForm").show();
            });
        });
    }

    /**
     * Extract date information from form elements.
     *
     * Date selection is difficult over different browsers.
     * The 'date' input element is not widely supported, so here we use simple drop-down selects.
     *
     * * This should validate to exclude dates like 31/2/2015.
     * * Better - the available options should be dynamic.
     *
     * @param dayElementID ID of the HTML input element for the day of the month.
     * @param dayElementID ID of the HTML input element for the month.
     * @param dayElementID ID of the HTML input element for the year.
     * @return The date in yyyy-mm-dd format
     */
    function getDateFromForm(dayElementID, monthElementID, yearElementID) {
        var dd, mm, yyyy;
        dd = $(dayElementID).val();
        mm = $(monthElementID).val();
        yyyy = $(yearElementID).val();
        return yyyy + "-" + mm + "-" + dd;
    }

    function getTodaysDate() {
        var today, dd, mm, yyyy;
        today = new Date();
        dd = today.getDate();
        mm = today.getMonth() + 1; // +1 because in JavaScript Jan = 0, Feb = 1, etc.
        yyyy = today.getFullYear();

        // Pad out day and month with zeroes if needed.
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        return yyyy + '-' + mm + '-' + dd;
    }

    /**
     * Callback for submitting the 'Find room' form.
     *
     * The first stage of booking is to enter checkin and checkout dates.
     * This function checks that those dates make sense (not in the past, checkout after checkin).
     * If that's OK, it then sets up the booking form.
     *
     * @return false, to disable page refresh on form submission.
     */
    function submitFindRoom() {
        var isValid, checkin, checkout;
        isValid = true;

        // Validate checkin date
        checkin = getDateFromForm("#checkinday", "#checkinmonth", "#checkinyear");
        if (!checkin) {
            $("#checkinError").text("You must enter a check in date.");
            isValid = false;
        } else if (checkin < getTodaysDate()) {
            $("#checkinError").text("You can't book in the past.");
            isValid = false;
        } else {
            $("#checkinError").text("");
        }

        // Validate checkout date
        checkout = getDateFromForm("#checkoutday", "#checkoutmonth", "#checkoutyear");
        if (!checkout) {
            $("#checkoutError").text("You must enter a check out date.");
            isValid = false;
        } else if (checkout < checkin) {
            $("#checkoutError").text("You can't check out before you check in.");
            isValid = false;
        } else if (checkout === checkin) {
            $("#checkoutError").text("You must stay at least one night.");
            isValid = false;
        } else {
            $("#checkoutError").text("");
        }

        // If OK, set up the booking form
        if (isValid) {
            $("#checkinDate").val(checkin);
            $("#checkoutDate").val(checkout);
            $("#findRoomForm :input").prop("disabled", true);
            $("#searchingForRooms").show();
            setupBookRoom(checkin, checkout);
        }

        return false;
    }

    /**
     * Callback for submitting the 'Book room' form.
     *
     * The second stage of the booking is for the guest to enter their name and choose a room.
     * Once this is done, the new (pending) booking is saved in a cookie.
     *
     * @return true if the booking was successful, false otherwise.
     */
    function submitBookRoom() {
        var newBooking = {},
            localBookings = [];
        newBooking.number = $("#roomSelection").val();
        newBooking.checkin = $("#checkinDate").val();
        newBooking.checkout = $("#checkoutDate").val();
        newBooking.name = $.trim($("#bookingName").val());
        if (!newBooking.name) {
            $("#nameError").text("You must enter a booking name");
            return false;
        } else {
            $("#nameError").text("");
            localBookings = loadLocalBookings();
            localBookings.push(newBooking);
            saveLocalBookings(localBookings);
            $("bookRoomForm").hide();
            return true;
        }
    }

    /**
     * Setup function for room booking page.
     *
     * There are three stages to the booking, so this first ensures that only the first is shown.
     * This should be handled by CSS, but there's no harm in making sure.
     * Next it attaches callbacks to the two form submission events.
     */
    pub.setup = function () {
        $("#bookRoomForm").hide();
        $("#findRoomForm").submit(submitFindRoom);
        $("#bookRoomForm").submit(submitBookRoom);
    };

    // Expose public interface
    return pub;
}());

// On page load, setup the BookRooms functions
$(document).ready(BookRooms.setup);