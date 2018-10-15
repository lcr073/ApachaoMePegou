<?php
/**
 * Created by PhpStorm.
 * User: lcr07
 * Date: 04/05/2018
 * Time: 16:52
 */

$user = "apachao";
$pass = "123456";


try {
    $dbh = new PDO("mysql:host=localhost;dbname=apachao_me_pegou", $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
