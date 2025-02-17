<?php
// Start output buffering
ob_start();
include 'config/DB.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; 

    if ($id) {
        $query = "SELECT * FROM products WHERE id = $id";
        $stmt = $conn->query($query);
        $product = $stmt->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $product_name = htmlspecialchars($_POST['product_name'] ?? '');
    $page_title = htmlspecialchars($_POST['page_title'] ?? '');
    $product_url = htmlspecialchars($_POST['product_url'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');
    $old_price = floatval($_POST['old_price'] ?? 0);
    $new_price = floatval($_POST['new_price'] ?? 0);
    $coupon_code = htmlspecialchars($_POST['coupon_code'] ?? '');
    $visibility_status = htmlspecialchars($_POST['visibility_status'] ?? 'Published');
    $sizes = isset($_POST['sizes']) ? implode(',', array_map('htmlspecialchars', $_POST['sizes'])) : '';
    $color = htmlspecialchars($_POST['product_color'] ?? '');

    // Handle file uploads
    $images = '';
    if (!empty($_FILES['product_images']['name'][0])) {
        foreach ($_FILES['product_images']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['product_images']['name'][$key]);
            $target_file = 'storage/' . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $images .= $target_file . ',';  // Append new images
            } else {
                echo "<div class='alert alert-danger'>Failed to upload image: $file_name</div>";
            }
        }
        $images = rtrim($images, ','); // Remove trailing comma
    } else {
        // If no new image is uploaded, keep the old images
        $images = $product['images'];
    }
    $stmt = $conn->prepare("UPDATE products SET name = '$product_name', page_title = '$page_title', url = '$product_url', description = '$description', old_price = '$old_price', new_price = '$new_price', coupon_code = '$coupon_code', visibility = '$visibility_status', sizes = '$sizes', images = '$images', color = '$color' WHERE id = $id");

    if ($stmt->execute()) {
        header('Location: product-list.php');
        exit;        
        echo "<div class='alert alert-success'>Product updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
<div class="row align-items-center mb-4">
    <div class="border-0">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Edit Product</h3>
            <button type="submit" form="productForm" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase">
                <i class="fas fa-save me-2"></i> Save Product
            </button>
        </div>
    </div>
</div>

<form id="productForm" method="POST" enctype="multipart/form-data">
    <div class="row g-3 mb-3">
        <!-- Sidebar Section -->
        <div class="col-xl-4 col-lg-4">
            <div class="sticky-lg-top">
                <!-- Pricing Info -->
                <div class="card mb-3">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="m-0 fw-bold">Pricing Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Old Price</label>
                            <input type="number" name="old_price" value="<?php echo $product['old_price']?>" class="form-control" placeholder="Enter old price" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Price</label>
                            <input type="number" name="new_price" value="<?php echo $product['new_price']?>"  class="form-control" placeholder="Enter new price" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="coupon_code"  value="<?php echo $product['coupon_code']?>"  class="form-control" placeholder="Enter coupon code">
                        </div>
                    </div>
                </div>

                <!-- Visibility Status -->
                <div class="card mb-3">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="m-0 fw-bold">Visibility Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility_status" value="Published" id="statusPublished" <?php echo $product['visibility'] == 'Published' ? 'checked' : ''; ?> >
                            <label class="form-check-label" for="statusPublished">Published</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility_status" value="Scheduled" id="statusScheduled" <?php echo $product['visibility'] == 'Scheduled' ? 'checked' : ''; ?> >
                            <label class="form-check-label" for="statusScheduled">Scheduled</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility_status" value="Hidden" id="statusHidden" <?php echo $product['visibility'] == 'Hidden' ? 'checked' : ''; ?> >
                            <label class="form-check-label" for="statusHidden">Hidden</label>
                        </div>
                    </div>
                </div>

                <!-- Product Size -->
                <div class="card mb-3">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="m-0 fw-bold">Available Sizes</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $sizes = ['XS', 'S', 'M', 'L', 'XL']; // All available sizes
                        $selected_sizes = explode(',', $product['sizes']); // Convert selected sizes from a string to an array
                        
                        foreach ($sizes as $size) {
                            $checked = in_array($size, $selected_sizes) ? 'checked' : ''; // Check if the size is selected
                            echo "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' name='sizes[]' value='$size' id='size$size' $checked>
                                    <label class='form-check-label' for='size$size'>$size</label>
                                </div>";
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- Main Section -->
        <div class="col-xl-8 col-lg-8">
            <div class="accordion" id="productDetailsAccordion">
                <!-- Basic Information -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="basicInfoHeading">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#basicInfoCollapse" aria-expanded="true">
                            Basic Information
                        </button>
                    </h2>
                    <div id="basicInfoCollapse" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" name="product_name"   value="<?php echo $product['name']?>"  class="form-control" placeholder="Enter product name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Page Title</label>
                                    <input type="text" name="page_title"  value="<?php echo $product['page_title']?>"  class="form-control" placeholder="Enter page title" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Product URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text">https://yourstore.com/</span>
                                        <input type="text" name="product_url"   value="<?php echo $product['url']?>"  class="form-control" placeholder="product-name" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="5" placeholder="Enter product description"><?php echo htmlspecialchars($product['description']); ?></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Images -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="imagesHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#imagesCollapse" aria-expanded="false">
                            Images
                        </button>
                    </h2>
                    <div id="imagesCollapse" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <label class="form-label">Upload Product Images</label>
                                <input type="file" name="product_images[]" class="form-control" multiple>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Select Product Color</label>
                                <input type="color" name="product_color" class="form-control form-control-color">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
