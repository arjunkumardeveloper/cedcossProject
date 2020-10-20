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
require 'function.php';


// if (isset($_GET['pid']) && $_GET['pid'] != "") {
//     $id = $_GET['pid'];
//     // echo $id;
//     $sql = "SELECT * FROM products WHERE `product_id` = '$id' ";
//     $res = mysqli_query($conn, $sql);
//     $row = mysqli_fetch_assoc($res);
//     // print_r($row);

//     $cart = array(
//         $id=>array(
//           "pid"=>$row['product_id'],
//           "name"=>$row['name'],
//           "price"=>$row['price'],
//           "image"=>$row['image'],
//           "qty"=>1
//         )
//     );

//     $itemQty = "";
//     foreach ($cart as $key => $value) {
//           $itemQty = $value['qty'];
//     }

//     if (empty($_SESSION['cartData'])) {
//         $_SESSION['cartData'] = $cart;
//     } else {
//         // echo "<pre>";
//         // print_r($_SESSION['cartData']);
//         // echo "</pre>";
//         if (in_array($id, array_keys($_SESSION['cartData']))) {
//             $_SESSION['cartData'][$key]['qty'] += $itemQty;
//         } else {
//             $_SESSION['cartData'] 
//                 = array_merge($_SESSION['cartData'], $cart);
//         }
//     }
// }
if (isset($_GET['pid'])) {
    if (isset($_SESSION['cartData'])) {
        $cart = $_SESSION['cartData'];
    } else {
        $cart = array();
    }
    $id = $_GET['pid'];
    $sql = "SELECT * FROM products WHERE `product_id` =  '$id' ";
    $res = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['product_id'] == $id) {
            $pid = $row['product_id'];
            $pname = $row['name'];
            $pprice = $row['price'];
            $pimage = $row['image'];
      
            $cartArray = array(
              "pid"=>$pid,
              "name"=>$pname,
              "price"=>$pprice,
              "image"=>$pimage,
              "qty"=>1
            );

            $_SESSION['cartData'] = $cartArray;
            array_push($cart, $_SESSION['cartData']);

            for ($i=0; $i <= count($cart)-2; $i++) { 
                if ($cart[$i]['name']==$cartArray['name'] && $cart[$i]['price']==$cartArray['price']) {
                    $cart[$i]['qty']=$cart[$i]['qty']+1;
                    array_pop($cart);
                }
            }
        }
    }
    $_SESSION['cartData']=$cart;
}
require 'header.php';
?>
  <!-- product category -->
  <section id="aa-product-category">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
          <div class="aa-product-catg-content">
            <div class="aa-product-catg-head">
              <div class="aa-product-catg-head-left">
                <form action="" class="aa-sort-form">
                  <label for="">Sort by</label>
                  <select name="">
                    <option value="1" selected="Default">Default</option>
                    <option value="2">Name</option>
                    <option value="3">Price</option>
                    <option value="4">Date</option>
                  </select>
                </form>
                <form action="" class="aa-show-form">
                  <label for="">Show</label>
                  <select name="">
                    <option value="1" selected="12">12</option>
                    <option value="2">24</option>
                    <option value="3">36</option>
                  </select>
                </form>
              </div>
              <div class="aa-product-catg-head-right">
                <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
              </div>
            </div>
            <div class="aa-product-catg-body">
              <ul class="aa-product-catg">
                <!-- start single product item -->
                
                <?php 
                if (isset($_GET['id']) && $_GET['id'] != "") {
                    $id = $_GET['id'];

                    $limit = 12;
                    if (isset($_GET['arjun'])) {
                        $arjun = $_GET['arjun'];
                    } else {
                        $arjun = 1;
                    }
                    $stratFrom = ($arjun-1)*$limit;

                    $pro = fetchCategoryWise($id, $stratFrom, $limit);

                    foreach ($pro as $product) :
                        ?>
                  <li>
                    <figure>
                      <a class="aa-product-img" href="product-detail.php?id=<?php echo $product['id']; ?>"><img src="admin/productImage/<?php echo $product['image']; ?>" alt="polo shirt img" width="250" height="300"></a>
                      <a class="aa-add-card-btn cart" 
                      href="product.php?pid=<?php echo $product['product_id']; ?>"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                      <figcaption>
                        <h4 class="aa-product-title"><a href="#">
                          <?php echo $product['name']; ?>
                        </a></h4>
                        <span class="aa-product-price">$<?php echo $product['price'] ?>
                      </span><span class="aa-product-price"><del>$65.50</del></span>
                        <p class="aa-product-descrip">
                      <?php echo $product['short_desc']; ?>    
                      </p>
                      </figcaption>
                    </figure>                         
                    <div class="aa-product-hvr-content">
                      <!-- <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                      <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a> -->
                      <a href="#"
                      data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search quick" data-productid="<?php echo $product['id']; ?>">
                      </span></a>                            
                    </div>
                    <!-- product badge -->
                    <?php if ($product['status'] == 1) { ?>
                      <span class="aa-badge aa-sale" href="#">SALE!</span>
                      <?php } else { ?>
                        <span class="aa-badge aa-sold-out" href="#">Sold Out!</span>
                      <?php } ?>
                  </li>
                  <!-- start single product item -->
                                                          
                    <?php endforeach; 

                } else if (isset($_GET['tag']) && $_GET['tag'] != "") {
                    $tag = $_GET['tag'];

                    $limit = 12;
                    if (isset($_GET['arjun'])) {
                        $arjun = $_GET['arjun'];
                    } else {
                        $arjun = 1;
                    }
                    $stratFrom = ($arjun-1)*$limit;

                    $pro = filterTag($tag, $stratFrom, $limit);  
                    foreach ($pro as $product) : 
                        ?>
                <li>
                  <figure>
                    <a class="aa-product-img" href="product-detail.php?id=<?php echo $product['id']; ?>"><img src="admin/productImage/<?php echo $product['image']; ?>" alt="polo shirt img" width="250" height="300"></a>
                    <a class="aa-add-card-btn cart" 
                    href="product.php?pid=<?php echo $product['product_id']; ?>"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                    <figcaption>
                      <h4 class="aa-product-title"><a href="#">
                        <?php echo $product['name']; ?>
                      </a></h4>
                      <span class="aa-product-price">$<?php echo $product['price'] ?>
                    </span><span class="aa-product-price"><del>$65.50</del></span>
                      <p class="aa-product-descrip">
                        <?php echo $product['short_desc']; ?>    
                    </p>
                    </figcaption>
                  </figure>                         
                  <div class="aa-product-hvr-content">
                    <!-- <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                    <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a> -->
                    <a href="#"
                    data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search quick" data-productid="<?php echo $product['id']; ?>">
                    </span></a>                            
                  </div>
                  <!-- product badge -->
                  <?php if ($product['status'] == 1) { ?>
                      <span class="aa-badge aa-sale" href="#">SALE!</span>
                      <?php } else { ?>
                        <span class="aa-badge aa-sold-out" href="#">Sold Out!</span>
                      <?php } ?>
                </li>
                <!-- start single product item -->
                                                        
                    <?php endforeach; 
                
                } else if (isset($_GET['color']) && $_GET['color']) { 
                    $color = $_GET['color'];
                    $limit = 12;
                    if (isset($_GET['arjun'])) {
                        $arjun = $_GET['arjun'];
                    } else {
                        $arjun = 1;
                    }
                    $stratFrom = ($arjun-1)*$limit;


                    $pro = filterColor($color, $stratFrom, $limit);

                    foreach ($pro as $product) :
                        ?>
                  <li>
                    <figure>
                      <a class="aa-product-img" href="product-detail.php?id=<?php echo $product['id']; ?>"><img src="admin/productImage/<?php echo $product['image']; ?>" alt="polo shirt img" width="250" height="300"></a>
                      <a class="aa-add-card-btn cart" 
                      href="product.php?pid=<?php echo $product['product_id']; ?>"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                      <figcaption>
                        <h4 class="aa-product-title"><a href="#">
                          <?php echo $product['name']; ?>
                        </a></h4>
                        <span class="aa-product-price">$<?php echo $product['price'] ?>
                      </span><span class="aa-product-price"><del>$65.50</del></span>
                        <p class="aa-product-descrip">
                      <?php echo $product['short_desc']; ?>    
                      </p>
                      </figcaption>
                    </figure>                         
                    <div class="aa-product-hvr-content">
                      <!-- <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                      <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a> -->
                      <a href="#"
                      data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search quick" data-productid="<?php echo $product['id']; ?>">
                      </span></a>                            
                    </div>
                    <!-- product badge -->
                    <?php if ($product['status'] == 1) { ?>
                      <span class="aa-badge aa-sale" href="#">SALE!</span>
                      <?php } else { ?>
                        <span class="aa-badge aa-sold-out" href="#">Sold Out!</span>
                      <?php } ?>
                  </li>
                  <!-- start single product item -->
                                                          
                    <?php endforeach; 
                } else {
                
                    $limit = 12;
                    if (isset($_GET['arjun'])) {
                        $arjun = $_GET['arjun'];
                    } else {
                        $arjun = 1;
                    }
                    $stratFrom = ($arjun-1)*$limit;

                    $pro = fetchProductPagination($stratFrom, $limit);
                    // // print_r($pro);
                    // // exit();
                    // $pro = fetchProduct();
                    foreach ($pro as $product) :
                        ?>
                <li>
                  <figure>
                    <a class="aa-product-img" href="product-detail.php?id=<?php echo $product['id']; ?>"><img src="admin/productImage/<?php echo $product['image']; ?>" alt="polo shirt img" width="250" height="300"></a>
                    <a class="aa-add-card-btn cart" 
                    href="product.php?pid=<?php echo $product['product_id']; ?>"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                    <figcaption>
                      <h4 class="aa-product-title"><a href="#">
                        <?php echo $product['name']; ?>
                      </a></h4>
                      <span class="aa-product-price">$<?php echo $product['price'] ?>
                    </span><span class="aa-product-price"><del>$65.50</del></span>
                      <p class="aa-product-descrip">
                        <?php echo $product['short_desc']; ?>    
                    </p>
                    </figcaption>
                  </figure>                         
                  <div class="aa-product-hvr-content">
                    <!-- <a href="#" data-toggle="tooltip" data-placement="top" 
                    title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                    <a href="#" data-toggle="tooltip" data-placement="top" 
                    title="Compare"><span class="fa fa-exchange"></span></a> -->
                    <a href="#"
                    data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search quick" data-productid="<?php echo $product['id']; ?>">
                    </span></a>                            
                  </div>
                  <!-- product badge -->
                        <?php if ($product['status'] == 1) { ?>
                        <span class="aa-badge aa-sale" href="#">SALE!</span>
                        <?php  } else { ?>
                        <span class="aa-badge aa-sold-out" href="#">Sold Out!</span>
                        <?php } ?>
                </li>
                <!-- start single product item -->
                                                        
                    <?php endforeach; 
                }?>

              </ul>
    
              <!-- quick view modal -->                  
              <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">                      
                    <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <div class="row">
                        <!-- Modal view slider -->
                        <div class="col-md-6 col-sm-6 col-xs-12">                              
                          <div class="aa-product-view-slider">                                
                            <div class="simpleLens-gallery-container" id="demo-1">
                              <div class="simpleLens-container">
                                  <div class="simpleLens-big-image-container">
                                      <a class="simpleLens-lens-image" data-lens-image="">
                                          <!-- <img src="" class="simpleLens-big-image"> -->
                                      </a>
                                  </div>
                              </div>
                              <div class="simpleLens-thumbnails-container">
                                  <a href="#" class="simpleLens-thumbnail-wrapper"
                                     data-lens-image="img/view-slider/large/polo-shirt-1.png"
                                     data-big-image="img/view-slider/medium/polo-shirt-1.png">
                                      <!-- <img src="img/view-slider/thumbnail/polo-shirt-1.png"> -->
                                  </a>                                    
                                  <a href="#" class="simpleLens-thumbnail-wrapper"
                                     data-lens-image="img/view-slider/large/polo-shirt-3.png"
                                     data-big-image="img/view-slider/medium/polo-shirt-3.png">
                                      <!-- <img src="img/view-slider/thumbnail/polo-shirt-3.png"> -->
                                  </a>

                                  <a href="#" class="simpleLens-thumbnail-wrapper"
                                     data-lens-image="img/view-slider/large/polo-shirt-4.png"
                                     data-big-image="img/view-slider/medium/polo-shirt-4.png">
                                      <!-- <img src="img/view-slider/thumbnail/polo-shirt-4.png"> -->
                                  </a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Modal view content -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="aa-product-view-content">
                            <h3 class="nameresult"></h3>
                            <div class="aa-price-block">
                              <span class="aa-product-view-price priceresult"></span>
                              <p class="aa-product-avilability"></p>
                            </div>
                            <p class="sdescresult"></p>
                            <h4>Size</h4>
                            <div class="aa-prod-view-size">
                              <a href="#">S</a>
                              <a href="#">M</a>
                              <a href="#">L</a>
                              <a href="#">XL</a>
                            </div>
                            <div class="aa-prod-quantity">
                              <form action="">
                                <select name="" id="">
                                  <option value="0" selected="1">1</option>
                                  <option value="1">2</option>
                                  <option value="2">3</option>
                                  <option value="3">4</option>
                                  <option value="4">5</option>
                                  <option value="5">6</option>
                                </select>
                              </form>
                              <p class="aa-prod-category">
                                Category: <a href="#">Polo T-Shirt</a>
                              </p>
                            </div>
                            <div class="aa-prod-view-bottom">
                              <a href="#" class="aa-add-to-cart-btn addCart"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                              <a href="#" 
                              class="aa-add-to-cart-btn viewCart">View Details</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>                        
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div>
                <?php// endforeach; ?>
              <!-- / quick view modal -->   
            </div>
            <div class="aa-product-catg-pagination">
              <nav>
              <?php 
                    $row = fetchIdForPagination();
                    $totalRow = $row[0];
                    $totalPage = ceil($totalRow / $limit);
                    
                ?>
                <ul class="pagination">
                  <!-- <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li> -->
                  <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                  <li><a href="product.php?arjun=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                  <?php } ?>
                  <!-- <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li> -->
                  <!-- <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li> -->
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
          <aside class="aa-sidebar">
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Category</h3>
              <ul class="aa-catg-nav">
              <li><a href="product.php">Clear Filter</a></li>
              <?php
                $data = fetchCategory();
                foreach ($data as $row) :
                    ?>
                <li><a href="product.php?id=<?php echo $row['category_id'] ?>"><?php echo $row['name'] ?></a></li>
                <?php endforeach; ?>
                <!-- <li><a href="">Women</a></li>
                <li><a href="">Kids</a></li>
                <li><a href="">Electornics</a></li>
                <li><a href="">Sports</a></li> -->
              </ul>
            </div>
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Tags</h3>
              <div class="tag-cloud">
                <?php
                $data = fetchTags();
                foreach ($data as $tags) :
                    ?>
                <a href="product.php?tag=<?php echo $tags['name'] ?>"><?php echo $tags['name'] ?></a>
                <?php endforeach; ?>
                <!-- <a href="#">Ecommerce</a>
                <a href="#">Shop</a>
                <a href="#">Hand Bag</a>
                <a href="#">Laptop</a>
                <a href="#">Head Phone</a>
                <a href="#">Pen Drive</a> -->
              </div>
            </div>
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Shop By Price</h3>              
              <!-- price range -->
              <div class="aa-sidebar-price-range">
               <form action="">
                  <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                  </div>
                  <input type="hidden" id="minPrice" value="0">
                  <input type="hidden" id="maxPrice" value="50000">
                  <span id="skip-value-lower" class="example-val">500.00</span>
                 <span id="skip-value-upper" class="example-val">50000.00</span>
                 <button class="aa-filter-btn" type="submit">Filter</button>
               </form>
              </div>              

            </div>
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Shop By Color</h3>
              <div class="aa-color-tag">
                <?php 
                $data = fetchColor();
                foreach ($data as $row) :
                    ?>
                <a class="aa-color-<?php echo $row['color']; ?>"
                href="product.php?color=<?php echo $row['color']; ?>"></a>
                <?php endforeach; ?>
                <!-- <a class="aa-color-yellow" href="#"></a>
                <a class="aa-color-blue" href="#"></a>
                <a class="aa-color-pink" href="#"></a>
                <a class="aa-color-blue" href="#"></a>
                <a class="aa-color-orange" href="#"></a>
                <a class="aa-color-gray" href="#"></a>
                <a class="aa-color-black" href="#"></a>
                <a class="aa-color-white" href="#"></a>
                <a class="aa-color-cyan" href="#"></a>
                <a class="aa-color-olive" href="#"></a>
                <a class="aa-color-orchid" href="#"></a> -->
              </div>                            
            </div>
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Recently Views</h3>
              <div class="aa-recently-views">
                <ul>
                  <li>
                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                    <div class="aa-cartbox-info">
                      <h4><a href="#">Product Name</a></h4>
                      <p>1 x $250</p>
                    </div>                    
                  </li>
                  <li>
                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-1.jpg"></a>
                    <div class="aa-cartbox-info">
                      <h4><a href="#">Product Name</a></h4>
                      <p>1 x $250</p>
                    </div>                    
                  </li>
                   <li>
                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                    <div class="aa-cartbox-info">
                      <h4><a href="#">Product Name</a></h4>
                      <p>1 x $250</p>
                    </div>                    
                  </li>                                      
                </ul>
              </div>                            
            </div>
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Top Rated Products</h3>
              <div class="aa-recently-views">
                <ul>
                  <li>
                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                    <div class="aa-cartbox-info">
                      <h4><a href="#">Product Name</a></h4>
                      <p>1 x $250</p>
                    </div>                    
                  </li>
                  <li>
                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-1.jpg"></a>
                    <div class="aa-cartbox-info">
                      <h4><a href="#">Product Name</a></h4>
                      <p>1 x $250</p>
                    </div>                    
                  </li>
                   <li>
                    <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                    <div class="aa-cartbox-info">
                      <h4><a href="#">Product Name</a></h4>
                      <p>1 x $250</p>
                    </div>                    
                  </li>                                      
                </ul>
              </div>                            
            </div>
          </aside>
        </div>
       
      </div>
    </div>
  </section>
  <!-- / product category -->


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

<?php
  require 'footer.php';
?>
<script>
// $(document).ready(function (){
  $('.quick').click(function (){
    var productid = $(this).data('productid');
    // alert(productid);
    $.ajax({
              method: "POST",
              url: "lensProduct.php",
              data: { id: productid },
              dataType: "json"
          })
          .done(function( msg ) {
              // alert( "Data Saved: " + msg.product.name );
              $('.nameresult').html(msg.product.name);
              $('.priceresult').html("$"+msg.product.price);
              $('.sdescresult').html(msg.product.short_desc);
              $('.simpleLens-thumbnail-wrapper').html("<img src='admin/productImage/"+msg.product.image +"' height='70' width='50'>");
              $('.simpleLens-lens-image').html("<img src='admin/productImage/"+msg.product.image +"'>");
              if (msg.product.status == 1) {
                $('.aa-product-avilability').html("Availbilty: <span>In Stock</span>");
              } else {
                $('.aa-product-avilability').html("Availbilty: <span>Out Of Stock</span>");
              }
              $('.viewCart').attr('href', 'product-detail.php?id='+msg.product.id+'');
              $('.addCart').attr('href', 'product.php?pid='+msg.product.product_id+'');
              // alert(msg.product.status);
              // $('.viewDetail').attr('href', "product-detail.php?id="+ msg.product.id +")";
              // $('#result').html('Product Id: ' + msg.product.image);
              
              // alert(msg.product.image);
              // console.log(msg.product.id);
          });
  });

  // $('.cart').click(function (){
  //   var pid = $(this).data('pid');
  //   // alert(pid);
  //   $.ajax({
  //           method: 'POST',
  //           url: 'cartProcess.php',
  //           data: { id: pid },
  //           dataType: "json" 
  //         })
  //         .done(function ( msg ) {
  //           alert("Product Added");
  //         });
  // });
// });
</script>