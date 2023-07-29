<?php
if(isset($_GET["signout"])){
    echo $_GET["signout"];

setcookie("access_token", "", time() - 3600, "/", "", false, true);
setcookie("userID_admin", "", time() - 3600, "/", "", false, true);
setcookie("role_admin", "", time() - 3600, "/", "", false, true);
setcookie("userID_seller", "", time() - 3600, "/", "", false, true);
setcookie("role_seller", "", time() - 3600, "/", "", false, true);
echo '<script>
window.location.href="login.php";
window.location.href="admin.php";
</script>';
exit();
}
?>
