<?php

$params = $_REQUEST;
$errors = array();

if (isset($params['add_product'])){
    $res = $product->add($params);

    if ($res['status']){
        $success_add = true;
    } else {
        $errors = $res['errors'];
    }
}

if (isset($_REQUEST['product_id']) && !isset($_REQUEST['update_product'])){
    $product_data = $product->get(array("id" => $_REQUEST['product_id']), 0, 1);
    if (!empty($product_data)){
        $params = $product_data;
        $product_id = $_REQUEST['product_id'];
        $update = true;
    }
} elseif (isset($_REQUEST['product_id']) && isset($_REQUEST['update_product'])){
    $res = $product->update($_REQUEST['product_id'], $params);

    if ($res['status']){
        $success_update = true;
    } else {
        $errors = $res['errors'];
    }
}

?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i> Dashboard</li>
            <li class="active">New product</li>
        </ol>
    </div>
</div>

<div class="panel panel-green">
    <?php if (isset($update) && $update){ ?>
        <div class="panel-heading">Edit Product</div>
    <?php } else { ?>
        <div class="panel-heading">Add new Product</div>
    <?php } ?>
    
    <div class="panel-body">

        <div class="row">
            <div class="col-lg-12">
                <?php
                    if (isset($success_add) && $success_add){
                        $admin_helper->success("Product added successfully");
                    }

                    if (isset($success_update) && $success_update){
                        $admin_helper->success("Product updated successfully");
                    }

                    if (!count($product->schema['category_id']['options'])){
                        $admin_helper->error("You can't add products until you added at least on category. <a href=\"index.php?menu=products_categories\">Click here to add one</a>");
                    }

                    if (isset($update) && $update){ 
                        $buttons = "<input type=\"hidden\" name=\"menu\" value=\"products_new\" />
                                    <input type=\"hidden\" name=\"product_id\" value=\"{$_REQUEST['product_id']}\" />
                                    <input type=\"submit\" class=\"btn btn-primary\" name=\"update_product\" value=\"Update product\" />";
                    } else {
                        $buttons = "<input type=\"hidden\" name=\"menu\" value=\"products_new\" />
                                    <input type=\"submit\" class=\"btn btn-primary\" name=\"add_product\" value=\"Add product\" />";
                    }


                    $admin_helper->renderForm($product, 
                                              array("thumbnail", "title", "category_id", "description_short", "description_long", "price", "recurring"), 
                                              "form-horizontal",
                                              $buttons,
                                              $params,
                                              $errors,
                                              "");
                ?>

            </div>
        </div>
    </div>
</div>