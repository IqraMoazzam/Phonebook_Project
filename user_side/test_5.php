<?php 
$conn = mysqli_connect("localhost","root","","phonebook-project");
if(!$conn){
    echo "Error in Connection" . mysqli_connect_error();
}else{

    $sql = "UPDATE email_verification set is_verified=1 where verification_code = '{$_GET['v_code']}'";
    

    if(mysqli_query($conn,$sql)){
        echo "Email is Verified.";
        // header("location:login.php");

    }else{
        echo "Email is not Verified.";
        echo "Error" . $sql . mysqli_error($conn);
    }
}

?>