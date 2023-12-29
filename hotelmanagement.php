<?php
include 'dbconnection.php';
function handleHotelForm($conn)
{
    if ($_POST['table'] === 'hotel') {
        // Process hotel form data
        $hid = $_POST['Hid'];
        $name = $_POST['Name'];
        $city = $_POST['City'];

        // Example: Inserting data into the 'hotel' table
        try{
        $stmt = $conn->prepare("INSERT INTO hotel (Hid,Name, City) VALUES (?,?, ?)");
        $stmt->bind_param("iss",$hid, $name, $city);
        $stmt->execute();

        // Handle success or failure
        if ($stmt->affected_rows > 0) {
            echo "Data inserted into hotel successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }catch (mysqli_sql_exception $e) {
            echo "Custom error message: The data insertion failed. Reason: " . $e->getMessage();
        }
         header("refresh:1;url=index.html");
            exit();
        $stmt->close();
    }
}

function handleRoomForm($conn)
{
    if ($_POST['table'] === 'room') {
        // Process room form data
         $rid = $_POST['Rid'];
        $hid = $_POST['Hid'];
        $tariff = $_POST['Tariff'];

        // Example: Inserting data into the 'room' table
        try{
        $stmt = $conn->prepare("INSERT INTO room (Rid,Hid, Tariff) VALUES (?,?, ?)");
        $stmt->bind_param("iid", $rid,$hid, $tariff);
        $stmt->execute();

        // Handle success or failure
        if ($stmt->affected_rows > 0) {
            echo "Data inserted into room successfully!";
          
        } else {
            echo "Error: " . $stmt->error;
        }
    }catch (mysqli_sql_exception $e) {
            echo "Custom error message: The data insertion failed. Reason: " . $e->getMessage();
        }
 header("refresh:1;url=index.html");
            exit();
        $stmt->close();
    }
}

function handleBookingForm($conn)
{
    
        if ($_POST['table'] === 'booking') {
        // Process booking form data
         $booking_no = $_POST['Booking_no'];
        $guestName = $_POST['Guest_name'];
        // $hid = $_POST['Hid'];
        // $rid = $_POST['Rid'];
        list($hid, $rid) = explode('-', $_POST['Hid']);
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        // Example: Inserting data into the 'booking' table
        try{
        $stmt = $conn->prepare("INSERT INTO booking (Booking_no,Guest_name, Hid, Rid, start_date, end_date) VALUES (?,?, ?, ?, ?, ?)");
        $stmt->bind_param("isiiss", $booking_no,$guestName, $hid, $rid, $startDate, $endDate);
        $stmt->execute();

        // Handle success or failure
        if ($stmt->affected_rows > 0) {
            echo "Data inserted into booking successfully!";
          
        } else {
            echo "Error: " . $stmt->error;
           
        }
    }catch (mysqli_sql_exception $e) {
            echo "Custom error message: The data insertion failed. Reason: " . $e->getMessage();
        }
 header("refresh:1;url=index.html");
            exit();
        $stmt->close();
    }
}
function handleUpdateForm($conn)
{
    if ($_POST['table'] === 'update_booking') {
        // Process update form data
        $booking_no = $_POST['Booking_no'];
        $newStartDate = $_POST['start_date'];
        $newEndDate = $_POST['end_date'];

        // Example: Updating data in the 'booking' table
        try {
            $stmt = $conn->prepare("UPDATE booking SET start_date = ?, end_date = ? WHERE Booking_no = ?");
            $stmt->bind_param("ssi", $newStartDate, $newEndDate, $booking_no);
            $stmt->execute();

            // Handle success or failure
            if ($stmt->affected_rows >= 0) {
                echo "Data updated for Booking_no: " . $booking_no . " successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
            echo "Custom error message: The data update failed. Reason: " . $e->getMessage();
        }
        echo '
            <form id="redirectForm" action="query.php" method="post" style="display: none;">
                <input type="hidden" name="query" value="query_8" />
            </form>
            <script>
                document.getElementById("redirectForm").submit();
            </script>
            ';
        $stmt->close();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['table'])) {
    $selectedTable = $_POST['table'];
    handleHotelForm($conn);
    handleRoomForm($conn);
    handleBookingForm($conn);
    handleUpdateForm($conn);
    header("refresh:1;url=index.html");
    exit();
} else {
    echo "Form submission error!";
}
?>