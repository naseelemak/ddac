<?php

$currentPage = 'Edit Item';

include 'header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare('SELECT * FROM `items` WHERE `id` = ?');
    $stmt->bind_param('s', $id);

    // execute query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

} else if (isset($_POST['btnSubmit'])) {

// -- Preliminary validation
    if (empty($_POST['name'])) {
        echo "<script>alert('Please specify a name.');";
        echo "document.getElementById('name').focus();</script>";
        return false;
    }

    if (empty($_POST['description'])) {
        echo "<script>alert('Please specify a description.');";
        echo "document.getElementById('description').focus();</script>";
        return false;
    }
// -- Preliminary validation ends

    $id = test_input($_POST['id']);
    $name = test_input($_POST['name']);
    $description = test_input($_POST['description']);

// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        return false;
    }

    // Updates details in the Items table
    $stmt = $conn->prepare('UPDATE `items` SET `name`= ?, `description`= ? WHERE `id`= ?');

    $stmt->bind_param('ssi', $name, $description, $id);

    // execute query
    $stmt->execute();

    echo "<script>alert('Item details updated successfully!'); window.location.replace('item.php');</script>";
}

include 'misc/sidebar.php';
include 'misc/navbar.php';

?>

<div class="container">
    <div class="row px-2">
        <div class="col-md-6">
            <form method="post" id="itemEditForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>">

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                           value="<?php echo $row['name']; ?>" required>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description"
                           placeholder="e.g. 12 units in a 5x5 cm container" value="<?php echo $row['description']; ?>"
                           required>
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


// Cleans input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


