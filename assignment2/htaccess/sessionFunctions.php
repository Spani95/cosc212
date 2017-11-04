<?php
session_start();
/**
 * starts a new session with the value of the $_POST.
 * @param $valueName
 */
function setSession($valueName) {
  	$_SESSION[$valueName] = $_POST[$valueName];
}

/**
 * deletes a session with the name of the param.
 * @param $valueName
 */
function unsetSession($valueName) {
	unset($_SESSION[$valueName]);
}

?>