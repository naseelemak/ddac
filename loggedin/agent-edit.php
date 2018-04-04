<?php


$stmt = $conn->prepare('SELECT * FROM `posts` WHERE `id` = ?');
$stmt->bind_param('i', $_GET['id']);

// execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$currentPage = "[EDIT] " . $row['title'];

include '../header.php';
include 'misc/sidebar.php';
include 'misc/navbar.php';

list($date1, $date2) = explode(' - ', $row['dates']);
list($year, $month, $day) = explode('/', $date1);
list($year2, $month2, $day2) = explode('/', $date2);
list($dyear, $dmonth, $dday) = explode('/', $row['deadline']);

$date1 = $day . '/' . $month . '/' . $year;
$date2 = $day2 . '/' . $month2 . '/' . $year2;
$dates = $date1 . ' - ' . $date2;

$deadline = $dday . '/' . $dmonth . '/' . $dyear;
?>

<div class="container">
    <div class="row px-2">
        <div class="col-md-12">
            <form id="compEditForm" method="post" action="comp-edit-submit.php" enctype="multipart/form-data">

                <input type="hidden" name="compId" id="compId" value="<?php echo $row['id']; ?>">

                <input type="hidden" name="oldTitle" id="oldTitle" value="<?php echo $row['title']; ?>">

                <input type="hidden" name="oldPoster" id="oldPoster" value="<?php echo $row['poster']; ?>">

                <!-- Title -->
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="compTitle" id="compTitle" class="form-control mb-3"
                           value="<?php echo $row['title']; ?>" required>
                </div>

                <!-- Competition Date(s)-->
                <!-- Date Range Picker -->
                <div class="form-group">
                    <label for="compDates">Competition Date(s)</label>
                    <i class="fa fa-question-circle text-muted" data-toggle="tooltip" data-placement="auto"
                       title="For one day events, select the same date twice" aria-hidden="true"></i>
                    <input class="form-control mb-3" name="compDates" id="compDates" type="text"
                           value="<?php echo $dates; ?>" required>
                </div>

                <!-- Short Description -->
                <div class="form-group">
                    <label for="compDesc">Short Description</label>
                    <i class="fa fa-question-circle text-muted" data-toggle="tooltip" data-placement="auto"
                       title="To be displayed in competition cards. Maximum 250 characters." aria-hidden="true"></i>
                    <textarea rows="3" maxlength="250" type="text" name="compDesc" id="compDesc"
                              class="form-control mb-3" placeholder="250 Characters Max"
                              required><?php echo $row['short_desc']; ?></textarea>
                </div>

                <!-- Details Text Editor (Description, Prizes) -->
                <label for="summernote">Competition Details</label>

                <textarea id="summernote" name="compDetails" required><?php echo $row['details']; ?></textarea>

                <!-- Type of Competition -->
                <div class="form-group">
                    <label for="compType" class="mt-3">Type of Competition</label>
                    <select class="form-control mb-3" name="compType" id="compType" onChange="changetextbox();"
                            required>
                        <?php

                        if ($row['type'] == 0) {
                            echo '<option selected>Individual</option>
                        <option>Team</option>';
                        } else {
                            echo '<option>Individual</option>
                        <option selected>Team</option>';
                        }

                        ?>
                    </select>
                </div>

                <!-- Participants -->
                <div class="form-group">
                    <label for="compParticipants">Participants (Use a dash to represent ranges: E.g. 2-4)</label>
                    <?php

                    if ($row['type'] == 0) {
                        echo '<input type="text" class="form-control mb-3" name="compParticipants" id="compParticipants" placeholder="Number of people per team" disabled>';
                    } else {
                        echo '<input type="text" class="form-control mb-3" name="compParticipants" id="compParticipants" value="' . $row["participants"] . '" placeholder="Number of people per team">';
                    }

                    ?>
                </div>

                <!-- Venue -->
                <div class="form-group">
                    <label for="compVenue">Venue</label>
                    <input type="text" name="compVenue" id="compVenue" class="form-control mb-3"
                           value="<?php echo $row['venue']; ?>" placeholder="E.g. Mid Valley" required>
                </div>

                <!-- Registration Fee -->
                <div class="form-group">
                    <label for="compFee">Registration Fee (MYR)</label>
                    <input type="number" name="compFee" id="compFee" class="form-control mb-3" min="0"
                           value="<?php echo $row['fee']; ?>" placeholder="Per individual / team" required>
                </div>

                <!-- Registration Deadline-->
                <div class="form-group">
                    <label for="compDeadline">Registration Deadline</label>
                    <input type="text" name="compDeadline" id="compDeadline" class="form-control mb-3"
                           value="<?php echo $deadline; ?>" required>
                </div>

                <!-- Poster -->
                <div class="form-group">
                    <label for="compPoster">Poster</label>
                    <input type="file" name="compPoster" id="compPoster" class="form-control-file">
                </div>

                <!-- URL -->
                <div class="form-group">
                    <label for="compURL">Competition URL (Optional)</label>
                    <input type="url" name="compURL" id="compURL" class="form-control mb-3"
                           value="<?php echo $row['url']; ?>" placeholder="E.g. https://www.google.com">
                </div>

                <!-- Tags -->
                <div class="form-group">
                    <label for="compTags">Tags</label>
                    <input type="text" name="compTags" id="compTags" class="form-control mb-3"
                           value="<?php echo $row['tags']; ?>"
                           placeholder="Separate each tag with a comma (e.g. Java, C++, Exhibition)" required>
                </div>

                <div class="float-left mt-2 mb-4">
                    <a href="agent-delete.php?id=<?php echo $row['id']; ?>" onclick="return checkDelete()"
                       class="btn btn-danger mr-1">Delete Post</a>
                </div>

                <div class="float-right mt-2 mb-4">
                    <button type="submit" name="compEditSubmit" id="compEditSubmit" class="btn btn-primary mr-1"
                            role="button">Publish
                    </button>
                    <a class="btn btn-secondary" href="agent.php" style="padding-left: 15px; padding-right: 15px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include 'misc/sub-footer.php';
include '../footer.php';
?>

<!-- Delete confirmation -->
<script language="JavaScript" type="text/javascript">
    function checkDelete() {
        return confirm('Are you sure you want to delete this post? Once deleted, it cannot be recovered.');
    }
</script>

<!-- Competition Dates Date Range Picker -->
<script type="text/javascript">
    $(function () {
        $('input[name="compDates"]').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY",
            },
        });

    });

</script>

<!-- Visual Editor -->
<script>
    $('#summernote').summernote({
        tabsize: 2,
        height: 200,
        disableResizeEditor: true,
        toolbar: [
            // [groupName, [list of button]]
            ['undo'],
            ['redo'],
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table'],
            ['fullscreen'],
            ['codeview'],
            ['help'],
        ],
    });
    $('.note-statusbar').hide();

</script>

<!-- Number of Participants Field -->
<script type="text/javascript">
    function changetextbox() {
        if (document.getElementById("compType").value === "Individual") {
            document.getElementById("compParticipants").disabled = 'true';
            document.getElementById("compParticipants").value = "";
            document.getElementById("compParticipants").required = false;

        } else {
            document.getElementById("compParticipants").disabled = '';
            document.getElementById("compParticipants").required = true;
        }
    }

</script>

<!-- Registration Deadline Date Picker -->
<script type="text/javascript">
    $(function () {
        $('input[name="compDeadline"]').daterangepicker({
                "locale": {
                    "format": "DD/MM/YYYY",
                },
                singleDatePicker: true,
                showDropdowns: true
            },
            function (start, end, label) {
            });
    });

</script>

<!-- Javascript Validation -->
<script type="text/javascript">
    $().ready(function () {
        $.validator.addMethod('compParticipants', function (value) {
            return /^[0-9]+$|^[0-9]+-[0-9]+$/.test(value);
        }, 'Please follow the specified format (e.g. 2-4).');
        $.validator.addMethod('compTags', function (value) {
            return /^[a-zA-Z0-9-_,()_+#. ]+$/.test(value);
        }, 'Please only enter valid characters.');

        // Validate signup form on keyup and submit
        $("#compEditForm").validate({
            rules: {
                compParticipants: "required compParticipants",
                compTags: "required compTags",
            },
        });
    });

</script>



