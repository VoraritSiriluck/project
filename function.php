<?php 
function redirectMessage($status, $message, $modal = 'room')
{
    header("Location: admin.php?status=$status&message=" . urlencode($message) . "&modal=$modal&show_modal=1");

    exit();
}
?>