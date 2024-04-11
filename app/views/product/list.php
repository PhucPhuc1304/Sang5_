<?php
include_once 'app/views/share/header.php'
?>

<div class="container mt-4">
        <div class="row">
            <!-- Danh sách sản phẩm -->
            <div class="col-md-9">
                <!-- Hiển thị sản phẩm bằng dạng dòng sản phẩm sử dụng Bootstrap Row và Col -->
                <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col">
                        <div class="card">
                            <img src="https://picsum.photos/id/684/600/400" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?=$row['name']?></h5>
                                <p class="card-text"><?=$row['description']?></p>
                                <p class="card-text">Giá: <?=$row['price']?></p>
                                <a href="#" class="btn btn-primary">Mua Ngay</a>
                            </div>
                        </div>                
                    </div>
                <?php endwhile; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="bg-primary text-white p-3">
                    <h5>Social Media</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php
include_once 'app/views/share/footer.php';
?>