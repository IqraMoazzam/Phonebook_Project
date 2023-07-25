<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "phonebook-project");
if (!$conn) {
    echo "Error in Connection" . mysqli_connect_error();
} else { 
if(isset($_GET['email']) && isset($_GET['v_code']))
$sql = "SELECT * user_profilen where email = '{$_GET['email']}' and verification_code = '{$_get['v_code']}'";
$result = mysqli_query($conn,$sql);
$data = mysqli_num_rows($result);
if($data > 0){
    $row = mysqli_fetch_assoc($result);
    if(isset($row['is_verified']) == 0){
        $query= "UPDATE user_profile set is_verified = 1 where email = '{$row['email']}'";

    }else{
        echo "Email Alreay Registered.";
    }
}
}

?>