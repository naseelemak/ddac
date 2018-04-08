<?php

$currentPage = 'Edit Agent';

include 'header.php';
include 'misc/sidebar.php';
include 'misc/navbar.php';

if (isset($_GET['username'])) {
    $oldUsername = base64_decode($_GET['username']);

    $stmt = $conn->prepare('SELECT * FROM `agents` WHERE `username` = ?');
    $stmt->bind_param('s', $oldUsername);

    // execute query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
} else if (isset($_POST['btnSubmit'])) {

// -- Preliminary validation
    if (empty($_POST['username'])) {
        echo "<script>alert('Please specify a username.');";
        echo "document.getElementById('username').focus();</script>";
        return false;
    }

    if (empty($_POST['name'])) {
        echo "<script>alert('Please specify a name.');";
        echo "document.getElementById('name').focus();</script>";
        return false;
    }

    if (empty($_POST['email'])) {
        echo "<script>alert('Please specify an email address.');";
        echo "document.getElementById('email').focus();</script>";
        return false;
    }
// -- Preliminary validation ends

    $oldUsername = $_POST['oldUsername'];
    $username = test_input($_POST['username']);
    $username = strtolower($username);

    if (!empty($_POST['password'])) {
        $password = test_input($_POST['password']);
    }
    $name = test_input($_POST['name']);
    $email = test_input($_POST['email']);

// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        return false;
    }

    if (strcasecmp($oldUsername, $username) != 0) {
        // Checks first if username already exists
        $stmt = $conn->prepare('SELECT `username` FROM `agents` WHERE `username` = ?');

        $stmt->bind_param('s', $username);

        // execute query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // If user already exists in database
        if ($result->num_rows > 0) {
            echo "<script>alert('Username already exists! Please enter an another username.');";
            echo "<script>alert('Agent added successfully!'); window.location.replace('agent.php?id=$username');</script>";
            echo "document.getElementById('regID').focus();</script>";
            return false;
        }

    }

    if (!empty($_POST['password'])) {
        // hashes the password before saving it in the db
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Inserts details into the Agents table
        $stmt = $conn->prepare('UPDATE `agents` SET `username`= ?, `password`= ?, `name`= ?, `email`= ? WHERE `username`= ?');

        $stmt->bind_param('sssss', $username, $password, $name, $email, $oldUsername);

        // execute query
        $stmt->execute();


    } else {

        // Inserts details into the Agents table
        $stmt = $conn->prepare('UPDATE `agents` SET `username`= ?, `name`= ?, `email`= ? WHERE `username`= ?');

        $stmt->bind_param('ssss', $username, $name, $email, $oldUsername);

        // execute query
        $stmt->execute();

    }

    echo "<script>alert('Agent details updated successfully!'); window.location.replace('agent.php');</script>";
}

?>

<div class="container">
    <div class="row px-2">
        <div class="col-md-6">
            <form method="post" id="agentEditForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <input type="hidden" name="oldUsername" id="oldUsername" value="<?php echo $row['username']; ?>">

                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username&nbsp;</label><i class="fa fa-question-circle text-muted"
                                                                   data-toggle="tooltip" data-placement="auto"
                                                                   title="Has to be unique" aria-hidden="true"></i>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                           value="<?php echo $row['username']; ?>" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password&nbsp;</label><i class="fa fa-question-circle text-muted"
                                                                   data-toggle="tooltip" data-placement="auto"
                                                                   title="Leave field empty if password change not required"
                                                                   aria-hidden="true"></i>
                    <input type="password" class="form-control" name="password" id="password" placeholder="New password"
                           minlength="6">
                </div>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                           value="<?php echo $row['name']; ?>" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                           value="<?php echo $row['email']; ?>" required>
                </div>

                <div class="float-right mb-4">
                    <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary mr-1">Submit
                    </button>
                    <a class="btn btn-secondary" href="agent.php" style="padding-left: 15px; padding-right: 15px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Javascript Validation -->
<script type="text/javascript">
    $().ready(function () {

        // Validate signup form on keyup and submit
        $("#agentEditForm").validate({});
    });

</script>


<?php
include 'sub-footer.php';


// Cleans input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


