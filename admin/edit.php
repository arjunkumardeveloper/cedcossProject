<?php
/**
 * The file doc comment
 * php version 7.2.10
 * 
 * @category Class
 * @package  Package
 * @author   Original Author <author@example.com>
 * @license  https://www.cedcoss.com cedcoss 
 * @link     link
 */
ob_start();
require '../config.php';
require 'header.php';
require 'sidebar.php';
require 'function.php';

$msg = '';
if (isset($_POST['updateProduct'])) {
    $categoryid = isset($_POST['pcate'])?$_POST['pcate']:"";
    $name = isset($_POST['name'])?$_POST['name']:"";
    $price = isset($_POST['price'])?$_POST['price']:"";
    $shortdesc = isset($_POST['shortdesc'])?$_POST['shortdesc']:"";
    $longdesc = isset($_POST['longdesc'])?$_POST['longdesc']:"";
    $id = $_POST['pid'];
    $image = $_FILES['image']['name'];
    $description = $_FILES['image']['tmp_name'];

    if ($image != "") {
        if (move_uploaded_file($description, "productImage/".$image)) {
            $editProduct = array("cid"=>$categoryid, "name"=>$name, "price"=>$price, 
            "sdesc"=>$shortdesc, "ldesc"=>$longdesc, "image"=>$image);
            // echo "<pre>";
            // print_r($editProduct);
            // echo "</pre>";
            // exit();
            $msg = updateProduct($editProduct, $id);
            if ($msg) {
                header('location: products.php');
            }
        } else {
            echo "<script>alert('Image Not Upload !')</script>";
        }
    } else {
        $editProduct = array("cid"=>$categoryid, "name"=>$name, "price"=>$price, 
            "sdesc"=>$shortdesc, "ldesc"=>$longdesc);

        $msg = updateProduct($editProduct, $id);
        if ($msg) {
            header('location: products.php');
        }
    }

    
}
?>
<div id="main-content">
     <!-- Main Content Section with everything -->
     <noscript> 
         <!-- Show a notification if the user has disabled javascript -->
            <div class="notification error png_bg">
                <div>
                    Javascript is disabled or is not supported by your browser.
                    Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                </div>
            </div>
        </noscript>
        <!-- Page Head -->
        <h2>Welcome John</h2>
        <p id="page-intro">What would you like to do?</p>
        <div class="clear"></div> 
        <!-- End .clear -->
        <div class="content-box">
            <!-- Start Content Box -->
            <div class="content-box-header">
                <h3>Products</h3>
                <ul class="content-box-tabs">
                    <!-- <li><a href="#tab1">Manage</a></li>  -->
                    <!-- href must be unique and match the id of target div -->
                    <li><a href="#tab2" class="default-tab">Add</a></li>
                </ul>
                <div class="clear"></div>
            </div> <!-- End .content-box-header -->
            <div class="content-box-content">
                
               <?php
                    $id = $_GET['id'];
                    // echo $id;
                    $row = fetchSpecificProduct($id);
                ?>
                <div class="tab-content default-tab" id="tab2">
                    <form action="edit.php" method="post" 
                    enctype="multipart/form-data">
                    <input type="hidden" name="pid" 
                    value="<?php echo $row['id'] ?>">
                        <fieldset> 
                        <!-- Set class to "column-left" or "column-right" 
                        on fieldsets to divide the form into columns -->
                        <p>
                            <label>Product Category</label>
                            <select class="small-input" name="pcate" id="">
                            <?php 
                            $data = fetchCateg();
                            foreach ($data as $catdata) :
                                
                                ?>
                            <option 
                            value="<?php echo $catdata['category_id'] ?>" 
                                <?php
                                if ($row['category_id'] == $catdata['category_id']) { 
                                    echo 'selected'; 
                                } 
                                ?>
                            >
                                <?php echo $catdata['name'] ?>
                                </option>
                            <?php endforeach; ?>
                                 <?php // exit(); ?>
                            </select>
                        </p>
                        
                        <p>
                            <label>Product Name</label>
                            <input class="text-input small-input" type="text" 
                            id="small-input" name="name" 
                            value="<?php echo $row['name'] ?>" required /> 
                            <!-- <span class="input-notification success png_bg">
                            Successful message</span>  -->
                            <!-- Classes for input-notification: success, 
                            error, information, attention -->
                            <!-- <br /><small>A small description of the field
                            </small> -->
                        </p>
                        <p>
                            <label>Product Price</label>
                            <input type="text" class="text-input small-input"
                            name="price" id="price"
                            value="<?php echo $row['price'] ?>" required>
                        </p>
                        <p>
                            <label>Product Image</label>
                            <input type="image" 
                            src="productImage/<?php echo $row['image'] ?>" 
                            alt="" class="text-input small-input"><br>
                            <input type="file" name="image" id="image"
                            class="text-input small-input">
                        </p>
                        <p>
                            <label>Short Description</label>
                            <input class="text-input large-input datepicker" 
                            type="text" id="medium-input" name="shortdesc"
                            value="<?php echo $row['short_desc'] ?>"
                            required /> 
                            <!-- <span class="input-notification error png_bg">
                            Error message</span> -->
                        </p>
                        <p>
                            <label>Long Description</label>
                            <textarea class="text-input textarea wysiwyg" 
                            id="textarea" name="longdesc" cols="79" rows="15">
                            <?php echo $row['long_desc'] ?>
                            </textarea>
                        </p>
                        
                        <p>
                            <input class="button" type="submit" value="Update"
                            name="updateProduct" />
                            <a href="products.php" class="button">Back</a>
                        </p>
                    </fieldset>
                    <div class="clear"></div>
                    <!-- End .clear -->
                </form>
            </div> 
            <!-- End #tab2 -->
        </div> 
        <!-- End .content-box-content -->
    </div> 
    
<?php
require 'footer.php';
?>
