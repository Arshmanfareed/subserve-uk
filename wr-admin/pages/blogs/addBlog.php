<?php
// add_blog.php
$host = "localhost";
$dbname = "subserve_co_uksubserve_beta";
$username = "root";
$password = "";
// $host = "localhost";
// $username = "subserve_co_uksubserve_beta";
// $password = 'Yahoo.com@123';
// $dbname = "subserve_co_uksubserve_beta";

$success = false; // Flag for successful addition

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Collect form data
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];
        $tags = $_POST['tags'];
        $meta_titles = $_POST['meta_titles'];
        $meta_description = $_POST['meta_description'];
        $schema_markup = $_POST['schema_markup'];
        $schema_markup2 = $_POST['schema_markup2'];
        $schema_markup3 = $_POST['schema_markup3'];
        $status = $_POST['status'];
        // Generate slug from name
        $blog_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));

        $slug_check_sql = "SELECT COUNT(*) AS slug_count FROM blogs WHERE blog_slug = :blog_slug";
        $slug_check_stmt = $pdo->prepare($slug_check_sql);
        $slug_check_stmt->bindParam(':blog_slug', $blog_slug);
        $slug_check_stmt->execute();
        $row = $slug_check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['slug_count'] > 0) {
            $unique_id = time(); // Use timestamp to ensure uniqueness
            $blog_slug .= '-' . $unique_id;
        }
        $image_url = '';

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $upload_dir = 'uploads/';
            $image_url = $upload_dir . basename($image_name);

            // Move the uploaded image to the destination folder
            if (!move_uploaded_file($image_tmp_name, $image_url)) {
                echo "Failed to upload image.";
            }
        }

        // Insert blog into the database
        $sql = "INSERT INTO blogs (title, blog_slug, content, author, image_url, tags, meta_titles, meta_description, schema_markup, schema_markup2, schema_markup3, status) 
        VALUES (:title, :blog_slug, :content, :author, :image_url, :tags, :meta_titles, :meta_description, :schema_markup, :schema_markup2, :schema_markup3, :status)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':blog_slug', $blog_slug);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':tags', $tags);
        $stmt->bindParam(':meta_titles', $meta_titles);
        $stmt->bindParam(':meta_description', $meta_description);
        $stmt->bindParam(':schema_markup', $schema_markup);
        $stmt->bindParam(':schema_markup2', $schema_markup2);
        $stmt->bindParam(':schema_markup3', $schema_markup3);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            $success = true; // Set success flag if blog is added successfully
        } else {
            echo "Error adding blog.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/9dyl4rpzecdyiji86ueiqbi2p9vz07o4f36hdb968lpe1bj5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/custom.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.css">
    <style>
        .tag-container {
            display: flex;
            flex-wrap: wrap;
            padding: 5px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            margin-bottom: 15px;
            min-height: 40px;
        }

        .tag {
            background-color: #007bff;
            color: white;
            border-radius: 3px;
            padding: 5px 10px;
            margin: 5px;
            display: flex;
            align-items: center;
        }

        .tag .remove-tag {
            margin-left: 5px;
            cursor: pointer;
            color: white;
        }

        .tag-input {
            border: none;
            outline: none;
            flex: 1;
        }
        small#imageError {
            font-size: 14px;
            font-weight: 500;
            margin-top: 10px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('../../pages/layout/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <h2>Add a New Blog</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter blog title" required>
                        </div>

                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea class="form-control" id="code_preview0" name="content" placeholder="Enter blog content"></textarea>
                        </div>

                        

                        <div class="form-group">
                            <label for="author">Author:</label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="Enter author name" >
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags:</label>
                            <div class="tag-container" id="tagContainer">
                                <input type="text" class="tag-input" id="tagInput" placeholder="Add a tag" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_titles">Meta Titles:</label>
                            <input type="text" class="form-control" id="meta_titles" name="meta_titles" placeholder="Enter meta titles" >
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description:</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Enter meta description" ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="schema_markup1">Schema Markup 1:</label>
                            <textarea class="form-control" id="schema_markup" name="schema_markup" rows="3" placeholder="Enter schema markup 1" ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="schema_markup2">Schema Markup 2:</label>
                            <textarea class="form-control" id="schema_markup2" name="schema_markup2" rows="3" placeholder="Enter schema markup 2" ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="schema_markup3">Schema Markup 3:</label>
                            <textarea class="form-control" id="schema_markup3" name="schema_markup3" rows="3" placeholder="Enter schema markup 3" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="draft">Draft</option>
                                <option value="publish">Publish</option>
                            </select>
                        </div>

                        <!-- <div class="form-group">
                            <label for="image">Upload Image:</label>
                            <input type="file" class="form-control-file" id="image" name="image" >
                        </div> -->

                        <div class="form-group">
                            <label for="image">Upload Image:</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                            <small id="imageError" class="text-danger" style="display:none;">Image must be 800x600 pixels.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Blog</button>
                        <input type="hidden" name="tags" id="tags" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close closeModalButton" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    <p class="mt-3">Blog added successfully!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeModalButton"  data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#code_preview0').summernote({height: 300});
        });
    </script>
   <script>
        document.getElementById('image').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const img = new Image();
            const minWidth = 800; // Minimum width
            const minHeight = 600; // Minimum height

            img.onload = function () {
                if (this.width < minWidth || this.height < minHeight) {
                    document.getElementById('imageError').style.display = 'block';
                    event.target.value = ''; // Clear the input field
                } else {
                    document.getElementById('imageError').style.display = 'none';
                }
            };

            img.src = URL.createObjectURL(file);
        });
    </script>
    <script>
        // tinymce.init({
        //     selector: '#content',
        //     menubar: false,
        //     plugins: 'lists link image charmap preview anchor',
        //     toolbar: 'formatselect | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | link image',
        //     style_formats: [{
        //             title: 'Heading 1',
        //             format: 'h1'
        //         },
        //         {
        //             title: 'Heading 2',
        //             format: 'h2'
        //         },
        //         {
        //             title: 'Heading 3',
        //             format: 'h3'
        //         },
        //         {
        //             title: 'Paragraph',
        //             format: 'p'
        //         }
        //     ],
        //     content_css: '//www.tiny.cloud/css/codepen.min.css',
        //     setup: function(editor) {
        //         editor.on('change', function() {
        //             tinymce.triggerSave();
        //         });
        //     }
        // });
    </script>
    <script>
        const tagInput = document.getElementById('tagInput');
        const tagContainer = document.getElementById('tagContainer');
        const tagsInputHidden = document.getElementById('tags');

        tagInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter' && tagInput.value.trim() !== '') {
                event.preventDefault();
                const tag = document.createElement('div');
                tag.className = 'tag';
                tag.textContent = tagInput.value.trim();
                const removeIcon = document.createElement('span');
                removeIcon.textContent = 'x';
                removeIcon.className = 'remove-tag';
                removeIcon.onclick = function() {
                    tagContainer.removeChild(tag);
                    updateTagsInput();
                };
                tag.appendChild(removeIcon);
                tagContainer.insertBefore(tag, tagInput);
                tagInput.value = '';
                updateTagsInput();
            }
        });

        function updateTagsInput() {
            const tags = Array.from(tagContainer.getElementsByClassName('tag'))
                .map(tag => tag.textContent.replace('x', '').trim())
                .join(',');
            tagsInputHidden.value = tags;
        }

        // Show the success modal if $success is true
        $(document).ready(function() {
        // Show the modal if success
            <?php if ($success): ?>
                $('#successModal').modal('show');
            <?php endif; ?>

            // Manually close the modal when the button is clicked
            $('.closeModalButton').on('click', function() {
                $('#successModal').modal('hide');
            });
        });
    </script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
</body>

</html>