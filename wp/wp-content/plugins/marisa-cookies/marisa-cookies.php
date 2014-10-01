<?php

function setCookie() {
    $date_of_expiry = time() + 365 ;
    setcookie( "userlogin", "anonymous", $date_of_expiry );
}

function firsttimecheck() {
    if ( $_COOKIE['userlogin'] ) {
        echo $_COOKIE['userlogin'];
    }
}