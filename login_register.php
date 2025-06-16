<?php 
session_start();
require_once 'config.php';

if (isset($_POST['register'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']); // tanpa hashing
    $role = $conn->real_escape_string($_POST['role']);

    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['registerer_error'] = 'Email is already registered';
        $_SESSION['active_error'] = 'register'; 
    } else {
        $insert = $conn->query("INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')");
        
        if ($insert) {
            // AUTO LOGIN SETELAH REGISTER
            $_SESSION['nama'] = $nama;
            $_SESSION['email'] = $email;

            if ($role === 'admin') {
                header("Location: admin/admin_page.php");
            } else {
                header("Location: user/user_page.php");
            }
            exit();
        } else {
            $_SESSION['registerer_error'] = 'Registration failed!';
            $_SESSION['active_error'] = 'register';
            header("Location: index.php");
            exit();
        }
    }

    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'"); 
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];

            if ($user['role'] === 'admin') {
                header("Location: admin/admin_page.php");
            } else {
                header("Location: user/user_page.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}
?>
