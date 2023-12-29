<?php 
include "dbconnection.php";
function execute($query, $conn)
{
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query execution failed: " . mysqli_error($conn));
    }

    return $result;
}


$update = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $queryType = $_POST['query'] ?? '';

    switch ($queryType) {

        case 'query_1':
            $query = "SELECT * FROM hotel";
            $result = execute($query, $conn);
            break;
        case 'query_2':
            $query = "SELECT * FROM room";
            $result = execute($query, $conn);
            break;
        case 'query_3':
            $query = "SELECT * FROM booking";
            $result = execute($query, $conn);
            break;

        case 'query_4':
            $query = "SELECT Name as Hotel_name, G.Guest_name, count(*) as Number_of_stays from 
            BOOKING inner join HOTEL on BOOKING.Hid = HOTEL.Hid inner join (select Guest_name, Hid from BOOKING group by Guest_name, Hid having count(*) >= 3) as G on BOOKING.Guest_name = G.Guest_name and BOOKING.Hid = G.Hid group by Hotel_name, G.Guest_name";
            $result = execute($query, $conn);
            break;
        case 'query_5':
            $query = "SELECT Name, Rid, tariff from ROOM 
            inner join HOTEL on ROOM.Hid = HOTEL.Hid where tariff = (select max(tariff) from ROOM where ROOM.Hid = HOTEL.Hid)";
            $result = execute($query, $conn);
            break;

        case 'query_6':
            $query = "SELECT Name, sum(tariff) as Total_Earnings from HOTEL 
            inner join ROOM on HOTEL.Hid = ROOM.Hid inner join BOOKING on ROOM.Rid = BOOKING.Rid where city = 'kolkata' and start_date >= date_sub(curdate(), interval 30 day) group by Name";
            $result = execute($query, $conn);
            break;

        case 'query_8':
           
            $query = "SELECT * FROM booking";
            $result = execute($query, $conn);
            $update = true;
             echo'<body>';
        echo'<div class="container mt-1">';
        echo '<h3 class="mt-2">Hotel Management Queries</h3>';
    if ($result && mysqli_num_rows($result) > 0) {
        echo '<button id="go-back" onclick="window.location.href = \'output.html\'">Go Back</button>';
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        foreach (mysqli_fetch_fields($result) as $field) {
            echo '<th scope="col">' . $field->name . '</th>';
        }
        echo '<th scope="col">Actions</th>'; 
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            foreach ($row as $key => $value) {
                echo '<td>' . $value . '</td>';
            }
            
            echo '<td>';
            echo '<form action="hotelmanagement.php" method="post">';
            echo '<input type="hidden" name="table" value="update_booking" />';
            echo '<input type="hidden" name="Booking_no" value="' . $row['Booking_no'] . '" />';

           
            echo '<input type="date" name="start_date" value="' . $row['start_date'] . '" required>';
            echo '&nbsp;&nbsp;&nbsp;';
            echo '<input type="date" name="end_date" value="' . $row['end_date'] . '" required>';
            echo '&nbsp;&nbsp;&nbsp;';
            echo '<button type="submit" class="btn btn-primary">Update</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
         echo'</body>';
        echo'</div>';
    } else {
        echo '<p>No results found.</p>';
    }
        break;

        case 'query_9':
            $query = "DELETE from BOOKING where start_date < date_sub(curdate(), interval 6 month)";
            $result = execute($query, $conn);
            $query = "SELECT * FROM BOOKING";
            $result = execute($query, $conn);
            break;
        default:
            echo "Invalid query selected.";
            exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hotel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container mt-1">
        <?php
        if (isset($result) && !$update) {
            echo  '<h1 class="mb-4">Hotel Management System Qeuries</h1>';
            echo '<button id="go-back" onclick="window.location.href = \'output.html\'">Go Back</button>';
            if (mysqli_num_rows($result) > 0) {
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                
                foreach (mysqli_fetch_fields($result) as $field) {
                    echo '<th scope="col">' . $field->name . '</th>';
                }
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    
                    foreach ($row as $value) {
                        echo '<td>' . $value . '</td>';
                    }
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No results found.</p>';
            }
        }
        ?>
    </div>



</body>

</html>