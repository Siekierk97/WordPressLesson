<?php

$connect = mysqli_connect('mysql.db.mdbgo.com', 'siekierk97_cmdbs', 'Blarg/Wort/2', 'siekierk97_cmdsb');

if(mysqli_connect_errno()){
  exit('Failed to connect to MySQL:  ' . mysqli_connect_error());
}
