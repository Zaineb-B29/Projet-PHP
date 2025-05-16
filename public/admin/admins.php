<?php
session_start();
require_once '../../models/Admin.php';

// Check if logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$adminModel = new Admin();
$admins = $adminModel->getAllAdmins();

// Handle admin deletion
if (isset($_POST['delete_admin'])) {
    $adminId = $_POST['admin_id'];
    if ($adminId != $_SESSION['admin_id']) { // Prevent self-deletion
        $adminModel->deleteAdmin($adminId);
        header('Location: admins.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins - Admin Panel</title>
    <link rel="stylesheet" href="/projet_php/public/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid #34495e;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .admin-info {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #bdc3c7;
        }

        .menu-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: #ecf0f1;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .menu-item:hover {
            background-color: #34495e;
        }

        .menu-item.active {
            background-color: #3498db;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f5f6fa;
        }

        .content-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .add-admin-btn {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-admin-btn:hover {
            background-color: #27ae60;
        }

        .admins-table {
            width: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-collapse: collapse;
        }

        .admins-table th,
        .admins-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .admins-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .admins-table tr:last-child td {
            border-bottom: none;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 0.9rem;
        }

        .edit-btn {
            background-color: #3498db;
        }

        .edit-btn:hover {
            background-color: #2980b9;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .dashboard-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .admins-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <div class="admin-info">
                    Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?>
                </div>
            </div>
            
            <ul class="menu-list">
                <li>
                    <a href="dashboard.php" class="menu-item">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="products.php" class="menu-item">
                        <i class="fas fa-box"></i>
                        Products
                    </a>
                </li>
                <li>
                    <a href="users.php" class="menu-item">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
                <li>
                    <a href="admins.php" class="menu-item active">
                        <i class="fas fa-user-shield"></i>
                        Admins
                    </a>
                </li>
            </ul>
        </div>

        <div class="main-content">
            <div class="content-header">
                <h1>Manage Admins</h1>
                <a href="add_admin.php" class="add-admin-btn">
                    <i class="fas fa-plus"></i>
                    Add New Admin
                </a>
            </div>

            <table class="admins-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($admin = $admins->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= htmlspecialchars($admin['id']) ?></td>
                            <td><?= htmlspecialchars($admin['username']) ?></td>
                            <td><?= date('M d, Y', strtotime($admin['created_at'])) ?></td>
                            <td class="action-buttons">
                                <a href="edit_admin.php?id=<?= $admin['id'] ?>" class="action-btn edit-btn">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <?php if ($admin['id'] != $_SESSION['admin_id']): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="admin_id" value="<?= $admin['id'] ?>">
                                        <button type="submit" name="delete_admin" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this admin?')">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 