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
require 'header.php';
require 'sidebar.php';
require '../config.php';
require 'function.php';

$msg = "";

if (isset($_POST['addColor'])) {
    $pid = isset($_POST['pid'])?$_POST['pid']:"";
    $color = isset($_POST['color'])?$_POST['color']:"";
    $qty = isset($_POST['qty'])?$_POST['qty']:"";

    $addColorQty = array("pid"=>$pid, "color"=>$color, "qty"=>$qty); 
    $msg = colorQty($addColorQty);
}

if (isset($_POST['deleteTag'])) {
    $id = $_POST['tid'];
    $msg = deleteColor($id);
}
?>
<div id="main-content">
     <!-- Main Content Section with everything -->
     <noscript> 
         <!-- Show a notification if the user has disabled javascript -->
            <div class="notification error png_bg">
            <div>
            Javascript is disabled or is not supported by your browser.
            Please <a href="http://browsehappy.com/" 
            title="Upgrade to a better browser">upgrade</a> 
            your browser or 
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
                <h3>Manage Colors</h3>
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
                                <th>Product Id</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Action</th>
                                <!-- <th>Column 3</th>
                                <th>Column 4</th>
                                <th>Column 5</th> -->
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
                        $data = fetchColor();
                        foreach ($data as $row) :
                            ?>
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td><?php echo $row['product_id'] ?></td>
                                <td><a href="#" title="title">
                                    <?php echo ucfirst($row['color']) ?>
                                </a></td>
                                <td><?php echo $row['quantity'] ?></td>
                                <td>
                                    <!-- Icons -->
                                    <a href="editColor.php?id=<?php echo $row['id'] ?>" title="Edit"><img 
                                    src="resources/images/icons/pencil.png" 
                                    alt="Edit" /></a>
                                    <form action="colors.php" method="post"
                                    style="display: inline">
                                        <input type="hidden" name="tid"
                                        value="<?php echo $row['id'] ?>">
                                        <button type="submit"
                                        style="border:none; background: transparent;
                                        cursor: pointer" name="deleteTag">
                                    <img src="resources/images/icons/cross.png" 
                                    alt="Delete" />
                                        </button>
                                    </form>
                                    <!-- <a href="#" title="Edit Meta"><img 
                        src="resources/images/icons/hammer_screwdriver.png" 
                                    alt="Edit Meta" /></a> -->
                                </td>
                            </tr>
                        <?php endforeach; ?> 
                        </tbody>
                    </table>
                </div> 
                <!-- End #tab1 -->
                <div class="tab-content" id="tab2">
                    <form action="colors.php" method="post">
                        <fieldset> 
                        <!-- Set class to "column-left" or "column-right" 
                        on fieldsets to divide the form into columns -->
                        <p>
                            <label>Product Id</label>
                            <!-- <input class="text-input small-input" type="text" 
                            id="small-input" name="pid" required />  -->
                            <!-- <span class="input-notification success png_bg">
                            Successful message</span>  -->
                            <!-- Classes for input-notification: success, 
                            error, information, attention -->
                            <!-- <br /><small>A small description of the field
                            </small> -->
                            <select name="pid" class="small-input">
                            <?php
                            $data = fetchProduct();
                            foreach ($data as $row) :
                                ?>
                                <option value="<?php echo $row['product_id'] ?>">
                                <?php echo $row['product_id'] ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </p>
                        <p>
                            <label>Color</label>
                            <input class="text-input small-input" type="text" 
                            id="small-input" name="color" required />
                        </p>
                        <p>
                            <label>Quantity</label>
                            <input class="text-input small-input" type="text" 
                            id="small-input" name="qty" required />
                        </p>
                        
                        <p>
                            <input class="button" type="submit" name="addColor"
                            value="Submit" />
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
