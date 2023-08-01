
<?php
 include "db_config.php";

$fname=$_POST['fname']??'';
$lname=$_POST['lname']??'';
$email=$_POST['email']??'';
$message=$_POST['message']??'';

if(!empty($fname) || !empty($lname) || !empty($email) || !empty($message)){

if($conn->connect_error)
{
    die("connection failed:". $conn->connect_error);

}
else{
    $SELECT="SELECT email FROM students WHERE email=? LIMIT 1";
    $INSERT="INSERT INTO students (fname,lname,email,message) VALUES (?,?,?,?)";
    $sql_query="SELECT id,fname,lname,email,message from students";
    $result=$conn->query($sql_query);

    if ($result->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Message</th><th>Update</th><th>Delete</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["fname"] . "</td><td>" . $row["lname"] . "</td><td>". $row["email"] . "</td><td>" . $row["message"] . "</td>
            <td><a href='update_page_1.php?id=".$row['id']."'class='btn btn-success'>Update</a></td>
            <td><a href='delete_page.php?id=".$row['id']."' class='btn btn-danger'>Delete</a></td>
            </tr>";
        }

        echo '</table>';
    } else {
        echo "No records found.";
    }

    
    
    $stmt=$conn->prepare($SELECT);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->store_result();
    $rnum=$stmt->num_rows;

    if($rnum==0){
        $stmt->close();
        $stmt=$conn->prepare($INSERT);
        $stmt->bind_param("ssss",$fname,$lname,$email,$message);
        $stmt->execute();
        echo "";
    }else{
        echo "";
    }
    $stmt->close();
    $conn->close();
} 

}
?>
