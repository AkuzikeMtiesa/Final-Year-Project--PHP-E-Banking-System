<?php
include('_config.php');

$mfaMode = $_SESSION['mfa_mode'] ?? '';

if ($mfaMode == 'qr' && isset($_SESSION['token'])) {
    $qry = "SELECT * FROM tokens WHERE id = '{$_SESSION['token']}'";

    $result = mysqli_query($conn, $qry);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if ($row['status'] == 2) {
            $_SESSION['mfa'] = 'approved';
            unset($_SESSION['mfa_mode']);
            unset($_SESSION['token']);
            echo json_encode(['status' => 'success', 'message' => 'Token approved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Token not approved']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
    }
} else {
    echo  json_encode(['status' => 'error', 'message' => 'Invalid token']);
}
