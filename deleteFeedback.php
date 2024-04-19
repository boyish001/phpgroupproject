<?php 
    require('Database/feedback.php');

    $feedback = new feedback();
    $database = $feedback->getDatabase();

    $fedId=$_GET["id"];

    $result = $feedback->deleteFeedback($fedId);
    if($result)
    {
        echo "<script>alert('Feedback Deleted Successfully......');</script>";
    }
    else
    {
        echo "<script>alert('Error Delete Feedback......')</script>";
    }
    echo "<script>window.location.href='manageFeedback.php'</script>";

?>