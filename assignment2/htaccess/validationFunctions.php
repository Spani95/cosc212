<?php
/**
 * Check to see if a string contains any content or not.
 * Leading and trailing whitespace are not considered to be 'content'.
 *
 * @param string $str The string to check.
 * @return True if $str is empty, false otherwise.
 */
function isEmpty($str) {
  return strlen(trim($str)) == 0;
}

/**
 * Check to see if a string is composed entirely of the digits 0-9.
 * Note that this is different to checking if a string is numeric since
 * +/- signs and decimal points are not permitted.
 *
 * @param string $str The string to check.
 * @return True if $str is composed entirely of digits, false otherwise.
 */
function isDigits($str) {
    $pattern='/^[0-9]+$/';
    return preg_match($pattern, $str);
}

function isString($str) {
    return preg_match("/^[a-zA-Z ]*$/",$str);
}

/**
 * Check to see if the string is of the correct form.
 * Acceptable formats: 100 or 100.00
 *
 * @param $str
 * @return False if $str is not of the correct format.
 */
function isCurrency($str) {
    return preg_match("/^[0-9]+(?:\.[0-9]{2}){0,1}$/", $str);
}

/**
 * Check to see if the two dates passed in as parameters
 * are valid dates.
 *
 * @param $checkin, is the requesting checkin date.
 * @param $checkout, is the requesting checkout date.
 * @return bool
 */
function validDates($checkin, $checkout) {
    $todaysDate = date('Y-m-d');
    if(!$checkin){
        return false;
    } else if ($checkin < $todaysDate) {
        return false;
    }

    if (!$checkout) {
        return false;
    } elseif ($checkout < $checkin){
        return false;
    } elseif ($checkout === $checkin) {
        return false;
    }
    return true;
}
?>