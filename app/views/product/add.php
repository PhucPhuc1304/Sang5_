<?php
include_once 'app/views/share/header.php';
?>

    <?php 
        if(isset($errors)){
            echo "<ul>";
            foreach ($errors as $err) {
                echo "<li>".$err."</li>";
            }
            echo "</ul>";
        }
    ?>

<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Create Product</h1>
    </div>
    <form class="user" action="/sang5/product/save" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <input type="text" class="form-control form-control-user" id="name" placeholder="Product Name" name="name">
        </div>

        <div class="form-group">
            <input type="text" class="form-control form-control-user" id="description" placeholder="Description" name="description">
        </div>
        <div class="form-group">
            <input type="number" class="form-control form-control-user" id="Price" placeholder="Price" name="price">
        </div>

        <div class="form-group">
            <input type="file" class="form-control form-control-user" id="image" placeholder="image" name="image">
        </div>

        <button class="btn btn-primary btn-user btn-block">
            Add Product
        </button>
    
    </form>

</div>

<?php
include_once 'app/views/share/footer.php';
?>