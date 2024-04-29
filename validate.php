<?php
include('_config.php');

$token = $_POST['token'] ?? '';
$email = $_POST['email'] ?? '';
$tid = $_POST['tid'] ?? '';

if ($token != '' && $email != '' && $tid != '') {
    $token = mysqli_real_escape_string($conn, $token);
    $email = mysqli_real_escape_string($conn, $email);
    $tid = mysqli_real_escape_string($conn, $tid);

    $qry = "SELECT * FROM tokens WHERE id = '$tid' AND token = '$token'";

    $result = mysqli_query($conn, $qry);

    if (mysqli_num_rows($result) == 1) {
        $tokenRow = mysqli_fetch_assoc($result);

        $user_id = $tokenRow['user_id'];

        $qry = "SELECT * FROM users WHERE id = '$user_id' AND email = '$email'";

        $result = mysqli_query($conn, $qry);

        if (mysqli_num_rows($result) == 1) {
            $qry = "UPDATE tokens SET status = 2 WHERE id = '$tid'";
            mysqli_query($conn, $qry);

            echo json_encode(['status' => 'success', 'message' => 'Token approved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
}
