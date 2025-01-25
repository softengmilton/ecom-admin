<?php
// Define the content for this page
ob_start();
include 'config/DB.php'; // Include your database connection

if (isset($_GET['delOrderId'])) {
    $id = (int)$_GET['delOrderId']; // Cast to int to prevent SQL injection

    if ($id) {
        $query = "DELETE FROM orders WHERE id = $id";
        $stmt = $conn->query($query);

        if ($stmt) {
            echo "<div class='alert alert-success'>Order deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Something went wrong</div>";
        }
    }
}

// Fetch orders from the database
$query = "SELECT * FROM orders ORDER BY id DESC"; // Fetch orders in descending order
$result = $conn->query($query);

// Check if there are any orders
if ($result && $result->num_rows > 0):
?>
<div class="row g-3 mb-3">
    <div class="col-md-12 col-lg-10 col-xl-10 col-xxl-10">
        <?php 
        // Loop through each order and display it
        while ($order = $result->fetch_assoc()): 
        ?>
        <div class="card mb-3 bg-transparent p-2">
            <div class="card border-0 mb-1">
                <div class="card-body d-flex align-items-center flex-column flex-md-row">
                    <div class="ms-md-4 m-0 mt-4 mt-md-0 text-md-start text-center w-100">
                        <h6 class="mb-3 fw-bold">
                            Order ID: <?php echo htmlspecialchars($order['id']); ?>
                            <span class="text-muted small fw-light d-block">Order Date: <?php echo htmlspecialchars($order['created_at']); ?></span>
                            <h5><?php echo $order['product_name']?></h5>
                        </h6>
                        <div class="d-flex flex-row flex-wrap align-items-center justify-content-center justify-content-md-start">
                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                <div class="text-muted small">Customer Name</div>
                                <strong><?php echo ($order['first_name']); ?><?php echo ($order['last_name']); ?></strong>
                            </div>
                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                <div class="text-muted small">Total Amount</div>
                                <strong>$<?php echo number_format($order['amount'], 2); ?></strong>
                            </div>
                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                <div class="text-muted small">Status</div>
                                <strong><?php echo htmlspecialchars($order['status']); ?></strong>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <a href="?delOrderId=<?php echo $order['id']; ?>" 
                               class="btn btn-danger btn-sm d-flex align-items-center"
                               onclick="return confirm('Are you sure you want to delete this order?');">
                                <i class="bi bi-trash me-1"></i> Delete
                            </a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
else:
    echo "<p>No orders available.</p>";
endif;

$content = ob_get_clean();
include 'layout.php';
?>
