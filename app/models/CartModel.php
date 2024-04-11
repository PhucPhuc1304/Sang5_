<?php

class CartModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addToCart($product_id)
    {
        // Fetch product details from the database
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the product already exists in the cart
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $product_id) {
                    // If the product exists, increment its quantity and update the total
                    $item['quantity']++;
                    $item['total'] += $product['price'];
                    return; // Exit the method
                }
            }
        }

        // If the product doesn't exist, add it to the cart
        $_SESSION['cart'][] = array(
            'id' => $product_id,
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'image' => $product['image'], // Add image URL
            'quantity' => 1, // Initial quantity is 1
            'total' => $product['price'] // Initial total is the product price
        );
    }

    public function removeFromCart($product_id)
    {
        // Check if the cart session exists and is not empty
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Iterate through the cart items
            foreach ($_SESSION['cart'] as $key => $product) {
                // If the product ID matches, remove it from the cart
                if ($product['id'] == $product_id) {
                    unset($_SESSION['cart'][$key]);
                    return; // Exit the method after removing the product
                }
            }
        }
    }
    
}

?>
