<?php
include('_config.php');

include('_smtp.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $mfa_mode = $_POST['mfa'];

        if ($mfa_mode != 'otp' && $mfa_mode != 'qr') {
            throw new Exception('Please select a valid MFA method');
        }

        $_SESSION['mfa_mode'] = $mfa_mode;

        if ($mfa_mode == 'otp') {

            $otp = random_int(100000, 999999);

            $_SESSION['otp'] = $otp;

            $email  = $user['email'];

            $name = $user['name'];

            $message = "Your OTP is $otp";

            if (sendMail($email, $name, 'OTP Verification', $message)) {
                $_SESSION['success'] = 'OTP has been sent to your email';
                header('Location: mfa-otp.php');
            } else {
                throw new Exception('Something went wrong, please try again later');
            }
        } else if ($mfa_mode == 'qr') {

            $token = md5(random_int(100000, 999999));

            $user_id = $user['id'];

            $email  = $user['email'];

            $name = $user['name'];

            $qry = "INSERT INTO `tokens` (`token`, `user_id`) VALUES ('$token', '$user_id')";

            if ($conn->query($qry) === false) {
                throw new Exception('Something went wrong, please try again later');
            }

            $token_id = $conn->insert_id;

            $message = "Click here to verify your account: <a href='" . WEB_ROOT . "scan.php?token=$token'>Click Here</a>";

            if (sendMail($email, $name, 'Verify your account', $message)) {
                $_SESSION['token'] = $token_id;
                $_SESSION['success'] = 'A verification link has been sent to your email';
                header('Location: mfa-qr.php');
            } else {
                throw new Exception('Something went wrong, please try again later');
            }
        }
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
            <form action="mfa.php" method="post">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-circle mb-2" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>
                <h1 class="h3 mb-3 fw-normal">Please Choose a way to Verify</h1>
                <div class="form-check mt-2" style="text-align:left">
                    <input class="form-check-input" type="radio" name="mfa" value="otp" id="flexRadioDefault1" required>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Using OTP
                    </label>
                </div>
                <div class="form-check" style="text-align:left">
                    <input class="form-check-input" type="radio" name="mfa" value="qr" id="flexRadioDefault2" required>
                    <label class="form-check-label" for="flexRadioDefault2">
                        Using QR Code
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Continue</button>
                <p class="mt-5 mb-3 text-body-secondary">© Banking E-Authentication 2022–2023</p>
            </form>
        </div>
    </div>
</div>
<?php include('_footer.php'); ?>