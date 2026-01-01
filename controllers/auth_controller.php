<?php
session_start();
require_once __DIR__ . '../../models/UserModel.php';

class AuthController {

    public function login() {
        $error = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_btn'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);

            if ($user && $password == $user['password']) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                if ($user['role'] == 'recruiter') {
                    header("Location: views/recruiter/dashboard.php");
                } else {
                    header("Location: views/candidate/dashboard.php");
                }
                exit;

            } else {
                $error = "Invalid login credentials";
                //require __DIR__ . '/../login.php';
            }
        } 
        return $error;
    }

    public function register() {
        $error = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_btn'])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $company_name = $_POST['company_name'];
            $github_username = $_POST['github_username'];
            $password = $_POST['password'];
            $confirm = $_POST['cpassword'];

            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);
            if ($user) {
                return "Email already registered";
            }
            if ($role === 'recruiter' && empty($company_name)) {
                return "Company name is required for recruiters";
            }

            if ($password !== $confirm) {
                return "Passwords do not match";

            }

            $result = $userModel->registerUser($name, $email, $password, $role, $company_name, $github_username);

            if ($result) {
                header("Location: index.php"); 
            } else {
                $error = "Registration failed. Try again";
            }

        } 
        return $error;
    }
}
