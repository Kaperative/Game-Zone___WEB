<?php

use App\Models\User;
use App\services\AuthService;

/**
 * @var User $user;
 * @var AuthService $auth;
 */
?>

<?php
    if($auth->isLogin())
    {
?>
        <h1>Hi my dear USER</h1>

<?php

    }
?>
