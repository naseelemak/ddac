<?php
$currentPage = "agent Details";


$stmt = $conn->prepare('SELECT * FROM `agents` WHERE `username` = ?');
$stmt->bind_param('s', $_GET['id']);

// execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row == 0) {
    echo '<p class="text-muted ml-3">There seems to be a problem.</p>';
    $currentPage = "Error";
}

include '../header.php';
include 'misc/sidebar.php';
include 'misc/navbar.php';
?>


<div class="container mt-2">
    <div class="row px-2">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <?php

                    echo '<h4 class="card-title">' . $row['username'] . ' | ' . $row['name'] . '</h4>
                        <p class="card-subtitle mb-2 text-muted">' . $row['course_of_study'] . '</p>

                        <i class="fa fa-envelope text-info" aria-hidden="true"></i>&nbsp;&nbsp;' . $row['email'] . '

                        <br>

                        <i class="fa fa-phone-square mb-5 text-info" aria-hidden="true"></i>&nbsp;&nbsp;' . $row['phone_no'] . '

                        <br>

                        <h6 class="card-subtitle mb-2 text-muted">Additional Information</h6>

                        <form>
                            <!-- Preferred Type of Competition -->
                            <div class="form-group">
                                <label for="compTypeSelect">Preferred Type of Competition</label>
                                <input type="text" class="form-control" value="';

                    if ($row['preferred_comp_type'] == 0) {
                        echo 'Individual';
                    } else {
                        echo 'Team';
                    }

                    echo '" disabled>
                            </div>

                            <!-- Interests (Tags) -->
                            <div class="form-group">
                                <label for="inputInterests">Interests</label>
                                <input type="text" class="form-control" value="' . $row['interests'] . '" disabled>
                            </div>

                            <!-- Self-Introduction -->
                            <div class="form-group">
                                <label for="inputIntroduction">Self-Introduction</label>
                                <textarea class="form-control" id="inputIntroduction" rows="5" disabled>';

                    if (strcasecmp($row['self_intro'], '') == 0) {
                        echo '--No self-introduction--';
                    } else {
                        echo $row['self_intro'];
                    }

                    echo '</textarea>
                            </div>
                        </form>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'misc/sub-footer.php';
include '../footer.php';
?>
