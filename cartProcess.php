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
require 'function.php';
require 'config.php';

$id = $_POST['id'];
// exit();
$sql = "SELECT * FROM products WHERE product_id = '$id' ";
$res = mysqli_query($conn, $sql);
while ($data = mysqli_fetch_assoc($res)) {
    // $pid = $data['product_id'],
    $cart = array(
        $data['product_id']=>array(
            "pid"=>$data['product_id'],
            "name"=>$data['name'],
            "price"=>$data['price'],
            "image"=>$data['image'],
            "qty"=>1
        )
    );

    if (empty($_SESSION['cartData'])) {
        $_SESSION['cartData'] = $cart;
    } else {
        // echo "<pre>";
        // print_r($_SESSION['cartData']);
        // echo "</pre>";
        // exit();
        if (in_array($data['product_id'], array_keys($_SESSION['cartData']))) {
            $_SESSION['cartData'][$key]['qty'] += $cart['qty'];

        } else {
            $_SESSION['cartData'] = array_merge($_SESSION['cartData'], $cart);
        }
    }
}
// echo count($_SESSION['cartData']);
require 'header.php';
?>