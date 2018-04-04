<?php


$currentPage = 'Register';

include '../header.php';

if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] == 'agent') {
        echo "<script>window.location.href='../agent/index.php'</script>";
        die;
    } else {
        echo "<script>window.location.href='../loggedin/agent.php'</script>";
        die;
    }
}

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand mr-5" href="../agent/index.php">Maersk</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

            </ul>
            <div class="my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="../login.php">Login</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>


<div class="container mt-5 mb-4">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2 class="text-center"><strong>Register</strong></h2>
            <hr>
            <form id="regForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-row">

                    <!-- TP Number -->
                    <div class="form-group col-md-12">
                        <label for="regID">TP Number</label>
                        <input type="text" name="regID" class="form-control" id="regID" placeholder="TPxxxxxx" required>
                    </div>

                    <!-- Password -->
                    <div class="form-group col-md-6">
                        <label for="regPass">Password</label>
                        <input type="password" name="regPass" class="form-control" id="regPass" placeholder="Password"
                               minlength="6" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="regCPass">Confirm Password</label>
                        <input type="password" name="regCPass" class="form-control" id="regCPass" equalto="#regPass"
                               placeholder="Password" minlength="6" required>
                    </div>
                </div>

                <!-- Name -->
                <div class="form-group">
                    <label for="regName">Name</label>
                    <input type="text" name="regName" class="form-control" id="regName"
                           placeholder="As per APU registration" required>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="regPhone">Phone Number</label>
                    <input name="regPhone" class="form-control" type="tel" placeholder="0123456789" id="regPhone"
                           required>
                </div>

                <!-- Preferred Type of Competition -->
                <div class="form-group">
                    <label for="regCompType">Preferred Type of Competition</label>
                    <select name="regCompType" type="text" class="form-control" id="regCompType" required>
                        <option selected disabled>--Select--</option>
                        <option>Individual</option>
                        <option>Team</option>
                    </select>
                </div>

                <!-- Interests (Tags) -->
                <div class="form-group">
                    <label for="regInterests">Interests</label>
                    <input name="regInterests" type="text" class="form-control"
                           placeholder="Separate each interest with a comma (e.g. Java, PHP, Public Speaking)"
                           id="regInterests" required>
                </div>

                <!-- Self-Introduction -->
                <div class="form-group">
                    <label for="regIntro">Self-Introduction (Optional)</label>
                    <textarea name="regIntro" class="form-control" type="text" id="regIntro"
                              placeholder="I excel in programming and in identifying different breeds of cats."
                              rows="5"></textarea>
                </div>

                <div class="float-right mt-2">
                    <button type="submit" name="regSubmit" id="regSubmit" class="btn btn-primary mr-1">Submit</button>
                    <a class="btn btn-secondary" href="../login.php" style="padding-left: 15px; padding-right: 15px;">Cancel</a>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<!-- Javascript Validation -->
<script type="text/javascript">
    $().ready(function () {
        $.validator.addMethod('regID', function (value) {
            return /[Tt]{1}[Pp]{1}[0-9]{6}\b/.test(value);
        }, 'Please enter a valid TP number.');

        $.validator.addMethod('regName', function (value) {
            return /^[a-zA-Z\- ]+$/.test(value);
        }, 'Please enter only letters and hyphens.');

        $.validator.addMethod('regPhone', function (value) {
            return /^[0-9]{10,12}$/.test(value);
        }, 'Please enter a valid phone number.');

        $.validator.addMethod('compTags', function (value) {
            return /^[a-zA-Z0-9-_,()_+#. ]+$/.test(value);
        }, 'Please only enter valid characters.');


        // Validate signup form on keyup and submit
        $("#regForm").validate({
            rules: {
                regID: "required regID",
                regName: "required regName",
                regPhone: "required regPhone",
                regInterests: "required compTags",
            },
        });
    });

</script>

<?php

include '../footer.php';

?>


<?php

// Login
if (isset($_POST['regSubmit'])) {
    // -- Preliminary validation
    if (empty($_POST['regID'])) {
        echo "<script>alert('Please enter a TP number.');";
        echo "document.getElementById('compDates').focus();</script>";
        return false;
    }

    if (empty($_POST['regName'])) {
        echo "<script>alert('Please enter a name.');";
        echo "document.getElementById('compDesc').focus();</script>";
        return false;
    }

    if (empty($_POST['regPhone'])) {
        echo "<script>alert('Please enter a phone number.');";
        echo "document.getElementById('compFee').focus();</script>";
        return false;
    }

    if (empty($_POST['regCompType'])) {
        echo "<script>alert('Please specify your preferred competition type.');";
        echo "document.getElementById('compDeadline').focus();</script>";
        return false;
    }

    if (empty($_POST['regInterests'])) {
        echo "<script>alert('Please specify your interests.');";
        echo "document.getElementById('compTitle').focus();</script>";
        return false;
    }
    // -- Preliminary validation ends

    $username = test_input($_POST['regID']);
    if (!preg_match("/[Tt]{1}[Pp]{1}[0-9]{6}\b/", $username)) {
        echo "<script>alert('Please enter your agent ID in the required format. (E.g. TP034567)');";
        echo "document.getElementById('regID').focus();</script>";
        return false;
    }

    $username = strtoupper($username);
    $password = test_input($_POST['regPass']);
    $cpassword = test_input($_POST['regCPass']);
    $name = test_input($_POST['regName']);

    $phone = test_input($_POST['regPhone']);
    if (!preg_match("/^[0-9]{10,12}$/", $phone)) {
        echo "<script>alert('Please only enter numbers in the phone number field 10 to 12 digits long. (E.g. 0123456789)');";
        echo "document.getElementById('regPhone').focus();</script>";
        return false;
    }

    $intro = test_input($_POST['regIntro']);
    $email = strtolower($username);
    $email = test_input($username . "@mail.apu.edu.my");

    if ($_POST['regCompType'] == "Individual") {
        $compType = 0;
    } else {
        $compType = 1;
    }

    $interests = $_POST['regInterests'];
    $intro = $_POST['regIntro'];
    $regDate = date('mY');


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

    if ($password == $cpassword) {
        // check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // hashes the password before saving it in the db
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Inserts details into the agent table
        $stmt = $conn->prepare('INSERT INTO `agents`(`username`, `password`, `name`, `phone_no`, `preferred_comp_type`, `interests`, `self_intro`, `email`, `reg_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

        $stmt->bind_param('sssssissss', $username, $password, $name, $phone, $compType, $interests, $intro, $email, $regDate);

        // execute query
        $stmt->execute();

        // encode username and create a random key
        $id = base64_encode($username);

        //create a random key from user's unique details
        $key = $name . $email . $regDate;
        $key = md5($key);

        sendConfirmation($name, $id, $email, $key);

        echo "<script>alert('Registration successful!'); window.location.replace('../agent/confirmation.php?id=" . $id . "');</script>";
    } else {
        echo "<script>alert('Passwords do not match. Please try again.');";
        echo "document.getElementById('regCPass').val(''); document.getElementById('regCPass').focus();</script>";
    }

}

?>
