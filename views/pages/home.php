<?php

/**
 * @var View $view
 * @var \App\services\AuthService $auth
 */

use App\Core\View\View;
use App\services\AuthService;

?>
<?php $view->includeComponent("header"); ?>
<?php $view->includeComponent("topLine"); ?>

<?php

if ($auth->isLogin()) {
    $view->includeComponent("info/userInfo");
}
else{
    $view->includeComponent("auth/auth");
}
?>

<?php $view->includeComponent("footer"); ?>