<?php
use App\User;


    if(isset($_POST['username'])){

        if($_POST['password'] == $_POST['confirm-password'])
        {
           $user = new User();
           if($user->register($_POST['username'],$_POST['email'],$_POST['password']))
           {
            setcookie(  "user_name",        
                $_POST['username'],        
                 time() + 3600, 
                    APP_PATH,               
                 "game-zone.lndo.site",    
                 true,           
                 true         
            );
           }
        }
    }


    