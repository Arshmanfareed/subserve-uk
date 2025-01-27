<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Blog Posts</h2>
        <div class="row">
            <?php
            // fetch_blogs.php

            // Database connection settings
            $host = "localhost"; // Your database host
            $dbname = "subserve_co_uksubserve_beta"; // Your database name
            $username = "root"; // Your database username
            $password = ""; // Your database password
            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Fetch blogs
                $sql = "SELECT * FROM blogs ORDER BY created_at DESC";
                $stmt = $pdo->query($sql);

                // Loop through the blogs and display them
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <?php if (!empty($row['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top" alt="Blog Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><?php echo substr(htmlspecialchars($row['content']), 0, 100) . '...'; ?></p>
                                <p class="card-text"><small class="text-muted">By <?php echo htmlspecialchars($row['author']); ?> on <?php echo $row['created_at']; ?></small></p>
                                
                                <!-- Fetch and display tags -->
                                <?php if (!empty($row['tags'])): ?>
                                    <p class="card-text">
                                        <strong>Tags:</strong> 
                                        <?php 
                                            $tags = explode(',', $row['tags']); // Split the tags string into an array
                                            foreach ($tags as $tag): ?>
                                                <span class="badge badge-secondary"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                            <?php endforeach; 
                                        ?>
                                    </p>
                                <?php endif; ?>
                                
                                <a href="blog_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a>
                                </div>
                        </div>
                    </div>
            <?php
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div>
    </div>
</body>

</html>
