<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <?php
                // Database connection settings
                $host = "localhost"; // Your database host
                $dbname = "subserve_co_uksubserve_beta"; // Your database name
                $username = "root"; // Your database username
                $password = ""; // Your database password

                try {
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Fetch blog post by ID
                    if (isset($_GET['id'])) {
                        $id = intval($_GET['id']); // Get the blog ID from the URL
                        $sql = "SELECT * FROM blogs WHERE id = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();

                        $blog = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($blog) {
                ?>
                            <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                            <?php if (!empty($blog['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" class="img-fluid mb-4" alt="Blog Image">
                            <?php endif; ?>
                            <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
                            <p><strong>Author:</strong> <?php echo htmlspecialchars($blog['author']); ?></p>
                            <p><strong>Tags:</strong>
                                <?php 
                                $tags = explode(',', $blog['tags']); // Split the tags string into an array
                                foreach ($tags as $tag): ?>
                                    <span class="badge badge-secondary"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                <?php endforeach; ?>
                            </p>
                            <p><small class="text-muted">Published on: <?php echo htmlspecialchars($blog['created_at']); ?></small></p>
                <?php
                        } else {
                            echo "<p>Blog post not found.</p>";
                        }
                    } else {
                        echo "<p>No blog ID specified.</p>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
                <a href="fetch_blogs.php" class="btn btn-secondary mt-3">Back to Blogs</a>
            </div>
            <div class="col-md-4">
                <!-- Sidebar for Recent Blogs -->
                <h4>Recent Blogs</h4>
                <ul class="list-group mb-4">
                    <?php
                    // Fetch recent blogs
                    try {
                        $recent_sql = "SELECT id, title FROM blogs ORDER BY created_at DESC LIMIT 5";
                        $recent_stmt = $pdo->query($recent_sql);
                        while ($recent_blog = $recent_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <li class="list-group-item">
                                <a href="blog_details.php?id=<?php echo $recent_blog['id']; ?>">
                                    <?php echo htmlspecialchars($recent_blog['title']); ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    <?php } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </ul>

                <!-- Sidebar for Tags -->
                <h4>All Tags</h4>
                <ul class="list-group mb-4">
                    <?php
                    // Fetch all unique tags from blogs
                    try {
                        $tag_sql = "SELECT DISTINCT tags FROM blogs";
                        $tag_stmt = $pdo->query($tag_sql);
                        $all_tags = [];
                        while ($row = $tag_stmt->fetch(PDO::FETCH_ASSOC)) {
                            $tags = explode(',', $row['tags']);
                            $all_tags = array_merge($all_tags, array_map('trim', $tags));
                        }
                        $unique_tags = array_unique($all_tags);
                        foreach ($unique_tags as $tag): ?>
                            <li class="list-group-item">
                                <a href="#"><?php echo htmlspecialchars($tag); ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
