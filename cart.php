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
session_start();
require 'config.php';

if (isset($_POST['update'])) {
    $pid = $_POST['pid'];
    $qty = $_POST['qty'];
    if ($qty != 0) {
        foreach ($_SESSION['cartData'] as $key => $value) {
            if ($pid == $value['pid']) {
                $_SESSION['cartData'][$key]['qty'] = $qty;
            }
        } 
    }
}

if (isset($_GET['id']) && $_GET['id'] != "") {
    $pid = $_GET['id'];
    foreach ($_SESSION['cartData'] as $key => $value) {
        if ($pid == $value['pid']) {
            unset($_SESSION['cartData'][$key]);
        }
    }
}
$totalPrice = 0;


if (!empty($_SESSION['cartData'])) {

    if (isset($_GET['order'])) {
        // echo $_GET['order'];
        if ($_GET['order'] == 'add') {
            foreach ($_SESSION['cartData'] as $key => $value) {
                $pid = $value['pid'];
                $pname = $value['name'];
                $total = $value['qty']*$value['price'];

                $datatime = date('y-m-d');
                $sql = "INSERT INTO `orders` (`product_id`, `cartdata`, `total`, `status`
                , `datetime`) VALUES ('$pid', '$pname', '$total', '1', '$datatime')";
                if (mysqli_query($conn, $sql)) {
                    unset($_SESSION['cartData']);
                    echo "<script>alert('Order Added Successfully!')</script>";
                    ?>
<script>window.location.href='product.php'</script>
                    <?php
                }
            }

        }
    }
} 
require 'header.php';
?>



 <!-- Cart view section -->
 <section id="cart-view">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="cart-view-area">
           <div class="cart-view-table">
             <!-- <form action=""> -->
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if (!empty($_SESSION['cartData'])) {
                        foreach ($_SESSION['cartData'] as $key=>$value) :
                            ?>
                      <tr>
                        <td><a class="remove" href="cart.php?id=<?php echo $value['pid']; ?>">
                        <fa class="fa fa-close"></fa></a></td>
                        <td><a href="#">
                        <img src="admin/productImage/<?php echo $value['image'] ?>" alt="img">
                        </a></td>
                        <td><a class="aa-cart-title" href="#">
                            <?php echo $value['name']; ?>
                        </a></td>
                        <td>$<?php echo $value['price'] ?></td>
                        <td>
                        <form action="cart.php" method="post">
                        <input class="aa-cart-quantity" type="number" 
                        value="<?php echo $value['qty'] ?>" name="qty">
                        <input type="hidden" name="pid" value="<?php echo $value['pid'] ?>">
                        <input class="aa-cartbox-checkout aa-primary-btn" name="update"
                           type="submit" value="Update Cart">
                          </form>
                        </td>
                        <td>$<?php echo $value['qty']*$value['price'] ?></td>
                      </tr>
                        <?php endforeach; 
                    } else {
                        if (!empty($_SESSION['cartData'])) {
                            $totalPrice += ($value['price']*$value['qty']); 
                        }
                        echo "<span style='color:red; font-weight:700'>Empty Cart</span>";
                    }
                    ?>
                      <tr>
                        <td colspan="6" class="aa-cart-view-bottom">
                          <a href="product.php" style="float:left;"
                           class="aa-cart-view-btn">Continue Shopping</a>
                          <div class="aa-cart-coupon" style="float:right;">
                            <input class="aa-coupon-code" type="text" placeholder="Coupon">
                            <input class="aa-cart-view-btn" type="submit" value="Apply Coupon">
                          </div>
                        </td>
                      </tr>
                      </tbody>
                  </table>
                </div>
             <!-- </form> -->
             <!-- Cart Total view -->
             <div class="cart-view-total">
               <h4>Cart Totals</h4>
               <table class="aa-totals-table">
                 <tbody>
                   <tr>
                     <th>Subtotal</th>
                     <td>$<?php echo $totalPrice; ?></td>
                   </tr>
                   <tr>
                     <th>Total</th>
                     <td>$<?php echo $totalPrice; ?></td>
                   </tr>
                 </tbody>
               </table>
               <a href="cart.php?order=add" class="aa-cart-view-btn">Proced to Checkout</a>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->


  <!-- Subscribe section -->
  <section id="aa-subscribe">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-subscribe-area">
            <h3>Subscribe our newsletter </h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, velit!</p>
            <form action="" class="aa-subscribe-form">
              <input type="email" name="" id="" placeholder="Enter your Email">
              <input type="submit" value="Subscribe">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Subscribe section -->

  <!-- footer -->  
  <footer id="aa-footer">
    <!-- footer bottom -->
    <div class="aa-footer-top">
     <div class="container">
        <div class="row">
        <div class="col-md-12">
          <div class="aa-footer-top-area">
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <h3>Main Menu</h3>
                  <ul class="aa-footer-nav">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Our Products</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <div class="aa-footer-widget">
                    <h3>Knowledge Base</h3>
                    <ul class="aa-footer-nav">
                      <li><a href="#">Delivery</a></li>
                      <li><a href="#">Returns</a></li>
                      <li><a href="#">Services</a></li>
                      <li><a href="#">Discount</a></li>
                      <li><a href="#">Special Offer</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <div class="aa-footer-widget">
                    <h3>Useful Links</h3>
                    <ul class="aa-footer-nav">
                      <li><a href="#">Site Map</a></li>
                      <li><a href="#">Search</a></li>
                      <li><a href="#">Advanced Search</a></li>
                      <li><a href="#">Suppliers</a></li>
                      <li><a href="#">FAQ</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="aa-footer-widget">
                  <div class="aa-footer-widget">
                    <h3>Contact Us</h3>
                    <address>
                      <p> 25 Astor Pl, NY 10003, USA</p>
                      <p><span class="fa fa-phone"></span>+1 212-982-4589</p>
                      <p><span class="fa fa-envelope"></span>dailyshop@gmail.com</p>
                    </address>
                    <div class="aa-footer-social">
                      <a href="#"><span class="fa fa-facebook"></span></a>
                      <a href="#"><span class="fa fa-twitter"></span></a>
                      <a href="#"><span class="fa fa-google-plus"></span></a>
                      <a href="#"><span class="fa fa-youtube"></span></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     </div>
    </div>
    <!-- footer-bottom -->
    <div class="aa-footer-bottom">
      <div class="container">
        <div class="row">
        <div class="col-md-12">
          <div class="aa-footer-bottom-area">
            <p>Designed by <a href="http://www.markups.io/">MarkUps.io</a></p>
            <div class="aa-footer-payment">
              <span class="fa fa-cc-mastercard"></span>
              <span class="fa fa-cc-visa"></span>
              <span class="fa fa-paypal"></span>
              <span class="fa fa-cc-discover"></span>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </footer>
  <!-- / footer -->
  <!-- Login Modal -->  
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">                      
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4>Login or Register</h4>
          <form class="aa-login-form" action="">
            <label for="">Username or Email address<span>*</span></label>
            <input type="text" placeholder="Username or email">
            <label for="">Password<span>*</span></label>
            <input type="password" placeholder="Password">
            <button class="aa-browse-btn" type="submit">Login</button>
            <label for="rememberme" class="rememberme"><input type="checkbox" id="rememberme"> Remember me </label>
            <p class="aa-lost-password"><a href="#">Lost your password?</a></p>
            <div class="aa-register-now">
              Don't have an account?<a href="account.html">Register now!</a>
            </div>
          </form>
        </div>                        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>


    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>  
    <!-- SmartMenus jQuery plugin -->
    <script type="text/javascript" src="js/jquery.smartmenus.js"></script>
    <!-- SmartMenus jQuery Bootstrap Addon -->
    <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>  
    <!-- To Slider JS -->
    <script src="js/sequence.js"></script>
    <script src="js/sequence-theme.modern-slide-in.js"></script>  
    <!-- Product view slider -->
    <script type="text/javascript" src="js/jquery.simpleGallery.js"></script>
    <script type="text/javascript" src="js/jquery.simpleLens.js"></script>
    <!-- slick slider -->
    <script type="text/javascript" src="js/slick.js"></script>
    <!-- Price picker slider -->
    <script type="text/javascript" src="js/nouislider.js"></script>
    <!-- Custom js -->
    <script src="js/custom.js"></script> 

  </body>
</html>