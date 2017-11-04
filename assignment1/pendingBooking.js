/**
 * Created by Nick on 15-Aug-15.
 */

var PendingBooking = (function () {
    "use strict";

    var pub;

    // Public interface
    pub = {};

    /**
     * Add items to the cart
     *
     * This function is called when a 'Buy' button is clicked.
     * The cart itself is stored in a cookie, which is updated each time this function is called.
     */
    function addToPending() {
        alert("?");
        var itemList, newItem;
        var name = $("#booking_name").val();
        var checkIn = $("#checkInDate").val();
        var checkOut = $("#checkOutDate").val();

        itemList = Cookie.get("pendingBooking");
        if (itemList) {
            itemList = JSON.parse(itemList);
        } else {
            itemList = [];
        }
        newItem = {};
        newItem.name = name;
        newItem.checkIn = checkIn;
        newItem.checkOut = checkOut;
        itemList.push(newItem);
        Cookie.set("pendingBooking", JSON.stringify(itemList));
    }

    /**
     * Setup function for the cart functions
     *
     * Gets a list of 'Buy' buttons, and sets them to call addToCart when clicked
     */
    pub.setup = function () {
        $("#book").click(addToPending);
    };

    // Expose public interface
    return pub;
}());

$(document).ready(PendingBooking.setup);