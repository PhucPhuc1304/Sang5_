<?php
class ProductController{

    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function Index() {

        $stmt = $this->productModel->readAll();

        include_once 'app/views/product/list.php';

    }

    public function add(){
        include_once 'app/views/product/add.php';
    }

    //phương thức lưu hình ảnh
    public function uploadImage($file) {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        // Kiểm tra xem file có phải là hình ảnh thực sự hay không
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    
        // Kiểm tra kích thước file
        if ($file["size"] > 500000) { // Ví dụ: giới hạn 500KB
            $uploadOk = 0;
        }
    
        // Kiểm tra định dạng file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }
    
        // Kiểm tra nếu $uploadOk bằng 0
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                return false;
            }
        }
    }

    public function save(){
        // Kiểm tra xem liệu form đã được submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';

            if(isset($_POST['id'])){
                //update
                $id = $_POST['id'];                
            }

            $uploadResult = false;
            //kiểm tra để lưu hình ảnh
            if(!empty($_FILES["image"]['size'])){
                //luu hinh
                $uploadResult = $this->uploadImage($_FILES["image"]);
            }

            //lưu sản phẩm
            if(!isset($id))
                $result = $this->productModel->createProduct($name, $description, $price, $uploadResult);
            else
                $result = $this->productModel->updateProduct($id, $name, $description, $price, $uploadResult);

            if (is_array($result)) {
                // Có lỗi, hiển thị lại form với thông báo lỗi
                $errors = $result;
                include 'app/views/product/add.php';
            } else {
                // Không có lỗi, chuyển hướng ve trang chu hoac trang danh sach
                header('Location: /sang5');
            }
        }
    }

    public function edit($id){
        
        $product = $this->productModel->getProductById($id);

        if(!empty($product)){
            include_once 'app/views/product/edit.php';
        }else{
            include_once 'app/views/share/not-found.php';
        }
    }
}