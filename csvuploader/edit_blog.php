<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Blog</h2>
        <?php
        // Database connection settings
        $host = "localhost"; // Your database host
        $dbname = "subserve_co_uksubserve_beta"; // Your database name
        $username = "root"; // Your database username
        $password = ""; // Your database password

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Get blog ID from URL
            $id = $_GET['id'];

            // Fetch blog details
            $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $blog = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // Collect form data
                $title = $_POST['title'];
                $content = $_POST['content'];
                $author = $_POST['author'];
                $image_url = $blog['image_url']; // Keep the existing image

                // Handle image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image_name = $_FILES['image']['name'];
                    $image_tmp_name = $_FILES['image']['tmp_name'];
                    $upload_dir = 'uploads/';
                    $image_url = $upload_dir . basename($image_name);

                    // Move the uploaded image to the destination folder
                    if (move_uploaded_file($image_tmp_name, $image_url)) {
                        echo "Image uploaded successfully!";
                    } else {
                        echo "Failed to upload image.";
                    }
                }

                // Update blog in the database
                $sql = "UPDATE blogs SET title = :title, content = :content, author = :author, image_url = :image_url WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':author', $author);
                $stmt->bindParam(':image_url', $image_url);
                $stmt->bindParam(':id', $id);

                if ($stmt->execute()) {
                    echo "Blog updated successfully!";
                    header("Location: admin_blogs.php"); // Redirect to admin blogs page
                    exit();
                } else {
                    echo "Error updating blog.";
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($blog['content']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($blog['author']); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Upload Image:</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <?php if (!empty($blog['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Current Image" style="width: 100px; height: auto;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Blog</button>
        </form>
    </div>
</body>

</html>
