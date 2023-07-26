<?php 
$conn = mysqli_connect("localhost","root","","phonebook-project");
if(!$conn){
    echo "Error in Connection" . mysqli_connect_error();
}else{

    $sql = "UPDATE user_profile set is_verified=1 where verification_code = '{$_GET['v_code']}'";

    if(mysqli_query($conn,$sql)){
        echo "<h4>" . "Email is Verified." . "</h4>";
    

    }else{
        echo "<h4>" . "Email is not Verified." . "</h4>";
        echo "Error" . $sql . mysqli_error($conn);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['login'])){
        header("location:login.php");
    }
}

?>
<!doctype html>
<html lang="en">

<head>
  <title>Email Verify</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
  <main>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<input type="submit" value="Login" class="btn btn-primary ms-2" name="login">
    </form>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>