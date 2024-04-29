<?php
include('_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($name == '' || $email == '' || $password == '') {
            throw new Exception('Please fill in all fields');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new Exception('Please enter a valid email address');
        }

        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $password = md5($password);

        $sql = "SELECT * FROM users WHERE email = '$email'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            throw new Exception('Email already exists');
        }

        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['success'] = 'You have successfully registered';
            header('Location: login.php');
        } else {
            throw new Exception('Something went wrong');
        }
    } catch (\Throwable $th) {
        if ($th->getCode() == 0)
            $_SESSION['error'] = $th->getMessage();
    }
}
?>
<?php include('_header.php'); ?>
<div class="container pt-5">
    <div class="row">
        <div class="col-12 form-auth d-flex justify-content-center text-center">
            <form action="register.php" method="post">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-circle mb-2" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>
                <h1 class="h3 mb-3 fw-normal">Register here</h1>
                <div class="form-floating">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Gary watt">
                    <label for="name">Name</label>
                </div>
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary mt-3">Register</button>
                <p class="mt-5 mb-3 text-body-secondary">© 2022–2023</p>
            </form>
        </div>
    </div>
</div>
<?php include('_footer.php'); ?>