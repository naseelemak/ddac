<?php

$currentPage = 'Add Shipment';

include 'header.php';

if (isset($_POST['btnSubmit'])) {

// -- Preliminary validation
    if (empty($_POST['cust'])) {
        echo "<script>alert('Please specify a customer.');";
        echo "document.getElementById('cust').focus();</script>";
        return false;
    }

    if (empty($_POST['item'])) {
        echo "<script>alert('Please specify an item.');";
        echo "document.getElementById('item').focus();</script>";
        return false;
    }

    if (empty($_POST['vessel'])) {
        echo "<script>alert('Please specify a vessel.');";
        echo "document.getElementById('vessel').focus();</script>";
        return false;
    }

    if (empty($_POST['date'])) {
        echo "<script>alert('Please specify a shipment date.');";
        echo "document.getElementById('date').focus();</script>";
        return false;
    }
// -- Preliminary validation ends

    $cust = test_input($_POST['cust']);
    $item = test_input($_POST['item']);
    $vessel = test_input($_POST['vessel']);
    $date = test_input($_POST['date']);

// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        return false;
    }

// Inserts details into the Shipments table
    $stmt = $conn->prepare('INSERT INTO `shipments`(`cust_name`, `item_name`, `vessel_name`, `date`) VALUES (?, ?, ?, ?)');

    $stmt->bind_param('ssss', $cust, $item, $vessel, $date);

// execute query
    $stmt->execute();

    echo "<script>alert('Shipment added successfully!'); window.location.replace('ship.php');</script>";
}

include 'misc/sidebar.php';
include 'misc/navbar.php';

?>

<div class="container">
    <div class="row px-2">
        <div class="col-md-6">
            <form method="post" id="shipAddForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Customer Name -->
                <div class="form-group">
                    <label for="cust">Customer</label>
                    <select class="form-control" type="text" name="cust" id="cust" required>
                        <option selected disabled>--Select--</option>
                        <?php

                        $stmt = $conn->prepare('SELECT * FROM `customers` ORDER BY `name`');

                        // execute query
                        $stmt->execute();

                        // Get the result
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . " - " . $row["address"] . "</option>";
                        }

                        ?>
                    </select>
                </div>

                <!-- Item Name -->
                <div class="form-group">
                    <label for="item">Item</label>
                    <select class="form-control" type="text" name="item" id="item" required>
                        <option selected disabled>--Select--</option>
                        <?php

                        $stmt = $conn->prepare('SELECT * FROM `items` ORDER BY `name`');

                        // execute query
                        $stmt->execute();

                        // Get the result
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . " - " . $row["description"] . "</option>";
                        }

                        ?>
                    </select>
                </div>

                <!-- Vessel -->
                <div class="form-group">
                    <label for="vessel">Vessel</label>
                    <select class="form-control" type="text" name="vessel" id="vessel" required>
                        <option selected disabled>--Select--</option>
                        <?php

                        $stmt = $conn->prepare('SELECT * FROM `vessels` ORDER BY `name`');

                        // execute query
                        $stmt->execute();

                        // Get the result
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . " - " . $row["description"] . "</option>";
                        }

                        ?>
                    </select>
                </div>

                <!-- Shipment Date -->
                <div class="form-group">
                    <label for="date">Shipment Date</label>
                    <input class="form-control mb-4" type="text" id="date" name="date" required>
                </div>

                <div class="float-right mb-4">
                    <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary mr-1">Submit
                    </button>
                    <a class="btn btn-secondary" href="ship.php"
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
        $("#shipAddForm").validate({

            rules: {
                number: "required number",
            },
        });
    });

</script>

<!-- Shipment Date Picker -->
<script type="text/javascript">
    $(function () {
        $('input[name="date"]').daterangepicker({
                "locale": {
                    "format": "YYYY/MM/DD",
                },
                singleDatePicker: true,
                showDropdowns: true
            },
            function (start, end, label) {
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

