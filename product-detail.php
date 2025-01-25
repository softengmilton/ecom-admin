<?php
// Define the content for this page
ob_start();

include 'config/DB.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Cast to int to prevent SQL injection

    if ($id) {
        $query = "SELECT * FROM products WHERE id = $id";
        $stmt = $conn->query($query);

        if ($stmt && $stmt->num_rows > 0) {
            $product = $stmt->fetch_assoc();
        } else {
            // Handle product not found case
            echo "Product not found!";
            exit;
        }
    }
}

?>

<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Products Detail</h3>
        </div>
    </div>
</div> <!-- Row end  -->

<div class="row g-3 mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="product-details">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="product-details-image mt-50">
                                <div class="product-image">
                                    <div class="product-image-active tab-content" id="v-pills-tabContent">
                                        <a class="single-image tab-pane fade active show" id="v-pills-three" role="tabpanel" aria-labelledby="v-pills-three-tab">
                                            <img src="<?php echo $product['images']; ?>" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details-content mt-45">
                                <h2 class="fw-bold fs-4"><?php echo $product['name'] ?></h2>
                                <div class="my-3">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <!-- <span class="text-muted ms-3">............................................</span> -->
                                </div>
                                <div class="product-items flex-wrap">
                                    <h6 class="item-title fw-bold">Select Your <?php echo implode(' ', array_slice(explode(' ', $product['name']), 0, 2)); ?></h6>
                                    <div class="items-wrapper" id="select-item-1">
                                        <div class="single-item active">
                                            <div class="items-image">
                                                <img src="<?php echo $product['images']; ?>" alt="product">
                                            </div>
                                            <p class="text"><?php echo implode(' ', array_slice(explode(' ', $product['name']), 0, 2)); ?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="product-select-wrapper flex-wrap">
                                    <div class="select-item">
                                        <h6 class="select-title fw-bold">Select Color</h6>
                                        <ul class="color-select" id="select-color-1">
                                            <li style="background-color: #EFEFEF;" class="active"></li>
                                            <li style="background-color: #FAE5EC;"></li>
                                            <li style="background-color: #4C4C4C;"></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-price">
                                    <h6 class="price-title fw-bold">Price</h6>
                                    <p class="sale-price">$  <?php echo $product['new_price']?> USD</p>
                                    <p class="regular-price text-danger">$ <?php echo $product['old_price']?></p>
                                </div>
                                <p><?php echo $product['description'] ?></p>
                                <div class="product-btn mb-5">
                                    <div class="d-flex flex-wrap">
                                        <div class="mt-2 mt-sm-0  me-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="1" min="1" max="5">
                                                <span class="input-group-text"><i class="fa fa-sort"></i></span>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary mx-1 mt-2  mt-sm-0"><i class="fa fa-heart me-1"></i> Addto Wishlist</button>
                                        <button class="btn btn-primary mx-1 mt-2 mt-sm-0 w-sm-100"><i class="fa fa-shopping-cart me-1"></i> Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- Row end  -->

<?php
$content = ob_get_clean();
include 'layout.php';
?>