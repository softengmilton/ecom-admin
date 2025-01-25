<?php
// Define the content for this page
ob_start();
include 'config/DB.php'; // Include your database connection
if (isset($_GET['delProductid'])) {
    $id = (int)$_GET['delProductid']; // Cast to int to prevent SQL injection

    if ($id) {
        $query = "DELETE FROM products WHERE id = $id";
        $stmt = $conn->query($query);

        if ($stmt) {
            echo "<div class='alert alert-success'>Product deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Somthing went wrong</div>";
        }
    }
}

// Fetch products from the database
$query = "SELECT * FROM products ORDER BY id";
$result = $conn->query($query);

// Check if there are any products
if ($result && $result->num_rows > 0):
?>
<div class="row g-3 mb-3">
    <div class="col-md-12 col-lg-10 col-xl-10 col-xxl-10">
        <?php 
        // Loop through each product and display it
        while($product = $result->fetch_assoc()): 
        ?>
        <div class="card mb-3 bg-transparent p-2">
            <div class="card border-0 mb-1">
                <div class="form-check form-switch position-absolute top-0 end-0 py-3 px-3 d-none d-md-block">
                <input class="form-check-input" type="checkbox" id="product-<?php echo $product['id']; ?>" 
                <?php echo $product['visibility'] == 'Published' ? 'checked' : ''; ?>>

                    <label class="form-check-label" for="product-<?php echo $product['id']; ?>"> <?php echo $product['visibility']; ?></label>
                </div>
                <div class="card-body d-flex align-items-center flex-column flex-md-row">
                    <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                        <img class="w120 rounded img-fluid" src="<?php echo $product['images']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </a>
                    <div class="ms-md-4 m-0 mt-4 mt-md-0 text-md-start text-center w-100">
                        <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                            <h6 class="mb-3 fw-bold">
                                <?php echo htmlspecialchars($product['name']); ?>
                                <span class="text-muted small fw-light d-block">Reference <?php echo htmlspecialchars($product['id']); ?></span>
                            </h6>
                        </a>
                        <div class="d-flex flex-row flex-wrap align-items-center justify-content-center justify-content-md-start">
                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                <div class="text-muted small">Special Price</div>
                                <strong>$<?php echo number_format($product['new_price'], 2); ?></strong>
                            </div>
                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                <div class="text-muted small">Offer</div>
                                <strong><?php echo htmlspecialchars($product['coupon_code']); ?></strong>
                            </div>
                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                <div class="text-muted small">Old Price</div>
                                <strong class="text-decoration-line-through">$<?php echo number_format($product['old_price'], 2); ?></strong>
                            </div>
                            <div class="pe-xl-5 pe-md-4 ps-md-0 px-3 mb-2">
                                <div class="text-muted small">Ratings</div>
                                <strong><i class="icofont-star text-warning"></i> 4.5 <span class="text-muted">(145)</span></strong>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-info btn-sm me-2 d-flex align-items-center">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                                <a href="product-edit.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm me-2 d-flex align-items-center">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <a href="?delProductid=<?php echo $product['id']; ?>" 
                                   class="btn btn-danger btn-sm d-flex align-items-center"
                                   onclick="return confirm('Are you sure you want to delete this product?');">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </a> 
                            </div>
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
    echo "<p>No products available.</p>";
endif;

$content = ob_get_clean();
include 'layout.php';
?>
