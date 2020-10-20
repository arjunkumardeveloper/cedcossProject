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

 $siteurl = "http://localhost/cedcoss/cedproject/admin";

 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $dbname = "cedproject";

 global $conn;
 $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection Error: " . mysqli_connect_error());
}
// echo "Connected Successfully";
?>