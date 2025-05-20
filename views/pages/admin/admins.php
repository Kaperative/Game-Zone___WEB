<?php
/**
 * @var App\Core\View\View $view
 * @var Session $session
 * @var User $user
 * @var int $currentPage
 * @var int $totalPages
 * @var int $perPage
 * @var string $searchQuery
 */

use App\Core\Session\Session;
use App\Models\User;

?>

<?php $view->includeComponent("header"); ?>
<?php $view->includeComponent("topLine"); ?>

    <main class="admin-users">
        <?php  $view->includeComponent('/table/userTable');?>
    </main>

<?php $view->includeComponent("footer"); ?>