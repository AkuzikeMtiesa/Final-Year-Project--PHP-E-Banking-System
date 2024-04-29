<?php

define('WEB_ROOT', 'http://localhost/pph-e-banking-system/pph-e-banking-system/');

session_start();

$conn = mysqli_connect("localhost", "root", "", "e-banking-system");

$currentPage = basename($_SERVER['SCRIPT_NAME'], '.php');

$guestPages = ['login', 'register', 'success', 'scan', 'validate'];

if (isset($_SESSION['user']) && in_array($currentPage, $guestPages)) {
    header('Location: index.php');
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    if ($_SESSION['mfa'] == 'pending' && $currentPage != 'logout') {
        if (!isset($_SESSION['mfa_mode']) && $currentPage != 'mfa') {
            header('Location: mfa.php');
        } else if (isset($_SESSION['mfa_mode']) && $_SESSION['mfa_mode'] == 'otp' && isset($_SESSION['opt']) && $currentPage != 'mfa-otp') {
            header('Location: mfa-otp.php');
        } else if (isset($_SESSION['mfa_mode']) && $_SESSION['mfa_mode'] == 'qr' && isset($_SESSION['token'])  && !in_array($currentPage, ['mfa-qr', 'check'])) {
            header('Location: mfa-qr.php');
        } else if (isset($_SESSION['mfa_mode']) && isset($_SESSION['mfa_mode']) && !isset($_SESSION['token']) && !isset($_SESSION['otp'])) {
            unset($_SESSION['mfa_mode']);
            if ($currentPage != 'mfa')
                header('Location: mfa.php');
        }
    }

    $sql = "SELECT * FROM users WHERE id = '$user'";

    $result = mysqli_query($conn, $sql);

    $user = mysqli_fetch_assoc($result);
} else {
    if (!in_array($currentPage, $guestPages)) {
        header('Location: login.php');
    }
}
