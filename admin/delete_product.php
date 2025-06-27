<?php

require_once '../connection.php';


if(isset($_GET['id'])){
    $id=$_GET['id'];

    $sql="DELETE  FROM product WHERE id=$id";
$result=mysqli_query($conn,$sql);
if($result){
    header('Location:products.php');
}

}




?>