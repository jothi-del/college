<?php
include "db_config.php"; // Include the database connection code

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql_query = 'UPDATE students SET fname=?, lname=?, email=?, message=? WHERE id=?';
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("ssssi", $fname, $lname, $email, $message, $id);
    $result = $stmt->execute();

    if ($result === TRUE) {
        echo "Record updated successfully.";
    } else {
        echo "Error: " . $sql_query . "<br>" . $conn->error;
    }

    $stmt->close();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_query = "SELECT id, fname, lname, email, message from students WHERE id=?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $email = $row['email'];
            $message = $row['message'];
        }
    } else {
        echo "No Record found with the given ID";
    }
    $stmt->close();
}
?>

<?php
if (isset($_POST['update_students'])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $query = "UPDATE students SET fname=?, lname=?, email=?, message=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $fname, $lname, $email, $message, $id);
    $result = $stmt->execute();

    if ($result === TRUE) {
        echo "Record updated successfully.";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $stmt->close();

    // Show the updated record after the update
    $sql_query = "SELECT id, fname, lname, email, message from students WHERE id=?";
    $INSERT="INSERT INTO students (fname,lname,email,message) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Message</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["fname"] . "</td><td>" . $row["lname"] . "</td><td>" . $row["email"] . "</td><td>" . $row["message"] . "</td></tr>";
        }

        echo '</table>';
    } else {
        echo "No records found.";
    }

    $stmt->close();
}
?>
<html>
<body>
    <h2>Students Update Form</h2>
    <form method="POST" >
        <fieldset>
            <legend>Students Information:</legend>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" placeholder="First Name" name="fname" value="<?php echo $fname; ?>" required><br>
            <input type="text" placeholder="Last Name" name="lname" value="<?php echo $lname; ?>" required><br>
            <input type="text" placeholder="Email" name="email" value="<?php echo $email; ?>" required><br>
            <textarea rows="10" placeholder="Your Message" name="message" required><?php echo $message; ?></textarea><br>
            <input type="submit" class="btn" value="Update" name="update_students">
        </fieldset>
    </form>
</body>
</html>
