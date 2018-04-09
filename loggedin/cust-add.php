<?php

$currentPage = 'Add Customer';

include 'header.php';

if (isset($_POST['btnSubmit'])) {

// -- Preliminary validation
    if (empty($_POST['name'])) {
        echo "<script>alert('Please specify a name.');";
        echo "document.getElementById('name').focus();</script>";
        return false;
    }

    if (empty($_POST['address'])) {
        echo "<script>alert('Please specify an address.');";
        echo "document.getElementById('address').focus();</script>";
        return false;
    }

    if (empty($_POST['number'])) {
        echo "<script>alert('Please specify a contact number.');";
        echo "document.getElementById('number').focus();</script>";
        return false;
    }

// -- Preliminary validation ends

    $name = test_input($_POST['name']);
    $address = test_input($_POST['address']);
    $number = test_input($_POST['number']);

// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        return false;
    }

// Inserts details into the Customers table
    $stmt = $conn->prepare('INSERT INTO `customers`(`name`, `address`, `number`) VALUES (?, ?, ?)');

    $stmt->bind_param('sss', $name, $address, $number);

// execute query
    $stmt->execute();

    echo "<script>alert('Customer added successfully!'); window.location.replace('cust.php');</script>";
}

include 'misc/sidebar.php';
include 'misc/navbar.php';

?>

<div class="container">
    <div class="row px-2">
        <div class="col-md-6">
            <form method="post" id="custAddForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address"
                           placeholder="eg. 21, Jalan Ara, Bangsar" required>
                </div>

                <!-- Contact Number -->
                <div class="form-group">
                    <label for="number">Contact Number</label>
                    <input type="tel" class="form-control" name="number" id="number" placeholder="0123456789" required>
                </div>

                <div class="float-right mb-4">
                    <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary mr-1">Submit
                    </button>
                    <a class="btn btn-secondary" href="cust.php"
                       style="padding-left: 15px; padding-right: 15px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Javascript Validation -->
<script type="text/javascript">
    $().ready(function () {
        $.validator.addMethod('number', function (value) {
            return /^[0-9]{10,12}$/.test(value);
        }, 'Please enter a valid phone number.');

        // Validate signup form on keyup and submit
        $("#custAddForm").validate({

            rules: {
                number: "required number",
            },
        });
    });

</script>


<?php
include 'sub-footer.php';
?>


<?php

// Cleans input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

