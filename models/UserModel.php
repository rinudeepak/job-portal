<?php
require_once __DIR__ . '/db_connection/db.php';

class UserModel {
    public function getUserByEmail($email) {
        global $conn;

        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }

    public function registerUser($name, $email, $password, $role, $company_name, $github_username) {
        global $conn;
        $sql = "INSERT INTO users (name, email, password, role, company_name, github_username)
                VALUES ('$name', '$email', '$password', '$role', '$company_name', '$github_username')";
        return mysqli_query($conn, $sql);
    }
}
