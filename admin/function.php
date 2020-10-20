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
 /**
  * Add product into database
  * 
  * @param $insertProduct comment
  *
  * @return addProduct
  */
function addProduct($insertProduct)
{
    $pid = $insertProduct['pid'];
    $cid = $insertProduct['cid'];
    $name = $insertProduct['name'];
    $price = $insertProduct['price'];
    $sdesc = $insertProduct['sdesc'];
    $ldesc = $insertProduct['ldesc'];
    $image = $insertProduct['image'];
    $tags = $insertProduct['tags'];
    $color = $insertProduct['color'];

    // echo $pid, $cid, $name, $price, $sdesc, $ldesc;
    // exit();

    global $conn;
    $sql = "INSERT INTO products (`product_id`, `category_id`, `name`, `price`,
    `short_desc`, `long_desc`, `image`, `tags`, `color`) VALUES ('$pid', '$cid', '$name', '$price', '$sdesc',
        '$ldesc', '$image', '$tags', '$color')";
    if (mysqli_query($conn, $sql)) {
        $msg = "Product Added Suuccessfully";
        return $msg;
    }
}

/**
 * Fetch Product
 * 
 * @return fetchProduct()
 */
function fetchProduct()
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM products ORDER BY id DESC";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Delete product
 * 
 * @param $id comment
 * 
 * @return deleteProduct
 */
function deleteProduct($id)
{
    global $conn;
    $sql = "DELETE FROM products WHERE id = '$id' ";
    if (mysqli_query($conn, $sql)) {
        header('LOCATION: products.php');
    }
}

/**
 * Fetch product for edit
 * 
 * @param $id comment
 * 
 * @return fetchSpecificProduct()
 */
function fetchSpecificProduct($id)
{
    global $conn;
    
    $sql = "SELECT * FROM products WHERE id = '$id' ";
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    return $data;
}

/**
 * Update product
 * 
 * @param $editProduct comment
 * @param $id          comment
 * 
 * @return updateProduct
 */
function updateProduct($editProduct, $id)
{
    global $conn;
    
    $cid = $editProduct['cid'];
    $name = $editProduct['name'];
    $price = $editProduct['price'];
    $sdesc = $editProduct['sdesc'];
    $ldesc = $editProduct['ldesc'];
    $image = $editProduct['image'];

    if ($image != "") {
        $sql = "UPDATE products SET `category_id` = '$cid', `name` = '$name',
        `price` = '$price', `image` = '$image',
        `short_desc` = '$sdesc', `long_desc` = '$ldesc' 
         WHERE id = '$id' ";
        // echo $sql;
        // exit();
        return mysqli_query($conn, $sql);
    } else {
        $sql = "UPDATE products SET `category_id` = '$cid', `name` = '$name',
        `price` = '$price',
        `short_desc` = '$sdesc', `long_desc` = '$ldesc' 
         WHERE id = '$id' ";
        // echo $sql;
        // exit();
        return mysqli_query($conn, $sql);
    }
    
}

/**
 * Add Categories
 * 
 * @param $addCate comment
 * 
 * @return addCategory
 */
function addCategory($addCate)
{
    global $conn;
    $name = $addCate['name'];
    $cid = $addCate['cid'];

    $sql = "INSERT INTO categories (`category_id` ,`name`) VALUES ('$cid' ,
    '$name') ";
    if (mysqli_query($conn, $sql)) {
        $msg = "Category Added Successfully";
        return $msg;
    }
}

/**
 * Fetch Categories
 * 
 * @return fetchCateg
 */
function fetchCateg()
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM categories";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Delete Categories
 * 
 * @param $id comment
 * 
 * @return delCategory()
 */
function delCategory($id)
{
    global $conn;

    $sql = "DELETE FROM categories WHERE category_id = '$id' ";
    if (mysqli_query($conn, $sql)) {
        $res = "Delete Successfully !";
        return $res;
    }
}

/**
 * Fetch Sepecific Categories
 * 
 * @param $id comment
 * 
 * @return fetchSpecificCate()
 */
function fetchSpecificCate($id)
{
    global $conn;

    $sql = "SELECT * FROM categories WHERE category_id = '$id' ";
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);

    return $data;
}

/**
 * Update Categories
 * 
 * @param $name comment
 * @param $id   comment
 * 
 * @return updateCate
 */
function updateCate($name, $id)
{
    global $conn;
    $sql = "UPDATE categories SET  `name` = '$name' WHERE category_id = '$id' ";
    return mysqli_query($conn, $sql);
}

/**
 * Fetch User
 * 
 * @return fetchUser
 */
function fetchUser()
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM users";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($res)) {
        $row[] = $data; 
    }
    return $row;
}

/**
 * Delete User
 * 
 * @param $id comment
 * 
 * @return deleteUser()
 */
function deleteUser($id)
{
    global $conn;
    $sql = "DELETE FROM users WHERE `user_id` = '$id' ";
    if (mysqli_query($conn, $sql)) {
        $msg = "Delete Successfully";
        return $msg;
    }
}

/**
 * Fetch Order Details
 * 
 * @return fetchOrder()
 */
function fetchOrder()
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM orders";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Delete Order
 * 
 * @param $id comment
 * 
 * @return deleteOrder()
 */
function deleteOrders($id)
{
    global $conn;
    $sql = "DELETE FROM orders WHERE `order_id` = '$id' ";
    if (mysqli_query($conn, $sql)) {
        $msg = "Order Delete Succesfull";
        return $msg;
    }
}

/**
 * Add Tags
 * 
 * @param $name comment
 * 
 * @return addTags()
 */
function addTags($name)
{
    global $conn;
    $sql = "INSERT INTO tags (`name`) VALUES ('$name')";
    if (mysqli_query($conn, $sql)) {
        $msg = "Tag Added Successfully";
        return $msg;
    }
}

/**
 * Fetch Tag
 * 
 * @return fetchTags()
 */
function fetchTags()
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM tags";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Delete Tag
 *
 * @param $id comment
 *  
 * @return deleteTag()
 */
function deleteTag($id)
{
    global $conn;
    $sql = "DELETE FROM tags WHERE `tag_id` = '$id' ";
    if (mysqli_query($conn, $sql)) {
        $msg = "Delete Successfully";
        return $msg;
    }
}

/**
 * Fetch Sepecific Tag for update
 * 
 * @param $id comment
 * 
 * @return fetchSpecificTag()
 */
function fetchSpecificTag($id)
{
    global $conn;
    $sql = "SELECT * FROM tags WHERE `tag_id` = '$id' ";
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    return $data;
}

/**
 * Update Tags
 * 
 * @param $name comment
 * @param $id   comment
 * 
 * @return updateTags()
 */
function updateTags($name, $id)
{
    global $conn;
    $sql = "UPDATE tags SET `name` = '$name' WHERE `tag_id` = '$id' ";
    return mysqli_query($conn, $sql);
}

/**
 * Add color quantity
 * 
 * @param $addColorQty comment
 * 
 * @return colorQty()
 */
function colorQty($addColorQty)
{
    global $conn;
    $pid = $addColorQty['pid'];
    $color = $addColorQty['color'];
    $qty = $addColorQty['qty'];

    $sql = "INSERT INTO colors (`product_id`, `color`, `quantity`) VALUES 
    ('$pid', '$color', '$qty')";
    if (mysqli_query($conn, $sql)) {
        $msg = "Added Successfully";
        return $msg;
    }
}

/**
 * Fetch color quantity
 * 
 * @return fetchColor()
 */
function fetchColor()
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM colors";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Delete color quantity
 * 
 * @param $id comment
 * 
 * @return deleteColor()
 */
function deleteColor($id)
{
    global $conn;

    $sql = "DELETE FROM colors WHERE id  = '$id' ";
    if (mysqli_query($conn, $sql)) {
        $msg = "Delete Successfully";
        return $msg;
    }
}

/**
 * Fetch Specific Color
 * 
 * @param $id comment
 * 
 * @return fetchSpecificColor()
 */
function fetchSpecificColor($id)
{
    global $conn;

    $sql = "SELECT * FROM colors WHERE id = '$id' ";
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    return $data;
}

/**
 * Update Color & Quantity
 * 
 * @param $color comment
 * @param $qty   comment
 * @param $id    comment
 * 
 * @return updateColor()
 */
function updateColor($color, $qty, $id)
{
    global $conn;
    $sql = "UPDATE colors SET `color` = '$color', `quantity` = '$qty'
    WHERE id = '$id' ";
    return mysqli_query($conn, $sql);
}

/**
 * Add Products Tag
 * 
 * @param $addptag comment
 * 
 * @return addProductsTag
 */
function addProductsTag($addptag)
{
    global $conn;
    $pid = $addptag['pid'];
    $tid = $addptag['tid'];

    $sql = "INSERT INTO products_tags (`product_id`, `tag_id`) VALUES 
    ('$pid', '$tid')";
    if (mysqli_query($conn, $sql)) {
        $msg = "Successfully Added";
        return $msg;
    }
}

/**
 * Fetch Products 
 * 
 * @return fetchProductTag()
 */
function fetchProductTag()
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM products_tags";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_array($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Delete product and tag id
 * 
 * @param $id comment
 * 
 * @return deleteProTag()
 */
function deleteProTag($id)
{
    global $conn;
    
    $sql = "DELETE FROM products_tags WHERE id =  '$id' ";
    if (mysqli_query($conn, $sql)) {
        $msg = "Delete Successfully";
        return $msg;
    }
}
?>