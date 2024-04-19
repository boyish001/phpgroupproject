<script type="text/javascript">
    
<?php 
    session_start();

    unset($_SESSION['email']);
    unset($_SESSION['userType']);
    unset($_SESSION['password']);  
?>

window.location.href='index.php';
alert("Successfully Logged Out.....");

</script>