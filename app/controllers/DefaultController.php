<?php
class DefaultController{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    public function Index() {

        // if (!SessionHelper::isLoggedIn()) {
        //      header('Location: /sang5/account/login');
        //      exit;
        // }
        
        $products = $this->productModel->readAll();

        include_once 'app/views/share/index.php';
    }
}