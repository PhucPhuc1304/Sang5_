<?php
include_once 'app/views/share/header.php';

?>

<div class="container px-3 my-5 clearfix">
    <!-- Shopping cart table -->
    <div class="card">
        <div class="card-header">
            <h2>Shopping Cart</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered m-0">
                    <thead>
                        <tr>
                            <th class="text-center py-3 px-4" style="min-width: 400px;">Product Name &amp; Details</th>
                            <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
                            <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
                            <th class="text-right py-3 px-4" style="width: 100px;">Total</th>
                            <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPrice = 0;
                        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $product) {
                        ?>
                                <tr>
                                    <td class="p-4">
                                        <div class="media align-items-center">
                                            <div class="cart_item_image">
                                                <?php if (isset($product['image'])) : ?>
                                                    <img src="<?php echo $product['image']; ?>" alt="" width="80" height="80">
                                                <?php endif; ?>
                                            </div>
                                            <div class="media-body">
                                                <a href="#" class="d-block text-dark"><?php echo $product['name']; ?></a>
                                                <small>
                                                    <span class="text-muted">Description: </span> <?php echo $product['description']; ?>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right font-weight-semibold align-middle p-4">$<?php echo number_format($product['price'], 2); ?></td>
                                    <td class="align-middle p-4">
                                    <td class="align-middle p-4">
    <input type="number" class="form-control quantity-input" id="quantity-<?php echo $product['id']; ?>" value="<?php echo $product['quantity']; ?>" data-product-id="<?php echo $product['id']; ?>" onchange="updateQuantity(this)">
</td>                                    </td>
<td class="text-right font-weight-semibold align-middle p-4" id="total-price_2-<?php echo $product['id']; ?>">
    $<?php echo number_format($product['price'] * $product['quantity'], 2); ?>
</td>
                                    <td class="text-center align-middle px-0"> <a href="/sang5/cart/removefromcart?id=<?php echo $product['id']; ?>" class="shop-tooltip close float-none text-danger" title="Remove" data-original-title="Remove">×</a>
                                    </td>
                                </tr>
                            <?php
                                $totalPrice += $product['price'] * $product['quantity'];
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" class="text-center">Your cart is empty</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="text-right mt-4">
                <label class="text-muted font-weight-normal m-0">Total price</label>
                <div class="text-large" id="total-price"><strong>$<?php echo number_format($totalPrice, 2); ?></strong></div>
            </div>
        </div>
    </div>
</div>
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<>
<script>
    function updateQuantity(input) {
        var productId = input.getAttribute('data-product-id');
        var newQuantity = input.value;

        $.ajax({
            url: '/sang5/cart/updatequantity',
            method: 'POST',
            data: { id: productId, quantity: newQuantity },
            success: function(response) {
                console.log(response.totalPrice);
                $('#total-price strong').text('$' + response.totalPrice.toFixed(2));
                var totalPrice = parseFloat(<?php echo $product['price']; ?>) * parseInt(newQuantity);
        $('#total-price-<?php echo $product['id']; ?>').text('$' + totalPrice.toFixed(2));
            },
            error: function(xhr, status, error) {
                // Handle errors if any
                console.error(xhr.responseText);
            }
        });
    }
</script>

<?php
include_once 'app/views/share/footer.php';
?>