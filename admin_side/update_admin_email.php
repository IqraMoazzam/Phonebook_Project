<?php
session_start();
if(isset($_SESSION['admin_user_id'])){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit_email'])) {
    }else if (isset($_POST['sub'])){
        $a_id = $_POST['aid'];
        $new_email = $_POST['new_email'];
        $old_email = $_POST['old_email'];
        $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
        if (!$conn) {
            echo "Error in Connection" . mysqli_connect_error();
        } else {
            $sql = "UPDATE admin_users set admin_user_email = '{$new_email}' where admin_user_id = {$a_id}";
            if(mysqli_query($conn,$sql)){
                header("location:admin_profile.php");
            }else{
                echo "Error" . $sql . mysqli_error($conn);
            }
    }

}
}
}else{
    header("location:admin_login.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Update Admin Email</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <div class="modal mt-5 h-100" tabindex="-1" id="modal_id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Admin Email</h5>
                    </div>
                    
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="modal-body">
                                <div>
                                    <label for="old_email" class="form-label mb-2">Old Admin Email:</label>
                                    <input type="text" name="old_email" id="old_email" class="form-control" value="<?php echo $_POST['email']; ?>" readonly>
                                </div>
                                <div>
                                    <label for="new_email" class="form-label mb-2">New Admin Email:</label>
                                    <input type="text" name="new_email" id="new_email" class="form-control" placeholder="Enter New Admin Email">
                                </div>
                               <input type="hidden" name="aid" value="<?php echo $_POST['admin_id'];?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" value="Update" id="change" name="sub" class="btn btn-primary">
                            </div>
                        </form>
                
                </div>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <script>
        let my_modal = new bootstrap.Modal(document.getElementById('modal_id'));
        my_modal.show();

        document.getElementById('change').addEventListener('click', function() {
            my_modal.hide();
            window.location.replace("admin_profile.php");
        });

        document.getElementById('close').addEventListener('click', function() {
            window.location.replace("admin_profile.php");
            // alert('testing');
        });
    </script>
</body>

</html>