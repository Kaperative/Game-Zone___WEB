<?php
/**
 * @var App\Core\View\View $view
 * @var Session $session
 */

use App\Core\Session\Session;
use App\Models\User;

?>

<?php $view->includeComponent("header"); ?>
<?php $view->includeComponent("topLine"); ?>

    <main class="admin-users">
        <?php  $view->includeComponent('/table/articleTable');?>
    </main>

<?php $view->includeComponent("footer"); ?>