<?php
session_start();
include_once('../Database/config.php');

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../Forms/login.php");
    exit;
}

// Check admin privilege
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "Access denied. You are not an admin.";
    exit;
}

// Handle Add Book form submission
if (isset($_POST['submit'])) {
    $required_fields = ['Book_name', 'description', 'Price', 'rating', 'Books_image'];
    $valid = true;
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $valid = false;
            break;
        }
    }

    if ($valid) {
        $Book_name = trim($_POST['Book_name']);
        $description = trim($_POST['description']);
        $Price = trim($_POST['Price']);
        $rating = (int)$_POST['rating'];
        $Books_image = trim($_POST['Books_image']);

        try {
            // Note: Backticks around Book name if your DB column has spaces
            $sql = "INSERT INTO books (`Book_name`, description, Price, rating, Books_image) 
                    VALUES (:Book_name, :description, :Price, :rating, :Books_image)";
            $insertbook = $conn->prepare($sql);

            $insertbook->bindParam(':Book_name', $Book_name, PDO::PARAM_STR);
            $insertbook->bindParam(':description', $description, PDO::PARAM_STR);
            $insertbook->bindParam(':Price', $Price, PDO::PARAM_STR);
            $insertbook->bindParam(':rating', $rating, PDO::PARAM_INT);
            $insertbook->bindParam(':Books_image', $Books_image, PDO::PARAM_STR);

            $insertbook->execute();

            $_SESSION['success_message'] = "Book added successfully!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Database error: " . $e->getMessage();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        $_SESSION['error_message'] = "All fields are required!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fetch users & books data
$users_data = $conn->query("SELECT * FROM user")->fetchAll(PDO::FETCH_ASSOC);
$books_data = $conn->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      min-height: 100vh;
      background: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      background: #343a40;
      color: white;
      padding-top: 1rem;
      z-index: 1000;
    }
    .sidebar a {
      color: #adb5bd;
      display: flex;
      align-items: center;
      padding: 12px 20px;
      text-decoration: none;
      font-weight: 500;
      transition: background 0.3s, color 0.3s;
    }
    .sidebar a:hover, .sidebar a.active {
      background: #495057;
      color: white;
    }
    .sidebar a i {
      margin-right: 10px;
      font-size: 1.2rem;
    }
    main {
      margin-left: 240px;
      padding: 2rem;
    }
    .card-icon {
      font-size: 2rem;
      opacity: 0.3;
      position: absolute;
      top: 10px;
      right: 15px;
    }
    .table-responsive {
      max-height: 400px;
      overflow-y: auto;
    }
  </style>
</head>
<body>

  <nav class="sidebar">
    <h3 class="text-center mb-4">Admin Panel</h3>
    <a href="#" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="list_Books.php"><i class="bi bi-book"></i> Books</a>
    <a href="purchaseH.php"><i class="bi bi-wallet2"></i> Purchase History</a>
    <a href="../Logic/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </nav>

  <main>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Welcome, <?= htmlspecialchars($_SESSION['name']); ?>!</h2>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
        <i class="bi bi-plus-lg"></i> Add New Book
      </button>
    </div>

    <!-- Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['success_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Summary Cards -->
    <div class="row mb-5">
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="card shadow-sm position-relative">
          <div class="card-body">
            <h5 class="card-title">Users</h5>
            <h3><?= count($users_data); ?></h3>
            <i class="bi bi-people card-icon"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="card shadow-sm position-relative">
          <div class="card-body">
            <h5 class="card-title">Books</h5>
            <h3><?= count($books_data); ?></h3>
            <i class="bi bi-book card-icon"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Users Table -->
    <h3>Users</h3>
    <div class="table-responsive mb-5">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users_data as $user): ?>
          <tr>
            <td><?= htmlspecialchars($user['id']); ?></td>
            <td><?= htmlspecialchars($user['name']); ?></td>
            <td><?= htmlspecialchars($user['surname']); ?></td>
            <td><?= htmlspecialchars($user['email']); ?></td>
            <td>
              <a href="../Forms/edit.php?id=<?= urlencode($user['id']); ?>" class="btn btn-sm btn-warning me-1">
                <i class="bi bi-pencil"></i> Edit
              </a>
              <a href="../Logic/delete.php?id=<?= urlencode($user['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                <i class="bi bi-trash"></i> Delete
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Books Table -->
    <h3>Books</h3>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Book Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Rating</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($books_data)): ?>
            <?php foreach ($books_data as $book): ?>
              <tr>
                <td><?= htmlspecialchars($book['id']); ?></td>
                <td><?= htmlspecialchars($book['Book_name']); ?></td>
                <td><?= htmlspecialchars(mb_strimwidth($book['description'], 0, 50, '...')); ?></td>
                <td><?= htmlspecialchars($book['Price']); ?></td>
                <td><?= htmlspecialchars($book['rating']); ?></td>
                <td>
                  <a href="../Forms/editbook.php?id=<?= urlencode($user['id']); ?>" class="btn btn-sm btn-warning me-1">
                <i class="bi bi-pencil"></i> Edit
              </a>
                  <a href="../Logic/deletebook.php?id=<?= urlencode($book['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?');">
                    <i class="bi bi-trash"></i> Delete
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="6" class="text-center">No books found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Add Book Modal -->
  <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="Book_name" class="form-label">Book Name</label>
              <input type="text" class="form-control" id="Book_name" name="Book_name" required />
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label for="Price" class="form-label">Price</label>
              <select class="form-select" id="Price" name="Price" required>
                <option value="" disabled selected>Select Price</option>
                <option value="5">5</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="30+">30+</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="rating" class="form-label">Rating (1-10)</label>
              <input type="number" class="form-control" id="rating" name="rating" min="1" max="10" required />
            </div>
            <div class="mb-3">
              <label for="Books_image" class="form-label">Image Filename</label>
              <input type="text" class="form-control" id="Books_image" name="Books_image" placeholder="example.jpg" required />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="submit" class="btn btn-primary">Add Book</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
