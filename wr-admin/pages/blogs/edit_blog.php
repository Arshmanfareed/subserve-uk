<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "subserve_co_uksubserve_beta";

// $servername = "localhost";
// $username = "subserve_co_uksubserve_beta";
// $password = 'Yahoo.com@123';
// $dbname = "subserve_co_uksubserve_beta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_GET['id'])) {
    header('Location: all-blogs.php');
    exit;
}

$id = $_GET['id'];
$blog = null;
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $blog = $result->fetch_assoc();
} else {
    echo "Blog not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $status = $_POST['status'];
    $tags = $_POST['tags'];
    $meta_titles = $_POST['meta_titles'];
    $meta_description = $_POST['meta_description'];
    $schema_markup = $_POST['schema_markup'];
    $schema_markup2 = $_POST['schema_markup2'];
    $schema_markup3 = $_POST['schema_markup3'];

    $image_url = '';
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $tmp_name = $_FILES['image_url']['tmp_name'];
        $name = basename($_FILES['image_url']['name']);
        $image_url = $upload_dir . $name;

        if (!move_uploaded_file($tmp_name, $image_url)) {
            echo "Error uploading image.";
            exit;
        }
    } else {
        $image_url = $blog['image_url']; // Retain the old image if no new upload
    }

    $content = $_POST['content'];

    // Update the blog post
    $update_stmt = $conn->prepare("UPDATE blogs SET title = ?, author = ?, image_url = ?, content = ?, status = ?, tags = ?, meta_titles = ?, meta_description = ?, schema_markup = ?, schema_markup2 = ?, schema_markup3 = ? WHERE id = ?");
    $update_stmt->bind_param("sssssssssssi", $title, $author, $image_url, $content, $status, $tags, $meta_titles, $meta_description, $schema_markup, $schema_markup2, $schema_markup3, $id);

    if ($update_stmt->execute()) {
        header('Location: edit_blog.php?id=' . $_GET['id']); // Redirect to blogs list after update
        exit;
    } else {
        echo "Error updating blog: " . $conn->error;
    }
}
?>
<style>
    small#imageError {
    font-size: 14px;
    font-weight: 500;
    margin-top: 10px;
}
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog - Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/custom.css">
    <script src="https://cdn.tiny.cloud/1/9dyl4rpzecdyiji86ueiqbi2p9vz07o4f36hdb968lpe1bj5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.css">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('../../pages/layout/sidebar.php'); ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h2>Edit Blog Post</h2>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="code_preview0" name="content" rows="5" required><?php echo htmlspecialchars($blog['content']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($blog['author']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags" value="<?php echo htmlspecialchars($blog['tags']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="meta_titles">Meta Titles</label>
                            <input type="text" class="form-control" id="meta_titles" name="meta_titles" value="<?php echo htmlspecialchars($blog['meta_titles']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?php echo htmlspecialchars($blog['meta_description']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="schema_markup">Schema Markup 1</label>
                            <textarea class="form-control" id="schema_markup" name="schema_markup" rows="3"><?php echo $blog['schema_markup']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="schema_markup2">Schema Markup 2</label>
                            <textarea class="form-control" id="schema_markup2" name="schema_markup2" rows="3"><?php echo htmlspecialchars($blog['schema_markup2']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="schema_markup3">Schema Markup 3</label>
                            <textarea class="form-control" id="schema_markup3" name="schema_markup3" rows="3"><?php echo htmlspecialchars($blog['schema_markup3']); ?></textarea>
                        </div>


                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="publish" <?php echo $blog['status'] == 'publish' ? 'selected' : ''; ?>>Published</option>
                                <option value="draft" <?php echo $blog['status'] == 'draft' ? 'selected' : ''; ?>>Draft</option>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="image_url">Image Upload</label>
                            <input type="file" class="form-control" id="image_url" name="image_url">
                        </div> -->
                        <div class="form-group">
                            <label for="image">Upload Image:</label>
                            <input type="file" class="form-control-file" id="image" name="image_url">
                            <small id="imageError" class="text-danger" style="display:none;">Image must be 800x600 pixels.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Blog</button>
                        <a href="all-blogs.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
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