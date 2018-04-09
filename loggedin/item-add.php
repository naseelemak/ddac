<?php

$currentPage = 'Add Item';

include 'header.php';

if (isset($_POST['btnSubmit'])) {

// -- Preliminary validation
    if (empty($_POST['name'])) {
        echo "<script>alert('Please specify a name.');";
        echo "document.getElementById('name').focus();</script>";
        return false;
    }

    if (empty($_POST['description'])) {
        echo "<script>alert('Please specify an address.');";
        echo "document.getElementById('description').focus();</script>";
        return false;
    }

// -- Preliminary validation ends

    $name = test_input($_POST['name']);
    $description = test_input($_POST['description']);

// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        return false;
    }

// Inserts details into the Items table
    $stmt = $conn->prepare('INSERT INTO `items`(`name`, `description`) VALUES (?, ?)');

    $stmt->bind_param('ss', $name, $description);

// execute query
    $stmt->execute();

    echo "<script>alert('Item added successfully!'); window.location.replace('item.php');</script>";
}

include 'misc/sidebar.php';
include 'misc/navbar.php';

?>

<div class="container">
    <div class="row px-2">
        <div class="col-md-6">
            <form method="post" id="itemAddForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Address</label>
                    <input type="text" class="form-control" name="description" id="description"
                           placeholder="e.g. 12 units in a 5x5 cm container" required>
                </div>

                <div class="float-right mb-4">
                    <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary mr-1">Submit
                    </button>
                    <a class="btn btn-secondary" href="item.php"
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
        $("#itemAddForm").validate({

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

