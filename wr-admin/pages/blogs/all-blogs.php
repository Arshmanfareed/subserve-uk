<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Blogs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/custom.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('../../pages/layout/sidebar.php'); ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h2>Manage Blogs</h2>
                    <a href="addBlog.php" class="btn btn-primary mb-3">Add New Blog</a>

                    <!-- Tabs for Published and Draft Blogs -->
                    <ul class="nav nav-tabs" id="blogTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="published-tab" data-toggle="tab" href="#published" role="tab" aria-controls="published" aria-selected="true">Published</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="draft-tab" data-toggle="tab" href="#draft" role="tab" aria-controls="draft" aria-selected="false">Draft</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="archive-tab" data-toggle="tab" href="#archive" role="tab" aria-controls="archive" aria-selected="false">Archive</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="blogTabContent">
                        <div class="tab-pane fade show active" id="published" role="tabpanel" aria-labelledby="published-tab">
                            <!-- Published Blogs Table -->
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Image</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Database connection settings
                                    $host = "localhost";
                                    $dbname = "subserve_co_uksubserve_beta";
                                    $username = "root";
                                    $password = "";

                                    // $host = "localhost";
                                    // $username = "subserve_co_uksubserve_beta";
                                    // $password = 'Yahoo.com@123';
                                    // $dbname = "subserve_co_uksubserve_beta";

                                    try {
                                        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        // Fetch published blogs
                                        $stmt = $pdo->query("SELECT * FROM blogs WHERE status = 'publish' AND is_archive = 0 ORDER BY created_at DESC");
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                                                <td>
                                                    <?php if (!empty($row['image_url'])): ?>
                                                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Blog Image" style="width: 100px; height: auto;">
                                                    <?php else: ?>
                                                        No Image
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                                <td>
                                                    <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="archive_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Are you sure you want to archive this blog?');">Archive</a>
                                                    <a href="delete_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } catch (PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="draft" role="tabpanel" aria-labelledby="draft-tab">
                            <!-- Draft Blogs Table -->
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Image</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch draft blogs
                                    try {
                                        $stmt = $pdo->query("SELECT * FROM blogs WHERE status = 'draft'  AND is_archive = 0 ORDER BY created_at DESC");
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                                                <td>
                                                    <?php if (!empty($row['image_url'])): ?>
                                                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Blog Image" style="width: 100px; height: auto;">
                                                    <?php else: ?>
                                                        No Image
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                                <td>
                                                    <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="delete_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } catch (PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="archive" role="tabpanel" aria-labelledby="archive-tab">
                            <!-- Draft Blogs Table -->
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Image</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch draft blogs
                                    try {
                                        $stmt = $pdo->query("SELECT * FROM blogs WHERE is_archive = 1 ORDER BY created_at DESC");
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                                                <td>
                                                    <?php if (!empty($row['image_url'])): ?>
                                                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Blog Image" style="width: 100px; height: auto;">
                                                    <?php else: ?>
                                                        No Image
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                                <td>
                                                    <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="unarchive_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to unarchive this blog?');">Unarchive</a>
                                                    <a href="delete_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } catch (PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
</body>

</html>
