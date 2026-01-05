<?php


require_once 'controllers/auth_controller.php';

$controller = new AuthController();
$error =$controller->register();
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <link href="assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="Name" name="name" type="text" placeholder="Enter your name" required/>
                                                        <label for="inputFirstName">Name</label>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputLastName" name="lname" type="text" placeholder="Enter your last name" required/>
                                                        <label for="inputLastName">Last name</label>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" required/>
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select class="form-control" name="role" id="role" onchange="toggleCompany()"required>
                                                    <option value="">Select Role</option>
                                                    <option value="candidate">Candidate</option>
                                                    <option value="recruiter">Recruiter</option>
                                                </select>
                                                <label>Role</label>
                                            </div>

                                            <!-- Company Name (Recruiter only) -->
                                            <div class="form-floating mb-3" id="companyDiv" style="display:none;">
                                                <input class="form-control" name="company_name" type="text" placeholder="Company Name" />
                                                <label>Company Name</label>
                                            </div>

                                            <!-- Github Username (Candidate only) -->
                                            <div class="form-floating mb-3" id="githubDiv" style="display:none;">
                                                <input class="form-control" name="github_username" type="text" placeholder="Github Username" />
                                                <label>Github Username</label>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Create a password" required/>
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" type="password" name="cpassword" placeholder="Confirm password" required/>
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" name="register_btn">Create Account</button></div>
                                            </div>
                                            <?php if (!empty($error) && $error !== "success") { ?>
                                                <div class="alert alert-danger mt-2">
                                                    <?= $error ?>
                                                </div>
                                            <?php } ?>

                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="index.php">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="assets/js/scripts.js"></script>
        <script>
            function toggleCompany() {
                let role = document.getElementById('role').value;
                document.getElementById('companyDiv').style.display =
                    role === 'recruiter' ? 'block' : 'none';
                document.getElementById('githubDiv').style.display =
                    role === 'candidate' ? 'block' : 'none';
            }
        </script>
        

    </body>
</html>
