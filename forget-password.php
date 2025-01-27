<?php
include("layouts/header.php");
include('src/connection.php');
?>
    <section class="breadcrumb__area box-plr-75">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="breadcrumb__wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Login</li>
                                    </ol>
                                  </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<section class="login-area pb-100">
                <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                            <div class="basic-login">
                            <h3 class="text-center mb-60">Request New Password</h3>
                            <form action="#">
                                <label for="pass">Enter Your Email <span>*</span></label>
                                <input id="emailUser" type="email" placeholder="Enter Email Address...">
                                <button id="requestPassword" class="t-y-btn w-100">Reset Password</button>
                                <div id="status">
                                    
                                </div>
                            </form>
                            </div>
                    </div>
                </div>
                </div>
            </section>

<?php
include('layouts/footer-scripts.php');
include('layouts/footer-end.php');
?>