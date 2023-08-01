<?php
include "db_config.php"; // Assuming this file contains the database connection details.

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $sql_query= "DELETE FROM students WHERE id=?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    if ($result === TRUE) {
        echo "Record deleted successfully.";
    } else {
        echo "Error: " . $sql_query . "<br>" . $conn->error;
    }

    $stmt->close();
}
?>
