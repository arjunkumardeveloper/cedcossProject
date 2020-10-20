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
require 'config.php';

/**
 * Fetch Category
 * 
 * @return fetchCategory()
 */
function fetchCategory()
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
 * Fetch Tags
 * 
 * @return fetchTags()
 */
function fetchTags()
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM tags";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_array($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Fetch Color
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
 * Fetch Specific Product Details
 * 
 * @param $id Comment
 * 
 * @return fetchProductDetail()
 */
function fetchProductDetail($id)
{
    global $conn;
    $sql = "SELECT * FROM products WHERE id = '$id' ";
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    return $data;
}

/**
 * Fetch Category Wise Product
 * 
 * @param $id        Comment
 * @param $stratFrom Comment
 * @param $limit     Comment
 * 
 * @return fetchCategoryWise()
 */
function fetchCategoryWise($id, $stratFrom, $limit) 
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM products WHERE category_id = '$id' LIMIT $stratFrom, $limit";
    $res = mysqli_query($conn, $sql);
    while($data = mysqli_fetch_assoc($res)) {
        $row[] = $data;
    }
    // print_r($data);
    // exit();
    return $row;
}

/**
 * Fetch Tags Wise Product
 * 
 * @param $tag       comment
 * @param $stratFrom comment
 * @param $limit     comment
 * 
 * @return filterTag()
 */
function filterTag($tag, $stratFrom, $limit) 
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM products WHERE `tags` = '$tag' LIMIT $stratFrom, $limit";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Filter Color
 * 
 * @param $color     Comment
 * @param $stratFrom Comment
 * @param $limit     Comment
 * 
 * @return filterColor()
 */
function filterColor($color, $stratFrom, $limit)
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM products WHERE `color` = '$color' LIMIT $stratFrom, $limit";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Fetch For Pagination
 * 
 * @param $stratFrom comment
 * @param $limit     comment
 * 
 * @return fetchProductPagination()
 */
function fetchProductPagination($stratFrom, $limit)
{
    global $conn;
    $row = array();

    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT $stratFrom, $limit";
    $res = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($res)) {
        $row[] = $data;
    }
    return $row;
}

/**
 * Fetch Id For Pagination
 * 
 * @return fetchIdForPagination()
 */
function fetchIdForPagination()
{
    global $conn;

    $sql = "SELECT COUNT(ID) FROM products";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($res);
    return $row;
}
?>