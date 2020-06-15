<?php

if (empty($_POST['password'])) die('Password is missing');

$hash = password_hash($_POST['password'], PASSWORD_ARGON2ID);

echo "<code>$hash</code>";
