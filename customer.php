<?php
// Define the content for this page
ob_start();
include 'config/DB.php'; // Include your database connection

if (isset($_GET['delUserId'])) {
    $id = (int)$_GET['delUserId']; // Cast to int to prevent SQL injection
    if ($id) {
        $query = "DELETE FROM users WHERE id = $id";
        $stmt = $conn->query($query);
        echo $stmt ? "<div class='alert alert-success'>User deleted successfully!</div>" : "<div class='alert alert-danger'>Something went wrong</div>";
    }
}

// Fetch customers from the database
$query = "SELECT * FROM users WHERE user_type = 'customer' ORDER BY id DESC"; // Fetch customers in descending order
$result = $conn->query($query);

// Check if there are any customers
if ($result && $result->num_rows > 0): ?>
<div class="container mt-4">
    <div class="row g-3">
        <?php while ($user = $result->fetch_assoc()): ?>
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold m-0">User ID: <?php echo htmlspecialchars($user['id']); ?> 
                            <span class="text-muted small fw-light">Registered: <?php echo htmlspecialchars($user['created_at']); ?></span>
                        </h6>
                        <h5 class="mb-1"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                        <p class="m-0 text-muted">Email: <strong><?php echo htmlspecialchars($user['email']); ?></strong> | Type: <strong><?php echo htmlspecialchars($user['user_type']); ?></strong></p>
                    </div>
                    <div>
                        <a href="?delUserId=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm d-flex align-items-center"
                           onclick="return confirm('Are you sure you want to delete this user?');">
                            <i class="bi bi-trash me-1"></i> Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<?php else: echo "<p>No customers available.</p>"; endif;

$content = ob_get_clean();
include 'layout.php';
?>
