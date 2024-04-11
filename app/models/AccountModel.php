<?php
class AccountModel{
    private $conn;
    private $table_name = "account";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function save($firsName, $lastName, $email, $password, $confirmPassword){
        $errors=[];
        if(empty($firsName)){
            $errors['firstname']="Vui lòng nhập Tên!";
        }
        if(empty($lastName)){
            $errors['lastname']="Vui lòng nhập Họ!";
        }
        if(empty($email)){
            $errors['email']="Vui lòng nhập Email!";
        }
        if(empty($password)){
            $errors['password'] = "Vui lòng nhập mật khẩu";
        }
        if($password!=$confirmPassword){
            $errors['confirmpass'] = "Mật khẩu và xác nhận mật khẩu phải giống nhau!";
        }
        
        //kiểm tra email đã tồn tại chưa
        $result = $this->getAccountByEmail($email);

        if($result){
            $errors['account'] = "Email Tài khoản đã tồn tại!";
        }
        if(count($errors)>0){
            return $errors;
        }

        // Mã hóa mật khẩu
        $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        $query = "INSERT INTO " . $this->table_name . " (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $firsName = htmlspecialchars(strip_tags($firsName));
        $lastName = htmlspecialchars(strip_tags($lastName));
        $email = htmlspecialchars(strip_tags($email));

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':firstname', $firsName);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getAccountByEmail($email)
    {
        $errors = [];
        if(empty($email)){
            $errors['email'] = "Vui long nhap email!";
        }
      
        if(count($errors)>0){
            return $errors;
        }

        $query = "SELECT * FROM " . $this->table_name . " where email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
}