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
require 'function.php';

$id = $_POST['id'];
$row = fetchProductDetail($id);
// print_r($row);
// echo $row['image'];
echo json_encode(array('product'=>$row));
?>