<?php
require_once 'app/models/CartModel.php';

class CartController {
  
    private $cartModel;
    private $db;
    
    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->cartModel = new CartModel($this->db);
    }

    public function Index() {
        include_once 'app/views/cart/index.php';
    }

    public function addtocart() {
        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];
            $this->cartModel->addToCart($product_id);
            header('Location: /sang5'); // Redirect to the cart page
            exit;
        } else {
           echo "Error";
        }
    }

    public function removeFromCart() {
        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];
            $this->cartModel->removeFromCart($product_id);
            header('Location: /sang5/cart'); // Redirect back to the cart page
            exit;
        } else {
           echo "Error";
        }
    }
    public function updatequantity() {
        if (isset($_POST['id']) && isset($_POST['quantity'])) {
            $product_id = $_POST['id'];
            $new_quantity = $_POST['quantity'];
    
            // Update the quantity in the cart session
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as &$product) {
                    if ($product['id'] == $product_id) {
                        $product['quantity'] = $new_quantity;
                        // Recalculate total price
                        $totalPrice = 0;
                        foreach ($_SESSION['cart'] as $item) {
                            $totalPrice += $item['price'] * $item['quantity'];
                        }
                        // Return updated total price
                        echo json_encode(['totalPrice' => $totalPrice]);
                        return;
                    }
                }
            }
        }
        // Return error response if parameters are missing or product not found
        http_response_code(400);
        echo "Error: Unable to update quantity.";
    }
    

    
}
?>
