<?php
session_start();
include('../config.php');

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

/* =========================
   GET COURT INFO FIRST
========================= */

$get = mysqli_query($conn,"
SELECT * FROM venue_courts WHERE id='$id'
");

$court = mysqli_fetch_assoc($get);

if(!$court){
    die("Court not found");
}

$venue_id = $court['venue_id'];
$court_no = $court['court_no'];


/* =========================
   DELETE COURT
========================= */

mysqli_query($conn,"
DELETE FROM venue_courts WHERE id='$id'
");

/* =========================
   REDIRECT
========================= */

header("Location: manage_court.php");
exit();
?>