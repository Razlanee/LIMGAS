<?php
$conn = new mysqli("localhost", "root", "", "activity1");


if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $conn->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
}

if (isset($_POST['update_user'])) {
    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $email = $_POST['edit_email'];
    $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
}

$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advanced User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }
        .custom-card {
            border-radius: 1rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
        .modal-content {
            border-radius: 1rem;
        }
        .btn-primary {
            background: #4a69bd;
            border: none;
        }
        .btn-primary:hover {
            background: #3b5b99;
        }
        .table thead {
            background-color: #4a69bd;
            color: white;
        }
        .btn-light {
            border-radius: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card custom-card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">User Management System</h4>
            <button class="btn btn-light btn-sm px-4 py-1" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add User</button>
        </div>
        <div class="card-body p-4">
            <table class="table table-bordered table-hover shadow-sm bg-white">
                <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 40%;">Email</th>
                    <th style="width: 25%;">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $row['id'] ?>">Edit</button>
                            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this user?')" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editUserModal<?= $row['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="edit_name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="edit_email" class="form-control" value="<?= htmlspecialchars($row['email']) ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button name="update_user" class="btn btn-success">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter valid email" required>
                </div>
            </div>
            <div class="modal-footer">
                <button name="add_user" class="btn btn-primary px-4">Add User</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
