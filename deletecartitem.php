<?php
session_start();

if(isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $item = array_search($id, $_SESSION['cart']);
    if($item !== false) {
        unset($_SESSION['cart'][$item]);
    }
}
header("Location: cart.php");
exit();
?>