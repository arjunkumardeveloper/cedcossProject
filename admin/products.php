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
require '../config.php';
require 'header.php';
require 'sidebar.php';
require 'function.php';

$msg = '';
if (isset($_POST['addProduct'])) {

    $pid = isset($_POST['pid'])?$_POST['pid']:"";
    $cid = isset($_POST['cid'])?$_POST['cid']:"";
    $name = isset($_POST['name'])?$_POST['name']:"";
    $price = isset($_POST['price'])?$_POST['price']:"";
    $shortdesc = isset($_POST['shortdesc'])?$_POST['shortdesc']:"";
    $longdesc = isset($_POST['longdesc'])?$_POST['longdesc']:"";
    $tags = implode(",", $_POST['fashion']);
    $color = implode(",", $_POST['color']);
    
    $image = $_FILES['image']['name'];
    $description = $_FILES['image']['tmp_name'];

    if (move_uploaded_file($description, 'productImage/'.$image)) {   
        
        $insertProduct = array("pid"=>$pid, "cid"=>$cid, "name"=>$name,
        "price"=>$price, "sdesc"=>$shortdesc, "ldesc"=>$longdesc,
        "image"=>$image, "tags"=>$tags, "color"=>$color);
        
        $msg = addProduct($insertProduct);
    }
}


if (isset($_GET['type']) && $_GET['type'] != "") {
    $type = $_GET['type'];
    if ($type == 'status') {
        $operation = $_GET['operation'];
        $id = $_GET['id'];
        if ($operation == 'active') {
            $status = 1;
        } else {
            $status = 0;
        }
        $sql = "UPDATE products SET `status` = '$status' WHERE id = '$id' ";
        // echo $sql;
        mysqli_query($conn, $sql);
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
                    Please 
<a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade
</a> your browser or 
<a href="http://www.google.com/support/bin/answer.py?answer=23852" 
title="Enable Javascript in your browser">enable</a> 
Javascript to navigate the interface properly.
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
                <h3>Manage Products</h3>
                <ul class="content-box-tabs">
                    <li><a href="#tab1" class="default-tab">Manage</a></li> 
                    <!-- href must be unique and match the id of target div -->
                    <li><a href="#tab2">Add</a></li>
                </ul>
                <div class="clear"></div>
            </div> <!-- End .content-box-header -->
            <div class="content-box-content">
                <div class="tab-content default-tab" id="tab1"> 
                    <!-- This is the target div. id must match the href of this
                    div's tab -->
                    <?php if ($msg) : ?>
                        <div class="notification success png_bg">
                    <a href="#" class="close">
                    <img src="resources/images/icons/cross_grey_small.png" 
                    title="Close this notification" alt="close" /></a>
                    <div>
                        <?php echo $msg; ?>
                    </div>
                    </div>
                    <?php endif; ?>
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <input class="check-all" type="checkbox" />
                                </th>
                                <th>Sr.No.</th>
                                <th>Product Id</th>
                                <th>Category Id</th>
                                <th>Tags</th>
                                <th>Colors</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Short Description</th>
                                <th>Long Description</th>
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="bulk-actions align-left">
                                        <select name="dropdown">
                                            <option value="option1">Choose an
                                            action...</option>
                                            <option value="option2">Edit</option>
                                            <option value="option3">Delete</option>
                                        </select>
                                        <a class="button" href="#">Apply to selected
                                        </a>
                                    </div>
                                    <div class="pagination">
                                        <a href="#" title="First Page">&laquo; First
                                        </a>
                                        <a href="#" title="Previous Page">&laquo; 
                                        Previous</a>
                                        <a href="#" class="number" title="1">1</a>
                                        <a href="#" class="number" title="2">2</a>
                                        <a href="#" class="number current" title="3">
                                        3</a>
                                        <a href="#" class="number" title="4">4</a>
                                        <a href="#" title="Next Page">Next &raquo;
                                        </a>
                                        <a href="#" title="Last Page">Last &raquo;
                                        </a>
                                    </div> 
                                    <!-- End .pagination -->
                                    <div class="clear"></div>
                                </td>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php 
                        $data = fetchProduct();
                        $sr = 1;
                        if ($data) :
                            foreach ($data as $row) :
                                ?>
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td><?php echo  $sr++; ?></td>
                                <td><?php echo $row['product_id'] ?></td>
                                <td><?php echo $row['category_id'] ?></td>
                                <td><?php echo $row['tags'] ?></td>
                                <td><?php echo $row['color'] ?></td>
                                <td><a href="#" title="title">
                                <?php echo $row['name'] ?></a>
                                </td>
                                <td>$<?php echo $row['price'] ?></td>
                                <td>
                                <?php if ($row['image']) { ?>
                                <img 
                                src="productImage/<?php echo $row['image'] ?>"
                                alt="image" height="100"
                                width="100">
                                <?php } else { ?>
                                <img 
                                src="productImage/noimage.jpg"
                                alt="image" height="100"
                                width="100">    
                                <?php } ?>
                                </td>
                                <td><?php echo $row['short_desc'] ?></td>
                                <td><?php echo $row['long_desc'] ?></td>
                                <!-- <td>Donec tortor diam</td> -->
                                <td>
                                    <!-- Icons -->
                                    <a href="edit.php?id=<?php echo $row['id'] ?>"
                                     title="Edit"><img 
                                    src="resources/images/icons/pencil.png" 
                                    alt="Edit" /></a>
                            <a href="delete.php?id=<?php echo $row['id'] ?>"
                            title="Delete">
                                <img src="resources/images/icons/cross.png" 
                                    alt="Delete" /></a>
                            <!-- <a href="#"
                            title="Edit Meta">
                        <img src="resources/images/icons/hammer_screwdriver.png" 
                                    alt="Edit Meta" /></a> -->
                                </td>
                                <td>
                                <?php if ($row['status'] == 1) { ?>
                                <a href="products.php?type=status&operation=deactive&id=<?php echo $row['id']; ?>">
                                Sale</a>
                                <?php } else { ?>
                                <a href="products.php?type=status&operation=active&id=<?php echo $row['id']; ?>">
                                Sold Out</a>
                                <?php } ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                            <!-- <tr>
                                <td><input type="checkbox" /></td>
                                <td>Lorem ipsum dolor</td>
                                <td><a href="#" title="title">Sit amet</a></td>
                                <td>Consectetur adipiscing</td>
                                <td>Donec tortor diam</td>
                                <td> -->
                                    <!-- Icons -->
                                    <!-- <a href="#" title="Edit">
                                    <img src="resources/images/icons/pencil.png" 
                                    alt="Edit" /></a>
                                    <a href="#" title="Delete">
                                    <img src="resources/images/icons/cross.png" 
                                    alt="Delete" /></a>
                                    <a href="#" title="Edit Meta">
                        <img src="resources/images/icons/hammer_screwdriver.png" 
                                    alt="Edit Meta" /></a>
                                </td>
                            </tr> -->
                            <!-- <tr>
                                <td><input type="checkbox" /></td>
                                <td>Lorem ipsum dolor</td>
                                <td><a href="#" title="title">Sit amet</a></td>
                                <td>Consectetur adipiscing</td>
                                <td>Donec tortor diam</td>
                                <td> -->
                                    <!-- Icons -->
                                    <!-- <a href="#" title="Edit">
                                    <img src="resources/images/icons/pencil.png" 
                                    alt="Edit" /></a>
                                    <a href="#" title="Delete">
                                    <img src="resources/images/icons/cross.png" 
                                    alt="Delete" /></a>
                                    <a href="#" title="Edit Meta">
                        <img src="resources/images/icons/hammer_screwdriver.png" 
                                    alt="Edit Meta" /></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td>Lorem ipsum dolor</td>
                                <td><a href="#" title="title">Sit amet</a></td>
                                <td>Consectetur adipiscing</td>
                                <td>Donec tortor diam</td>
                                <td> -->
                                    <!-- Icons -->
                                    <!-- <a href="#" title="Edit">
                                    <img src="resources/images/icons/pencil.png" 
                                    alt="Edit" /></a>
                                    <a href="#" title="Delete">
                                    <img src="resources/images/icons/cross.png" 
                                    alt="Delete" /></a>
                                    <a href="#" title="Edit Meta">
                        <img src="resources/images/icons/hammer_screwdriver.png" 
                                    alt="Edit Meta" /></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td>Lorem ipsum dolor</td>
                                <td><a href="#" title="title">Sit amet</a></td>
                                <td>Consectetur adipiscing</td>
                                <td>Donec tortor diam</td>
                                <td> -->
                                    <!-- Icons -->
                                    <!-- <a href="#" title="Edit">
                                    <img src="resources/images/icons/pencil.png" 
                                    alt="Edit" /></a>
                                    <a href="#" title="Delete">
                                    <img src="resources/images/icons/cross.png" 
                                    alt="Delete" /></a>
                                    <a href="#" title="Edit Meta">
                        <img src="resources/images/icons/hammer_screwdriver.png" 
                                    alt="Edit Meta" /></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td>Lorem ipsum dolor</td>
                                <td><a href="#" title="title">Sit amet</a></td>
                                <td>Consectetur adipiscing</td>
                                <td>Donec tortor diam</td>
                                <td> -->
                                    <!-- Icons -->
                                    <!-- <a href="#" title="Edit">
                                    <img src="resources/images/icons/pencil.png" 
                                    alt="Edit" /></a>
                                    <a href="#" title="Delete">
                                    <img src="resources/images/icons/cross.png" 
                                    alt="Delete" /></a>
                                    <a href="#" title="Edit Meta">
                        <img src="resources/images/icons/hammer_screwdriver.png" 
                                    alt="Edit Meta" /></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td>Lorem ipsum dolor</td>
                                <td><a href="#" title="title">Sit amet</a></td>
                                <td>Consectetur adipiscing</td>
                                <td>Donec tortor diam</td>
                                <td> -->
                                    <!-- Icons -->
                                    <!-- <a href="#" title="Edit">
                                    <img src="resources/images/icons/pencil.png" 
                                    alt="Edit" /></a>
                                    <a href="#" title="Delete">
                                    <img src="resources/images/icons/cross.png" 
                                    alt="Delete" /></a>
                                    <a href="#" title="Edit Meta">
                        <img src="resources/images/icons/hammer_screwdriver.png" 
                                    alt="Edit Meta" /></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td>Lorem ipsum dolor</td>
                                <td><a href="#" title="title">Sit amet</a></td>
                                <td>Consectetur adipiscing</td>
                                <td>Donec tortor diam</td>
                                <td> -->
                                    <!-- Icons -->
                                    <!-- <a href="#" title="Edit">
                                    <img src="resources/images/icons/pencil.png" 
                                    alt="Edit" /></a>
                                    <a href="#" title="Delete">
                                    <img src="resources/images/icons/cross.png" 
                                    alt="Delete" /></a>
                                    <a href="#" title="Edit Meta">
                    <img src="resources/images/icons/hammer_screwdriver.png" 
                                    alt="Edit Meta" /></a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div> 
                <!-- End #tab1 -->
                <div class="tab-content" id="tab2">
                    <form action="products.php" method="post" 
                    enctype="multipart/form-data">
                        <fieldset> 
                        <!-- Set class to "column-left" or "column-right" 
                        on fieldsets to divide the form into columns -->
                        <p>
                            <label>Product Id</label>
                            <input class="text-input small-input" type="text" 
                            id="small-input" name="pid" required />
                        </p>
                        <p>
                            <label>Product Category</label>
                            <select name="cid" class="small-input">
                            <?php 
                            $row = fetchCateg();
                            foreach ($row as $data) :
                                ?>
                                <option value="<?php echo $data['category_id'] ?>">
                                <?php echo $data['name'] ?>
                                </option>
                            <?php endforeach; ?> 
                            </select>
                        </p>
                        <p>
                            <label>Product Tags</label> 
                            <?php 
                            $row = fetchTags();
                            foreach ($row as $tag) :
                                ?>
                            <input type="checkbox" name="fashion[]"
                            value="<?php echo $tag['name'] ?>" />
                                <?php echo $tag['name'] ?>
                            <?php endforeach; ?>
                        </p>
                        <p>
                            <label>Product Color</label>
                            <?php
                            $row = fetchColor();
                            foreach ($row as $color) :
                                ?>
                            <input type="checkbox" name="color[]"
                            value="<?php echo $color['color'] ?>" />
                                <?php echo $color['color'] ?>
                            <?php endforeach; ?>
                        </p>
                        <p>
                            <label>Product Name</label>
                            <input class="text-input small-input" type="text" 
                            id="small-input" name="name" required /> 
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
                            name="price" id="price" required>
                        </p>
                        <p>
                            <label>Product Image</label>
                            <input type="file" name="image" id="image"
                            class="text-input small-input">
                        </p>
                        
                        <!-- <p>
                            <label>Tags</label>
                            <input type="checkbox" name="fashion" />Fashion
                            <input type="checkbox" name="ecommerce" />Ecommerce
                            <input type="checkbox" name="shop" />Shop
                            <input type="checkbox" name="handbag" />Hand Bag
                            <input type="checkbox" name="laptop" />Laptop
                            <input type="checkbox" name="headphone" />Headphone
                        </p> -->
                        <p>
                            <label>Short Description</label>
                            <input class="text-input large-input" 
                            type="text" id="large-input" name="shortdesc" 
                            required />
                        </p>
                        <!-- <p>
                            <label>Checkboxes</label>
                            <input type="checkbox" name="checkbox1" /> 
                            This is a checkbox <input type="checkbox" 
                            name="checkbox2" /> 
                            And this is another checkbox
                        </p> -->
                        <!-- <p>
                            <label>Radio buttons</label>
                            <input type="radio" name="radio1" /> 
                            This is a radio button<br />
                            <input type="radio" name="radio2" /> 
                            This is another radio button
                        </p> -->
                        <!-- <p>
                            <label>This is a drop down list</label>
                            <select name="dropdown" class="small-input">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                                <option value="option4">Option 4</option>
                            </select>
                        </p> -->
                        <p>
                            <label>Long Description</label>
                            <textarea class="text-input textarea wysiwyg" 
                            id="textarea" name="longdesc" cols="79" rows="15">
                            </textarea>
                        </p>
                        <p>
                            <input class="button" type="submit" value="Submit"
                            name="addProduct" />
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
    <!-- End .content-box -->
    <!-- Start Notifications -->
    <!-- <div class="notification attention png_bg">
            <a href="#" class="close">
            <img src="resources/images/icons/cross_grey_small.png" 
            title="Close this notification" alt="close" /></a>
        <div>
            Attention notification. Lorem ipsum dolor sit amet, 
            consectetur adipiscing elit. Proin vulputate, sapien 
            quis fermentum luctus, libero.
        </div>
    </div>
    <div class="notification information png_bg">
        <a href="#" class="close">
        <img src="resources/images/icons/cross_grey_small.png" 
        title="Close this notification" alt="close" /></a>
        <div>
            Information notification. Lorem ipsum dolor sit amet, 
            consectetur adipiscing elit. Proin vulputate, sapien 
            quis fermentum luctus, libero.
        </div>
    </div>
    <div class="notification success png_bg">
        <a href="#" class="close">
        <img src="resources/images/icons/cross_grey_small.png" 
        title="Close this notification" alt="close" /></a>
        <div>
            Success notification. Lorem ipsum dolor sit amet, 
            consectetur adipiscing elit. Proin vulputate, sapien 
            quis fermentum luctus, libero.
        </div>
    </div>
    <div class="notification error png_bg">
        <a href="#" class="close">
        <img src="resources/images/icons/cross_grey_small.png" 
        title="Close this notification" alt="close" /></a>
        <div>
            Error notification. Lorem ipsum dolor sit amet, 
            consectetur adipiscing elit. Proin vulputate, sapien 
            quis fermentum luctus, libero.
        </div>
    </div> -->
<!-- End Notifications -->
<?php
require 'footer.php';
?>
