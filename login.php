<?php
include('layouts/header.php');
// print_r($_SESSION['cart'])
?>
<style>
    .account-login .col2-set .col-1 {
    float: left;
    padding-bottom: 0;
    padding: 0;
    text-align: left;
    width: 49%;
    min-height: 362px;
    padding: 18px 25px 0 0;
    margin-bottom: 0;
}
.col1-layout .col-main {
    float: none;
    width: auto;
    padding: 0;
    border: none;
    background: inherit;
    display: inherit;
}
.account-login .col2-set .col-1 {
    float: left;
    padding-bottom: 0;
    padding: 0;
    text-align: left;
    width: 49%;
    min-height: 362px;
    padding: 18px 25px 0 0;
    margin-bottom: 0;
}
.page-title h1, .page-title h2 {
    color: #333;
    display: inline-block;
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 1px;
    line-height: 18px;
    margin: auto;
    text-transform: uppercase;
    margin-bottom: 5px;
}
.account-login strong {
    font-size: 14px;
    color: #000;
    margin-bottom: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.account-login .content {
    margin-top: 8px;
    padding-top: 12px;
}
</style>
 <div style="margin-top:3%;" class="main-container col1-layout">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <article class="col-main">
                        <div class="account-login">
                            <div class="page-title">
                                <h2 style="font-size:16px;">Login or Create an Account</h2>
                            </div>
                            <fieldset class="col2-set">
                                <div id="new" class="col-1 col-sm-6 new-users"><strong>New Customers</strong>
                                    <div class="content">
                                        <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
                                        <div style="margin-top:3%;" class="buttons-set">
                                            <button style="background-color: #26b1e6; padding:10px 38px; border-radius:50px; border-color:white;" onclick="window.location.replace('register.php')" class="btn btn-success" type="button"><span>Create an Account</span></button>
                                        </div>
                                         <div class="buttons-set">
                                            <a href="https://subserve.co.uk/guest_checkout" style="background-color: #26b1e6; padding:10px 38px; border-radius:50px; border-color:white;margin-top: 20px;"  class="btn btn-success" type="button"><span>Continue As Guest Checkout</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="user" class="col-2 col-sm-6 registered-users"><strong>Registered Customers</strong>
                                    <div class="content">
                                        <p>If you have an account with us, please log in.</p>
                                        <form id="login-form" action="" method="post" role="form" >
                                            
                                             
                                            <input type="hidden" name="redirect" value="">
                                            <ul class="form-list">
                                                <li>
                                                    <label style="margin-bottom:15px;" for="email">Email Address <span class="required">*</span></label>
                                                    <input style="border:1px solid #b7b7b7;" type="email" title="Email Address" class="simple-input col-xs-b20 required-entry" id="email" value="" name="email" onclick="ClickFileemail()" required>
                                                </li>
                                                <li>
                                                    <label style="margin-bottom:15px;" for="pass">Password <span class="required">*</span></label>
                                                    <input id="passw" style="border:1px solid #b7b7b7;" type="password" title="Password" id="pass" class="simple-input col-xs-b20 required-entry validate-password" name="password" onclick="ClickFilepass()" required>
                                                </li>
                                            </ul>
                                            <p class="required">* Required Fields</p>
                                            <div class="buttons-set">
                                                <button style="background-color: #26b1e6; padding:10px 38px; border-radius:50px; border-color:white;" id="send2" type="submit" class="btn btn-success"><span>Login</span></button>
                                                <a class="forgot-word" href="">Forgot Your Password?</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </article>
                    <!--	///*///======    End article  ========= //*/// -->
                </div>
            </div>
        </div>
    </div>
<?php
include('layouts/footer-scripts.php');
?>

<?php
include('layouts/footer-end.php');
?>