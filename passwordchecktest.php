<?php

// Password hasher
$password = password_hash("admin", PASSWORD_DEFAULT);

echo $password;

echo "<br><br>";

if (password_verify("admin", $password)) {
    echo 'Passwords tally';
} else {
    echo 'Passwords do not match';
}

?>