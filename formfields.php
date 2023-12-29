<?php
include 'dbconnection.php';
if ($_GET['table']) {
    $selectedTable = $_GET['table'];
    $query = "DESCRIBE $selectedTable";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="form-group">';
            // echo '<label for="' . $row['Field'] . '">' . ucfirst($row['Field']) . ':</label>';
if ($selectedTable === 'booking' && $row['Field'] === 'Hid') {
                echo '<label for="' . $row['Field'] . '">Select Hid and Rid Pair</label>';
                 $labelDisplayed = true;
            } elseif($selectedTable === 'booking' && $row['Field'] === 'Rid'){
                continue;
            }
            else {
                echo '<label for="' . $row['Field'] . '">' . ucfirst($row['Field']) . ':</label>';
            }
            if ($row['Field'] === 'Hid' && $selectedTable === 'room') {
              
                echo '<select class="form-control" id="Hid" name="Hid" required>';
                
                $hidQuery = "SELECT Hid FROM hotel"; 
                $hidResult = $conn->query($hidQuery);

                if ($hidResult->num_rows > 0) {
                    while ($hidRow = $hidResult->fetch_assoc()) {
                         echo '<option value="' . $hidRow['Hid'] . '">' . $hidRow['Hid'] . '</option>';
                    }
                }
                echo '</select>';
            } elseif (($row['Field'] === 'Hid' || $row['Field'] === 'Rid') && $selectedTable === 'booking') {
                
                echo '<select class="form-control" id="' . $row['Field'] . '" name="' . $row['Field'] . '" required>';
                
                $idQuery = "SELECT Hid, Rid FROM room"; 
                $idResult = $conn->query($idQuery);

                if ($idResult->num_rows > 0) {
                    while ($idRow = $idResult->fetch_assoc()) {
                        echo '<option value="' . $idRow['Hid'] . '-' . $idRow['Rid'] . '">HID: ' . $idRow['Hid'] . ', RID: ' . $idRow['Rid'] . '</option>';
                    }
                }
                echo '</select>';
            }
                elseif (strpos($row['Type'], 'int') !== false || strpos($row['Type'], 'float') !== false) {
                echo '<input type="number" class="form-control" id="' . $row['Field'] . '" name="' . $row['Field'] . '" required>';
            } elseif (strpos($row['Type'], 'date') !== false) {
                echo '<input type="date" class="form-control" id="' . $row['Field'] . '" name="' . $row['Field'] . '" required>';
            } else {
                echo '<input type="text" class="form-control" id="' . $row['Field'] . '" name="' . $row['Field'] . '" required>';
            }
            echo '</div>';
        }
    } else {
        echo "No fields found for the selected table.";
    }
} else {
    echo "Please select a table.";
}

?>
