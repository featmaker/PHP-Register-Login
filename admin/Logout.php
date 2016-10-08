<?php 
session_start();
unset($_SESSION['user']);
unset($_COOKIE['user']);
echo "<script>alert('You hava logouted!');location.href = '/welcome.php'</script>";
exit();