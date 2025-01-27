<?php
// add_blog.php
$host = "localhost"; 
$dbname = "subserve_co_uksubserve_beta";
$username = "root";
$password = ""; 

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Collect form data
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];
        $tags = $_POST['tags']; // Tags can now be a comma-separated string
        $image_url = '';

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

        // Insert blog into the database
        $sql = "INSERT INTO blogs (title, content, author, image_url, tags) 
                VALUES (:title, :content, :author, :image_url, :tags)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':tags', $tags); // Bind the tags field

        if ($stmt->execute()) {
            echo "Blog added successfully!";
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
    <style>
        .tag-container {
            display: flex;
            flex-wrap: wrap;
            padding: 5px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            margin-bottom: 15px;
            min-height: 40px; /* Adjust height */
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
            flex: 1; /* Allows input to take full width */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Add a New Blog</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter blog title" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="5" placeholder="Enter blog content" required></textarea>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" placeholder="Enter author name" required>
            </div>
            <div class="form-group">
                <label for="tags">Tags:</label>
                <div class="tag-container" id="tagContainer">
                    <input type="text" class="tag-input" id="tagInput" placeholder="Add a tag" />
                </div>
            </div>
            <div class="form-group">
                <label for="image">Upload Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Blog</button>
            <input type="hidden" name="tags" id="tags" />
        </form>
    </div>

    <script>
        const tagInput = document.getElementById('tagInput');
        const tagContainer = document.getElementById('tagContainer');
        const tagsInputHidden = document.getElementById('tags');

        tagInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter' && tagInput.value.trim() !== '') {
                event.preventDefault(); // Prevent form submission

                // Create a new tag
                const tag = document.createElement('div');
                tag.className = 'tag';
                tag.textContent = tagInput.value.trim();

                // Create a remove icon
                const removeIcon = document.createElement('span');
                removeIcon.textContent = 'x';
                removeIcon.className = 'remove-tag';
                removeIcon.onclick = function() {
                    tagContainer.removeChild(tag);
                    updateTagsInput();
                };

                tag.appendChild(removeIcon);
                tagContainer.insertBefore(tag, tagInput); // Insert tag before input
                tagInput.value = ''; // Clear input
                updateTagsInput(); // Update hidden input
            }
        });

        function updateTagsInput() {
            const tags = Array.from(tagContainer.getElementsByClassName('tag'))
                .map(tag => tag.textContent.replace('x', '').trim())
                .join(',');
            tagsInputHidden.value = tags; // Set the value of hidden input
        }
    </script>
</body>
</html>
