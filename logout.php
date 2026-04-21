<?php
session_start();
unset($_SESSION["user_id"]);
header( header: "Location: index.php");