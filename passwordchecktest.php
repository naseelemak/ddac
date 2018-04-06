<?php

// Password hasher
$password = password_hash("jager", PASSWORD_DEFAULT);

echo $password;

echo "<br><br>";

if (password_verify('jager', $password)) {
    echo 'Passwords tally';
} else {
    echo 'Passwords do not match';
}

?>