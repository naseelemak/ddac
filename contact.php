<?php
$currentPage = 'Contact Us';


include '../header.php';
include 'misc/navbar.php';
?>

<div class="jumbotron jumbotron-fluid mb-4">
    <div class="container">
        <h1 class="display-5"><?php echo $currentPage; ?></h1>
    </div>
</div>

<div class="container mt-3 mb-5">
    <?php if (!empty($msg)) {
        echo "<h2>$msg</h2>";
    } ?>

    <h6 class="mb-4">Want to promote a competition to APU or just want to ask a question? Get in touch with us
        here.</h6>

    <form id="contactForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="name">Your Name / Organisation</label>
            <input id="name" name="name" type="text" class="form-control" placeholder="John Smith" required>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" class="form-control" placeholder="name@example.com" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category" class="form-control" required>
                <option selected disabled>--Select--</option>
                <option>Competition Invite</option>
                <option>General Query</option>
                <option>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="message">Your Message</label>
            <textarea id="message" name="message" class="form-control" rows="7"
                      placeholder="E.g. We're organising a hackathon in February and would like to invite the agents of APU to participate in it. You can read more about the event here – https://www.hackyhacky2018.com. We look forward to your involvement!"></textarea>
        </div>

        <br>
        <button id="submit" name="submit" type="submit" class="btn btn-primary mr-1" role="button">Submit</button>
    </form>
</div>

<!-- Javascript Validation -->
<script type="text/javascript">
    $().ready(function () {
        // Validate contact form on keyup and submit
        $("#contactForm").validate();
    });

</script>


<?php

include '../footer.php';

?>

<?php

if (isset($_POST['submit'])) {
    // -- Preliminary validation
    if (empty($_POST['name'])) {
        echo "<script>alert('Please enter a name.');";
        echo "document.getElementById('name').focus();</script>";
        return false;
    }

    if (empty($_POST['email'])) {
        echo "<script>alert('Please enter an email address.');";
        echo "document.getElementById('email').focus();</script>";
        return false;
    }

    if (empty($_POST['category'])) {
        echo "<script>alert('Please select a category');";
        echo "document.getElementById('category').focus();</script>";
        return false;
    }

    if (empty($_POST['message'])) {
        echo "<script>alert('Please enter a message.');";
        echo "document.getElementById('message').focus();</script>";
        return false;
    }
    // -- Preliminary validation ends

    $name = test_input($_POST['name']);
    $email = test_input($_POST['email']);
    $category = test_input($_POST['category']);
    $message = test_input($_POST['message']);

    $msg = sendContact($name, $email, $category, $message);

    echo '<script>alert("' . $msg . '");</script>';
}

?>
