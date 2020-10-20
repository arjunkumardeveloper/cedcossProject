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
if (isset($_POST['updateColor'])) {
    $color = isset($_POST['color'])?$_POST['color']:"";
    $qty = isset($_POST['qty'])?$_POST['qty']:"";
    
    $id = $_POST['pid'];
    
    $msg = updateColor($color, $qty, $id);
    if ($msg) {
        header('location: colors.php');
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
<a href="http://browsehappy.com/" title="Upgrade to a better browser">
upgrade</a> your browser or 
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
                    $row = fetchSpecificColor($id);
                ?>
                <div class="tab-content default-tab" id="tab2">
                    <form action="editColor.php" method="post">
                    <input type="hidden" name="pid" 
                    value="<?php echo $row['id'] ?>">
                        <fieldset> 
                        <!-- Set class to "column-left" or "column-right" 
                        on fieldsets to divide the form into columns -->
                        <p>
                            <label>Color</label>
                            <input class="text-input small-input" type="text" 
                            id="small-input" name="color" 
                            value="<?php echo $row['color'] ?>" required /> 
                            <!-- <span class="input-notification success png_bg">
                            Successful message</span>  -->
                            <!-- Classes for input-notification: success, 
                            error, information, attention -->
                            <!-- <br /><small>A small description of the field
                            </small> -->
                        </p>
                        <p>
                            <label>Quantity</label>
                            <input class="text-input small-input" type="text" 
                            id="small-input" name="qty" 
                            value="<?php echo $row['quantity'] ?>" required /> 
                        </p>
                        <p>
                            <input class="button" type="submit" value="Update"
                            name="updateColor" />
                            <a href="colors.php" class="button">Back</a>
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
