<?php
include('layouts/header.php');
?>
<div class="page-contact-us">

    <div class="container col-sm-mt70 col-md-mt100 ">
        <div class="empty-space col-xs-b15 col-sm-b30"></div>
        <div class="breadcrumbs">
            <a href="#">Home</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="empty-space col-xs-b15 col-sm-b30 col-md-b50"></div>
        <div class="text-center">
            <div class="simple-article size-3 grey uppercase col-xs-b5">our contacts</div>
            <div class="h2">we ready for your questions</div>
            <div class="title-underline center"><span></span></div>
        </div>
    </div>

    <div class="empty-space col-xs-b25 col-sm-b50"></div>

    <!-- <div class="container">
        <div class="map-wrapper">
            <div id="map-canvas" class="full-width" data-lat="34.0151244" data-lng="-118.4729871" data-zoom="14"></div>
        </div>
        <div class="addresses-block hidden">
            <a class="marker" data-lat="34.0151244" data-lng="-118.4729871"
                data-string="1. Here is some address or email or phone or something else..."></a>
        </div>
    </div> -->


    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form class="help-form " id="contactusform" enctype="multipart/form-data" >
                    <div class="row m5">
                        <div class="col-xxl-12">
                            <div class="section__head mt-2 mb-30">
                                <div class="section__title">
                                    <h4 class="h4">How can we help you?</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <p class="form-label-text">Please select all that are appropriate*</p>
                            <div class="checkboxex">
                                <label class="checkbox-entry">
                                    <input type="checkbox" name="appropriate[]" value="Buy a product"><span><strong>Buy</strong> a product</span>
                                </label>
                                <label class="checkbox-entry">
                                    <input type="checkbox" name="appropriate[]" value="Sell to us"><span><strong>Sell </strong> to us</span>
                                </label>
                                <label class="checkbox-entry">
                                    <input type="checkbox" name="appropriate[]" value="Repair equipment"><span><strong>Repair </strong> equipment</span>
                                </label>
                                <label class="checkbox-entry">
                                    <input type="checkbox" name="appropriate[]" value="Service enquiry"><span><strong>Service </strong> enquiry</span>
                                </label>
                                <label class="checkbox-entry">
                                    <input type="checkbox" name="appropriate[]" value="Something else"><span>Something else</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="section__head mt-3 mb-30">
                                <div class="section__title">
                                    <h4 class="h4">
                                        That’s great. Please take a minute to leave us your details so that
                                        we can make contact.
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <input class="simple-input col-xs-b20" type="text" value="" placeholder="First Name"
                                name="firstname" />
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <input class="simple-input col-xs-b20" type="text" value="" placeholder="Last Name"
                                name="lastname" />
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <input class="simple-input col-xs-b20" type="email" value="" placeholder="Email"
                                name="email" />
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <input class="simple-input col-xs-b20" type="text" value="" placeholder="Company name"
                                name="companyname" />
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <input class="simple-input col-xs-b20" type="text" value="" placeholder="Country"
                                name="country" />
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <input class="simple-input col-xs-b20" type="tel" value="" placeholder="Best phone number to reach you?*"
                                name="phone" />
                        </div>
                        <div class="col-xxl-12">
                            <div class="section__head mt-3 mb-30">
                                <div class="section__title">
                                    <h4 class="h4">
                                    Can you tell us a bit more about how we can help?
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-8 col-lg-8">
                            <textarea class="simple-input col-xs-b20" placeholder="Drop a short comment or question here..."
                                name="message"></textarea>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="bulk-upload-file-wrap">
                                <div class="bulk-upload-content-wrapper">
                                    <p class="bulk-upload-para-1 mb-2">Preferred method - upload a list of
                                        devices.
                                        <a rel="noreferrer nofollow" target="_blank" href="/downloads/compare-and-recycle-bulk-order-template-v3.xlsx">Download
                                            template</a> (Excel format)
                                    </p>
                                    <input class="bulk-file-box-wrap" type="file" id="fileUpload" name="fileUpload" accept=".xls,.xlsx,.csv,.doc,.docx,.ods,.odt" max-size="3145728">
                                    <label class="bulk-upload-file" for="fileUpload"><i class="fa fa-upload" style="margin-right:8px"></i>Upload
                                        File</label>
                                     <p class="bulk-upload-para-2  mt-2">Accepted files types are .txt, .csv, .xls,
                                    .xlsx,
                                    .xml, .doc and .docx. Maximum file size 10MB.</p>
                                </div>
                            </div>
                        </div>
                       <div class="col-xxl-12">
                            <div class="section__head mt-30 mb-30">
                                <div class="section__title">
                                    <h4 class="h4">
                                   Let's stay in touch
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <p class="form-label-text">We'd love to keep you posted on all our exciting news (you'll be able to unsubscribe at any time).*</p>
                            <div class="checkboxex">
                                <label class="checkbox-entry">
                                    <input type="radio" name="required"><span>Yes please, I'd like to stay in touch</span>
                                </label>
                                <label class="checkbox-entry">
                                    <input type="radio" name="required"><span>No thanks</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="bulk-submitting-file-wrap">
                                <div class="bulk-submitting-content-wrapper">
                                    <h2 class="bulk-submitting-h2">Please fill out all required fields before submitting

                                    </h2>
                                    <p class="bulk-submitting-para-2">Any additional information you provide will help us tailor our response to your specific needs.</p>
                                </div>
                                <div class="bulk-submitting-button-wrapper">
                                    <div class="button size-2 style-3">
                                    <span class="button-wrapper">
                                        <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                                        <span class="text">Send us your enquiry</span>
                                    </span>
                                    <input class="contact-us-form" type="submit" />
                                </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="empty-space col-xs-b35 col-md-b70"></div>
    <div class="empty-space col-xs-b35 col-md-b70"></div>
    </div>
<?php
include('layouts/footer-scripts2.php');
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
var jQuery321 = $.noConflict(true);
</script>

<script>
    $(function () {

        "use strict";

      
            
    $("#contactusform").on('submit', function(e) {
 var formData = new FormData($("#contactusform")[0]);
     
                
console.log(formData);
                $.ajax({
                    processData: false,
    contentType: false,
    cache: false,
                    type: "POST",
                    url: "src/contact-us_handler.php",
                    data:  formData,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status === "success") {
                            // Use SweetAlert2 for a nicer alert
                            Swal.fire({
                                icon: 'success',
                                title: 'Thanks for reaching out!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                // Reset the form after successful submission
                                form.trigger('reset');
                            });
                        } else {
                            // Use SweetAlert2 for an error alert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: 'The following fields should be filled:<br>' + response.message
                            });

                            // Highlight the invalid fields
                            if (response.invalidFields) {
                                for (var i = 0; i < response.invalidFields.length; i++) {
                                    form.find('[name="' + response.invalidFields[i].toLowerCase() + '"]').addClass('invalid');
                                    form.find('[name="' + response.invalidFields[i].toLowerCase() + '"]').next('.error-message').text('- ' + response.invalidFields[i]).show();
                                }
                            }
                        }
                    },
                    error: function () {
                        // Use SweetAlert2 for a generic error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to submit the form'
                        });
                    }
                });
            
            return false;
        });

        $(document).on('keyup', '.input-wrapper .input', function () {
            $(this).removeClass('invalid');
            $(this).next('.error-message').hide();
        });

        function updateTextPopup(title, text) {
            $('.simple-text-popup .title').text(title);
            $('.simple-text-popup .text').text(text);
            $('.popup-wrapper').addClass('active');
            $('.simple-text-popup').addClass('active');
        }

    });
</script>
<?php
include('layouts/footer-end.php');
?>