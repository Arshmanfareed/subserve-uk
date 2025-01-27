<?php
include('layouts/header.php');
include('src/connection.php');

// Fetch blogs from the database
$sql = "SELECT * FROM blogs WHERE status = 'publish' ORDER BY created_at ASC";
$result = $conn->query($sql);
$recentblogsql = "SELECT * FROM blogs WHERE status = 'publish'  ORDER BY created_at DESC LIMIT 10";
$recentblogresult = $conn->query($recentblogsql);
?>
<div class="block-entry fixed-background" style="background-image: url('assets/img/banner/contact.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="cell-view simple-banner-height text-center">
                    <div class="empty-space col-xs-b35 col-sm-b70"></div>
                    <h1 class="h1 light">Blogs</h1>
                    <div class="title-underline center"><span></span></div>
                    <!-- <div class="simple-article light transparent size-4">Get In Touch With Us</div> -->
                    <div class="empty-space col-xs-b35 col-sm-b70"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="empty-space col-xs-b35 col-md-b70"></div>

<!-- <div class="container">
    <div class="text-center">
        <div class="simple-article size-3 grey uppercase col-xs-b5">our contacts</div>
        <div class="h2">we ready for your questions</div>
        <div class="title-underline center"><span></span></div>
    </div>
</div> -->

<div class="empty-space col-sm-b15 col-md-b50"></div>

<div class="container">
    <div class="row">
        <div class="col-md-2 pl-0">
           <div class="row">
           <div class="col-md-12 pl-0">
                <h2 class="all-blogs-heading">Recent Blogs</h2>
                <?php
                if ($recentblogresult->num_rows > 0) {
                    while ($row = $recentblogresult->fetch_assoc()) {
                        // Determine the image to display
                        $imagePath = empty($row['image_url']) ? 
                            'http://localhost/subserve/assets/img/noimagefound.png' : 
                            'http://localhost/subserve/wr-admin/pages/blogs/' . $row['image_url'];

                        // Format the date
                        $formattedDate = (new DateTime($row['created_at']))->format('M d, Y');
                ?>
                    <div class="recent-blog">
                        <div class="row align-items-center">
                            <!-- Blog Image -->
                            <div class="col-md-4 pl-0 recentimg">
                                <img src="<?php echo $imagePath; ?>" class="img-fluid blog-image" alt="Blog Image">
                            </div>
                            <!-- Blog Content -->
                            <div class="col-md-8">
                                <a href="http://localhost/subserve/blog/<?php echo $row['blog_slug']; ?>">    
                                    <h5 class="recentblog-title"><?php echo $row['title']; ?></h5>
                                </a>
                                <p class="recentblog-date"><small class="text-muted"><?php echo $formattedDate; ?></small></p>
                                <p class="recentblog-content">
                                    <?php 
                                   $content = $row['content'];
                                   // HTML tags ko remove karein
                                   $plainContent = strip_tags($content);
                                   // Text ko truncate karein agar wo 50 characters se zyada ho
                                   echo strlen($plainContent) > 50 ? mb_substr($plainContent, 0, 50) . '...' : $plainContent; 
                                    ?>
                                </p>
                            </div>
                        </div>
                        <hr>
                    </div>
                <?php
                    }
                } else {
                    echo '<p>No blogs found.</p>';
                }
                ?>
            </div>
           </div>
        </div>
        <div class="col-md-10">
        <?php
            if ($result->num_rows > 0) {
                $count = 0; // Counter to track blogs
                while ($row = $result->fetch_assoc()) {
                    // Open a new row for every two blogs
                    if ($count % 2 == 0) {
                        echo '<div class="row">';
                    }

                    // Determine the image to display
                    $imagePath = empty($row['image_url']) ? 
                        'http://localhost/subserve/assets/img/noimagefound.png' : 
                        'http://localhost/subserve/wr-admin/pages/blogs/' . $row['image_url'];

                    // Format the date
                    $formattedDate = (new DateTime($row['created_at']))->format('M d, Y');
                ?>
                    <div class="col-md-6 mb-4">
                        <div class="blogcard">
                            <div class="blogimage">
                                <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="Blog Image">
                            </div>
                            
                            <div class="blogcard-body">                             
                                <a href="http://localhost/subserve/blog/<?php echo $row['blog_slug']; ?>">
                                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                </a>
                                <p class="card-text"><small class="text-muted"><?php echo $formattedDate; ?></small></p>
                                <p class="card-text">
                                    <?php 
                                   $content = $row['content'];
                                   // HTML tags ko remove karein
                                   $plainContent = strip_tags($content);
                                   // Text ko truncate karein agar wo 50 characters se zyada ho
                                   echo strlen($plainContent) > 200 ? mb_substr($plainContent, 0, 200) . '...' : $plainContent; 
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
            <?php
                    $count++;
                    // Close the row after two blogs or at the end
                    if ($count % 2 == 0 || $count == $result->num_rows) {
                        echo '</div>';
                    }
                }
            } else {
                echo '<p>No blogs found.</p>';
            }
        ?>
        </div>
        
    </div>
</div>
<style>
    .recent-blog {
        margin-bottom: 20px;
    }

    .blog-image {
        border-radius: 5px;
        object-fit: cover;
        height: 50px; /* Adjust height as needed */
        width: 100px;
    }

    .blog-title {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 10px;
    }

    .blog-date {
        font-size: 0.9rem;
        color: #999;
        margin-bottom: 10px;
    }

    .blog-content {
        color: #666;
        font-size: 1rem;
        line-height: 1.5;
    }

    .recent-blog hr {
        border: 0.5px solid #ddd;
        margin: 10px 0;
    }

    .row.align-items-center {
        display: flex;
        align-items: center;
    }
    .all-blogs-heading{
        margin-bottom: 45px;
    padding-bottom: 10px;
    border-bottom: 1px solid black;
    font-size: 20px;
    font-weight: 800;
    }

    h5.recentblog-title {
    font-size: 12px;
    }

    p.recentblog-date {
        font-size: 12px;
        margin-top: 5px;
    }

    .recent-blog p {
        font-size: 11px;
        margin-top: 5px;
    }

    .recent-blog .col-md-8 {
        padding-left: 0;
    }

    .recent-blog .col-md-4.pl-0.recentimg {
        padding-left: 0;
    }
</style>
<!-- Basic Styling -->
<style>
    .blogcard {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
        background-color: #fff;
        height: 370px;
    }

    .blogcard:hover {
        transform: scale(1.02);
    }

    .blogimage img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        object-fit: scale-down;
        object-position: center;
    }

    .blogcard-body {
        padding: 15px;
    }

    .card-title {
        font-size: 1.25rem;
        margin-bottom: 10px;
        color: #333;
        text-transform: capitalize;
    }

    .card-text {
        color: #666;
        line-height: 21px;
    }

    .card-text small {
        display: block;
        margin-bottom: 10px;
        color: #999;
    }

    .container {
        margin-top: 20px;
    }
</style>


<div class="empty-space col-xs-b25 col-sm-b50"></div>


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