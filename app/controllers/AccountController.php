<?php
class AccountController{
    
    private $db;
    private $accountModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    function register(){
        include_once 'app/views/account/register.php';
    }

    function login(){
        include_once 'app/views/account/login.php';
    }

    function checkLogin(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = $this->accountModel->getAccountByEmail($email);

            if(is_array($result)){
                $errors = $result;
                include_once 'app/views/account/login.php';
            }
            else if(password_verify($password, $result->password)) {
               //đăng nhập thành công
               session_start();
               $_SESSION['user_role'] = empty($result->role) ? 'user' : $result->role;
               $_SESSION['username'] = $email;

               header('Location: /sang5');
            }
            else{
                $errors = [];
                $errors['password'] = "Sai mật khẩu!";
                include_once 'app/views/account/login.php';
            }
        }
    }

    function save(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $firtName = $_POST['firstname'] ?? '';
            $lastName = $_POST['lastname'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';
            
            if(empty($pasword)){
                $errors = [];
                $errors['password'] = "vui long nhap mat khau!";
                include_once 'app/views/account/register.php';
            }

            $result = $this->accountModel->save($firtName, $lastName, $email, $password, $confirmPassword);
            
            if (is_array($result)){
                $errors = $result;
                include_once 'app/views/account/register.php';
            }else{
                //lưu session
                session_start();
                $_SESSION['user_role'] = 'user';
                $_SESSION['username'] = $email;
                header('Location: /sang5');
            }
        }
    }
}