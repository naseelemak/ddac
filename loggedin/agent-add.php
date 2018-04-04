<?php

$currentPage = 'Add Agent';

include 'header.php';
include 'misc/sidebar.php';
include 'misc/navbar.php';
?>

<div class="container">
    <div class="row px-2">
        <div class="col-md-12">
            <form id="compCreateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                  enctype="multipart/form-data">
                <!-- Username -->
                <div class="form-group">
                    <label for="regName">Username</label>
                    <input type="text" name="regName" class="form-control" id="regName"
                           placeholder="As per APU registration" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="regName">Password</label>
                    <input type="password" name="regPass" class="form-control" id="regName" placeholder="Password"
                           required>
                </div>

                <!-- Name -->
                <div class="form-group">
                    <label for="regName">Name</label>
                    <input type="text" name="regName" class="form-control" id="regName"
                           placeholder="As per APU registration" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="regName">Email</label>
                    <input type="text" name="regName" class="form-control" id="regName"
                           placeholder="As per APU registration" required>
                </div>

                <div class="float-right mt-2">
                    <button type="submit" name="regSubmit" id="regSubmit" class="btn btn-primary mr-1">Submit</button>
                    <a class="btn btn-secondary" href="login.php" style="padding-left: 15px; padding-right: 15px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include 'sub-footer.php';
?>

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
        $("#compCreateForm").validate({
            rules: {
                compParticipants: "required compParticipants",
                compTags: "required compTags",
            },
        });
    });

</script>

<?php
include 'sub-footer.php';
?>


