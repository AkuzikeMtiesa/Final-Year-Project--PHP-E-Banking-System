<?php
include('_config.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // $otp = $_POST['otp'];

        // if ($otp == '')
        //     throw new Exception('Please enter OTP');

        // if ($otp != $_SESSION['otp'])
        //     throw new Exception('Invalid OTP');

        // $_SESSION['mfa'] = 'success';

        // unset($_SESSION['mfa_mode']);
        // unset($_SESSION['otp']);

        // header('Location: index.php');
    } catch (\Throwable $th) {
        if ($th->getCode() == 0)
            $_SESSION['error'] = $th->getMessage();
    }
}
?>
<?php include('_header.php'); ?>
<div class="container pt-3">
    <div class="row">
        <div class="col-12 form-auth d-flex justify-content-center text-center">
            <form action="mfa-otp.php" method="post">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-circle mb-2" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>
                <h1 class="h3 mb-3 fw-normal">Login Approved </h1>
                <p class="mt-5 mb-3 text-body-secondary">© Banking E-Authentication System 2022–2023</p>
            </form>
        </div>
    </div>
</div>
<?php include('_footer.php'); ?>