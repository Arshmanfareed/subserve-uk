<?php
include('layouts/header.php');
// print_r($_SESSION['cart'])
?>
<style>
    #verifyEmailLoader ,
    #verifyNumberLoader ,
    #emailLoader ,
    #numberLoader {
        display: none;
    }
    #verifyEmailLoader img,
    #verifyNumberLoader img,
    #emailLoader img,
    #numberLoader img {
        width: 50px;
        position: relative;
        top: 0;
        right: 0;
    }
    .form-group{
        padding: 0 30px;
    }

    #result.short{
        font-weight:bold;
        color:#FF0000;
        font-size:larger;
    }
    #result.weak{
        font-weight:bold;
        color:orange;
        font-size:larger;
    }
    #result.good{
        font-weight:bold;
        color:#2D98F3;
        font-size:larger;
    }
    #result.strong{
        font-weight:bold;
        color: limegreen;
        font-size:larger;
    }
    .intl-tel-input{
        display:block !important;
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
<div style="margin-top:3%;"  class="main-container col1-layout">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form class="contact-form" action="{{route('add-customer')}}" method="post"  enctype="multipart/form-data">
                        
                    <fieldset id="account">
                        <legend style="font-size:20px; font-weight:600; margin-bottom:28px; margin-left:25px;">Your Personal Details</legend>
                        <div class="form-group row">
                            <label style="margin-bottom:15px;" class="control-label" for="input-payment-firstname">Name <span class="required">*</span></label>
                            <input style="border:1px solid black;" type="text" name="firstname" value="" placeholder="First Name" id="firstname"  class="simple-input col-xs-b20"  required>
                             </div>
                        <div class="form-group row">
                            <div class="col-sm-5 col-xs-12" style="padding:0">
                                <label style="margin-bottom:15px;"class="control-label" for="input-payment-email">E-Mail <span class="required">*</span></label>
                                <input style="border:1px solid black;" type="email" name="customer_email" id="email" class="simple-input col-xs-b20" placeholder="Email" required>
                            </div>
                            <!--<div class="col-sm-5 col-xs-12 col-sm-offset-2" style="padding:0">-->
                            <!--    <label class="control-label" for="input-payment-email">Contact No <span class="required">*</span></label>-->
                            <!--    <input type="text" name="cell" value="{{ old('cell') }}" id="cell" class="form-control" placeholder="Cell Phone" required>-->
                            <!--</div>-->
                            <div class="col-sm-5 col-xs-12 col-sm-offset-2" style="padding:0" id="cont">
                                <label style="margin-bottom:15px;" class="control-label" for="input-payment-email">Contact No <span class="required">*</span></label>
                                <input style="border:1px solid black;" type="tel" name="cell"  id="cell" class="simple-input col-xs-b20"  required>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label style="margin-bottom:15px;" class="control-label" for="input-payment-firstname">Addresss <span class="required">*</span></label>
                            <input style="border:1px solid black;" type="text" name="address"  placeholder="Addresss" id="Addresss"  class="simple-input col-xs-b20"  required>
                             
                        </div>
                    </fieldset>
                    
                        <legend  style="font-size:20px; font-weight:600; margin-bottom:28px; margin-left:25px;">Your Password</legend>
                        <div  class="col-sm-5 col-xs-12">
                            <label style="margin-bottom:15px;" class="control-label" for="input-payment-password">Password <span class="required">*</span></label>
                            <input style="border:1px solid black;" type="password" name="password" value="" placeholder="Password" id="password" class="simple-input col-xs-b20" required>
                            <span id="result"></span>
                        </div>

                        <div  class="col-sm-5 col-xs-12 col-sm-offset-2" id="conf">
                            <label style="margin-bottom:15px;" class="control-label" for="input-payment-confirm">Confirm Password<span class="required">*</span></label>
                            <input style="border:1px solid black;" type="password" name="confirm" value="" placeholder="Confirm Password" id="input-payment-confirm" class="simple-input col-xs-b20" required>
                        </div>
                          
                      <div  class="col-sm-5 col-xs-12 col-sm-offset-2" >
       
                        <div class="form-group text-right" id="submi">
                            <button style="background-color: #26b1e6; padding:10px 38px; border-radius:50px; border-color:white;" type="submit" id="register-submit" class="btn btn-success">Submit</button>
                        </div>
                          </div>
                    
                    </form>
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