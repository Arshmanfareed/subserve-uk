<?php
include('layouts/header.php');
?>
<div class="block-entry fixed-background" style="background-image: url('assets/img/banner/contact.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="cell-view simple-banner-height text-center">
                    <div class="empty-space col-xs-b35 col-sm-b70"></div>
                    <h1 class="h1 light">contact us</h1>
                    <div class="title-underline center"><span></span></div>
                    <div class="simple-article light transparent size-4">Get In Touch With Us</div>
                    <div class="empty-space col-xs-b35 col-sm-b70"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="empty-space col-xs-b35 col-md-b70"></div>

<div class="container">
    <div class="text-center">
        <div class="simple-article size-3 grey uppercase col-xs-b5">our contacts</div>
        <div class="h2">we ready for your questions</div>
        <div class="title-underline center"><span></span></div>
    </div>
</div>

<div class="empty-space col-sm-b15 col-md-b50"></div>

<div class="container">
    <div class="row">
        <!--<div class="col-sm-3">-->
        <!--    <div class="icon-description-shortcode style-1">-->
        <!--        <img class="icon" src="img/icon-25.png" alt="">-->
        <!--        <div class="title h6">address</div>-->
        <!--        <div class="description simple-article size-2">Subser USA, 30 N Gould St Ste R Sheridan, WY 82801 USA-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <div class="col-sm-4">
            <div class="icon-description-shortcode style-1">
                <img class="icon" src="img/icon-23.png" alt="">
                <div class="title h6">phone</div>
                <div class="description simple-article size-2" style="line-height: 26px;">
                    <a href="tel:+44 121 630 3773">+44 121 630 3773</a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="icon-description-shortcode style-1">
                <img class="icon" src="img/icon-28.png" alt="">
                <div class="title h6">email</div>
                <div class="description simple-article size-2"><a
                        href="mailto:sales@subserve.co.uk">sales@subserve.co.uk</a></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="icon-description-shortcode style-1">
                <img class="icon" src="img/icon-26.png" alt="">
                <div class="title h6">Follow us</div>
                <div class="follow light">
                    <a class="entry" href="https://m.facebook.com/p/Subserve-LTD-100072540512700/"><i
                            class="fa fa-facebook"></i></a>
                    <!--<a class="entry" href="#"><i class="fa fa-twitter"></i></a>-->
                    <a class="entry" href="https://uk.linkedin.com/company/subserve-ltd"><i
                            class="fa fa-linkedin"></i></a>
                    <!--<a class="entry" href="#"><i class="fa fa-google-plus"></i></a>-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="empty-space col-xs-b25 col-sm-b50"></div>

<div class="container">
    <h4 class="h4 text-center col-xs-b25">have a questions?</h4>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form class="contact-form" id="contact-form">
                <div class="row m5">
                    <div class="col-sm-6">
                        <input class="simple-input col-xs-b20" type="text" value="" placeholder="Name" name="name" />
                    </div>
                    <div class="col-sm-6">
                        <input class="simple-input col-xs-b20" type="text" value="" placeholder="Email" name="email" />
                    </div>
                    <div class="col-sm-6">
                        <input class="simple-input col-xs-b20" type="text" value="" placeholder="Phone" name="phone" />
                    </div>
                    <div class="col-sm-6">
                        <input class="simple-input col-xs-b20" type="text" value="" placeholder="Subject"
                            name="subject" />
                    </div>
                    <div class="col-sm-12">
                        <textarea class="simple-input col-xs-b20" placeholder="Your message" name="message"></textarea>
                    </div>
                    <div class="col-sm-12">
                        <div class="text-center">
                            <div class="button size-2 style-3">
                                <span class="button-wrapper">
                                    <span class="icon"><img src="img/icon-4.png" alt=""></span>
                                    <span class="text">send message</span>
                                </span>
                                <input type="submit" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="empty-space col-xs-b35 col-md-b70"></div>
<?php
include('layouts/footer-scripts2.php');
?>

<script>
    $(function () {

        "use strict";

        $('.contact-form').on("submit", function () {
            var $this = $(this);

            $('.invalid').removeClass('invalid');
            var errorMessages = [],
                successMessage = "Your email is very important to us. One of our representatives will contact you at first chance.",
                error = 0,
                pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

            if ($.trim($this.find('input[name="name"]').val()) === '') {
                errorMessages.push('Name');
                $this.find('input[name="name"]').addClass('invalid');
            }
            if (!pattern.test($.trim($this.find('input[name="email"]').val()))) {
                errorMessages.push('Email');
                $this.find('input[name="email"]').addClass('invalid');
            }
            if ($.trim($this.find('textarea[name="message"]').val()) === '') {
                errorMessages.push('Your Message');
                $this.find('textarea[name="message"]').addClass('invalid');
            }

            if (errorMessages.length > 0) {
                // Display error messages next to corresponding fields
                for (var i = 0; i < errorMessages.length; i++) {
                    $this.find('[name="' + errorMessages[i].toLowerCase() + '"]').addClass('invalid');
                    $this.find('[name="' + errorMessages[i].toLowerCase() + '"]').next('.error-message').text('- ' + errorMessages[i]).show();
                }
            } else {
                var form = $(this);
                var formData = form.serialize();

                $.ajax({
                    type: "POST",
                    url: "src/contact_handler.php",
                    data: formData,
                    dataType: "json",
                    success: function (response) {
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
            }
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