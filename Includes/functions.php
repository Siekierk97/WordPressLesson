<?php
function secure() { 
    if (!isset($_SESSION['id'])) {
    set_message("Please login first to view this page");
    header('location: /cms');
    die();
    }

}


//Stores the Message inside Session
function set_message($message) {
  {
    $_SESSION['message'] = $message;
  }
}

//Returns the message to user when function is called.

function get_message() {
  if (isset($_SESSION['message'])) {
      echo '<p>' . $_SESSION['message'] . '</p> <hr>';
      unset($_SESSION['message']);
  }
}


