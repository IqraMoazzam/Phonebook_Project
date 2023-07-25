<?php
session_start();
if(isset($_SESSION['admin_user_id'])){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['del'])) {
    } else if (isset($_POST['sub'])) {
        $admin_id = $_POST['a_id'];
        $conn = mysqli_connect("localhost", "root", "", "phonebook-project");
        if (!$conn) {
            echo "Error in Connection" . mysqli_connect_error();
        } else {
            $sql = "DELETE FROM admin_users where admin_user_id = {$admin_id}";
            if (mysqli_query($conn, $sql)) {
                header("location:view_admin_users.php");
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
    <title>Delete Admin Users</title>
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
        <div class="modal" tabindex="-1" id="modal_id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="h5">Are you Sure you want to delete this Admin User?</div>
                        <div class="row">
                            <div class="col-1">

                            </div>
                            <div class="col-4">
                                <div class="pb-3 pt-3 fw-bold text-center">ID</div>
                                <div class="pb-3 pt-2 fw-bold text-center">Name</div>
                                <div class="pb-3 pt-2 fw-bold text-center">Username</div>

                            </div>
                            <div class="col-2">
                                <div class="pb-3 pt-3 text-center">:</div>
                                <div class="pb-3 pt-2 text-center">:</div>
                                <div class="pb-3 pt-2 text-center">:</div>
                            </div>
                            <div class="col-3">
                                <div class="pb-3 pt-3 text-center">
                                    <?php echo $_POST['aid']; ?>
                                </div>
                                <div class="pb-3 pt-2 text-center">
                                    <?php echo $_POST['name']; ?>
                                </div>
                                <div class="pb-3 pt-2 text-center">
                                    <?php echo $_POST['username']; ?>
                                </div>
                            </div>
                            <div class="col-2">

                            </div>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <?php
                             echo "<input type='hidden' name='a_id' value='{$_POST['aid']}'>"; 
                             ?>

                            <div class="modal-footer">
                                <input type="submit" id="yes" value="Delete" name="sub" class="btn btn-primary" data-bs-dismiss="modal">
                                <button type="button" id="no" class="btn btn-danger">Close</button>
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
        document.getElementById('no').addEventListener('click', function() {

            my_modal.hide();
            window.location.replace("view_admin_users.php");
        });

        document.getElementById('yes').addEventListener('click', function() {
            window.location.replace("view_admin_users.php");
        });
    </script>
</body>

</html>