<?php
session_start();
    $options = [
        'cost' => 5
    ];

    // echo password_hash("admin", PASSWORD_DEFAULT);

    echo '$2y$10$biOI1T7.vdq0kgCOmv6vC.ndpob2oi26QqCmWg4wcxrJV9K8FR8Qu';
    $passwordhash = password_hash("admin", PASSWORD_DEFAULT);
    $hasil=var_dump(password_verify('admin',$passwordhash));
    echo '//';
echo"$hasil";
$sess = $_SESSION['admlogin'];
echo "$sess";
?>
