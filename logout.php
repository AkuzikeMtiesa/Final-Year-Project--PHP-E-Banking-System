<?php
include('_config.php');

if (isset($_SESSION['user'])) {
    session_destroy();
    header('Location: login.php');
} else {
    header('Location: login.php');
}
