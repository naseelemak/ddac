<?php

$currentPage = 'Add Agent';

include 'header.php';
include 'misc/sidebar.php';
include 'misc/navbar.php';
?>

<div class="container">
    <div class="row px-2">
        <div class="col-md-6">
            <form method="post" id="agentAddForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username&nbsp;</label><i class="fa fa-question-circle text-muted"
                                                                   data-toggle="tooltip" data-placement="auto"
                                                                   title="Has to be unique" aria-hidden="true"></i>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                           required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                           minlength="6" required>
                </div>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
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
        $("#agentAddForm").validate({});
    });

</script>


<?php
include 'sub-footer.php';
?>


<?php
// Edit Profile
if (isset($_POST['btnSubmit'])) {

// -- Preliminary validation
    if (empty($_POST['username'])) {
        echo "<script>alert('Please specify a username.');";
        echo "document.getElementById('username').focus();</script>";
        return false;
    }

    if (empty($_POST['password'])) {
        echo "<script>alert('Please specify a password.');";
        echo "document.getElementById('password').focus();</script>";
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

    $username = test_input($_POST['username']);
    $username = strtolower($username);
    $password = test_input($_POST['password']);
    $name = test_input($_POST['name']);
    $email = test_input($_POST['email']);

// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        return false;
    }

// Checks first if user already exists
    $stmt = $conn->prepare('SELECT `username` FROM `agents` WHERE `username` = ?');

    $stmt->bind_param('s', $username);

// execute query
    $stmt->execute();

// Get the result
    $result = $stmt->get_result();

// If user already exists in database
    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists! Please enter an another username.');";
        echo "document.getElementById('regID').focus();</script>";
        return false;
    }

// hashes the password before saving it in the db
    $password = password_hash($password, PASSWORD_DEFAULT);

// Inserts details into the Agents table
    $stmt = $conn->prepare('INSERT INTO `agents`(`username`, `password`, `name`, `email`) VALUES (?, ?, ?, ?)');

    $stmt->bind_param('ssss', $username, $password, $name, $email);

// execute query
    $stmt->execute();


    echo "<script>alert('Agent added successfully!'); window.location.replace('agent.php');</script>";
}

// Cleans input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

