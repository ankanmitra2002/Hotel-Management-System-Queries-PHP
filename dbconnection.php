<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelmanagementsystem";
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("conn failed: " . $conn->connect_error);
}
$conn->select_db($dbname);
$createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS $dbname";
function createTablesIfNotExist($conn)
{
  
$hotel = "CREATE TABLE  IF NOT EXISTS HOTEL (
    Hid INT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    City VARCHAR(255) NOT NULL
)";


$room = "CREATE TABLE  IF NOT EXISTS ROOM (
    Rid INT PRIMARY KEY,
    Hid INT,
    Tariff DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (Hid) REFERENCES HOTEL(Hid)
)";


$booking = "CREATE TABLE  IF NOT EXISTS BOOKING (
    Booking_no INT PRIMARY KEY,
    Guest_name VARCHAR(255) NOT NULL,
    Hid INT,
    Rid INT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    FOREIGN KEY (Hid) REFERENCES HOTEL(Hid),
    FOREIGN KEY (Rid) REFERENCES ROOM(Rid)
)";

    mysqli_query($conn, $hotel);
    mysqli_query($conn, $room);
    mysqli_query($conn, $booking);
}
createTablesIfNotExist($conn);

?>


