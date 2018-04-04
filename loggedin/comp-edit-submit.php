<?php


include '../functions.php';

// -- Preliminary validation
if (empty($_POST['compTitle'])) {
    echo "<script>alert('Please specify a title.');";
    echo "document.getElementById('compTitle').focus();</script>";
    echo "<script>window.location.replace('comp-edit.php?id=" . $_POST['compId'] . "');</script>";
    return false;
}

if (empty($_POST['compDates'])) {
    echo "<script>alert('Please specify the competition dates.');";
    echo "document.getElementById('compDates').focus();</script>";
    echo "<script>window.location.replace(agent-edit.php" . $_POST['compId'] . ");</script>";
    return false;
}

if (empty($_POST['compDesc'])) {
    echo "<script>alert('Please give the competition a brief description.');";
    echo "document.getElementById('compDesc').focus();</script>";
    echo "<script>window.location.replace('comp-edit.php?id=" . $_POST['compId'] . "');</script>";
    return false;
}

if (empty($_POST['compDetails'])) {
    echo "<script>alert('Please specify the competition details (e.g. prize, time).');";
    echo "document.getElementById('compDetails').focus();</script>";
    echo "<script>window.location.replace('comp-edit.php?id=" . $_POST['compId'] . "');</script>";
    return false;
}

if (empty($_POST['compType'])) {
    echo "<script>alert('Please specify the type of competition.');";
    echo "document.getElementById('compType').focus();</script>";
    echo "<script>window.location.replace('comp-edit.php?id=" . $_POST['compId'] . "');</script>";
    return false;
}

if (is_null($_POST['compFee']) || $_POST['compFee'] === '') {
    echo "<script>alert('Please specify the registration fee.');";
    echo "document.getElementById('compFee').focus();</script>";
    echo "<script>window.location.replace('comp-edit.php?id=" . $_POST['compId'] . "');</script>";
    return false;
}

if (empty($_POST['compDeadline'])) {
    echo "<script>alert('Please specify the registration deadline.');";
    echo "document.getElementById('compDeadline').focus();</script>";
    echo "<script>window.location.replace(agent-edit.php" . $_POST['compId'] . ");</script>";
    return false;
}

if (empty($_POST['compTags'])) {
    echo "<script>alert('Please specify at least one competition tag.');";
    echo "document.getElementById('compTitle').focus();</script>";
    echo "<script>window.location.replace('comp-edit.php?id=" . $_POST['compId'] . "');</script>";
    return false;
}
// -- Preliminary validation ends

$id = test_input($_POST['compId']);
$oldTitle = test_input($_POST['oldTitle']);
$oldPoster = test_input($_POST['oldPoster']);
$title = test_input($_POST['compTitle']);
$dates = test_input($_POST['compDates']);
$desc = test_input($_POST['compDesc']);
$details = test_input($_POST['compDetails']);
$type = test_input($_POST['compType']);

if ($_POST['compType'] == "Individual") {
    $type = 0;
} else {
    $type = 1;

    if (empty($_POST['compParticipants'])) {
        echo "<script>alert('Please specify the number of participants in a team.');";
        echo "document.getElementById('compParticipants').focus();</script>";
        return false;
    }

}

if ($type == 0) {
    $participants = 1;
} else {
    $participants = test_input($_POST['compParticipants']);
}

$venue = test_input($_POST['compVenue']);
$fee = test_input($_POST['compFee']);
$deadline = test_input($_POST['compDeadline']);
$url = test_input($_POST['compURL']);
$tags = test_input($_POST['compTags']);

// Date formatting for storage in DB
list($date1, $date2) = explode(' - ', $dates);
list($day, $month, $year) = explode('/', $date1);
list($day2, $month2, $year2) = explode('/', $date2);
list($dday, $dmonth, $dyear) = explode('/', $deadline);

$date1 = $year . '/' . $month . '/' . $day;
$date2 = $year2 . '/' . $month2 . '/' . $day2;
$dates = $date1 . ' - ' . $date2;

$deadline = $dyear . '/' . $dmonth . '/' . $dday;
// Date formatting ends

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    return false;
}

// -- Checks first if title already exists
if (strcmp($oldTitle, $title) != 0) {
    // -- Checks first if title already exists
    $stmt = $conn->prepare('SELECT `title` FROM `posts` WHERE `title` = ?');

    $stmt->bind_param('s', $title);

    // execute query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // If title already exists in database
    if ($result->num_rows > 0) {
        echo "<script>alert('Title already exists! Please enter another one.');";
        echo "document.getElementById('compTitle').focus();</script>";
        echo "<script>window.location.replace('comp-edit.php?id=$id');</script>";
        return false;
    }
    // -- Database check ends
}

$test = $_FILES['compPoster']['size'];
$test2 = isset($_FILES['compPoster']);

if ($_FILES['compPoster']['size'] != 0) {
    $check = getimagesize($_FILES['compPoster']['tmp_name']);
} else {
    $check = false;
}

if ($check !== false) {
    $uploadOk = 1;

    $target_dir = "../assets/images/comp/";
    $filename = basename($_FILES["compPoster"]["name"]);
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $newfilename = $target_dir . $title . "." . $extension;

    // Allow only certain file formats
    if ($extension != "jpg" && $extension != "png" && $extension != "jpeg") {
        echo "<script>alert('Sorry, only JPG, JPEG, & PNG files are allowed!');</script>";
        $uploadOk = 0;
        return false;
    }

    // Check file size
    if ($_FILES["compPoster"]["size"] > 5000000) {
        echo "<script>alert('The picture exceeds the size limit.');</script>";
        $uploadOk = 0;
        return false;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return false;
    } // if everything is ok, try to upload file
    else {
        $stmt = $conn->prepare('SELECT * FROM `posts` WHERE id = ?');
        $stmt->bind_param('i', $id);

        // Execute query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        unlink($row['poster']);

        if (move_uploaded_file($_FILES["compPoster"]["tmp_name"], $newfilename)) {

            // Inserts details into the Posts table
            $stmt = $conn->prepare('UPDATE `posts` SET `dates`= ?,`short_desc`= ?,`details`= ?,`type`= ?,`participants`= ?,`venue`= ?,`fee`= ?,`deadline`= ?,`poster`= ?,`url`= ?,`tags`= ? WHERE `id` = ?');

            $stmt->bind_param('sssissdssssi', $dates, $desc, $details, $type, $participants, $venue, $fee, $deadline, $newfilename, $url, $tags, $id);

            // execute query
            $stmt->execute();

            echo "<script>alert('Post updated successfully!'); window.location.replace(aagents.phpp);</script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your picture!');</script>";
            return false;
        }
    }
} elseif (strcmp($oldTitle, $title) != 0) {
    $target_dir = "../assets/images/comp/";
    $extension = basename($oldPoster);
    $extension = substr($extension, strpos($extension, ".") + 1);

    $newfilename = $target_dir . $title . "." . $extension;
    rename($oldPoster, $newfilename);

    // Inserts details into the Posts table
    $stmt = $conn->prepare('UPDATE `posts` SET `title`= ?, `dates`= ?,`short_desc`= ?,`details`= ?,`type`= ?,`participants`= ?,`venue`= ?,`fee`= ?,`deadline`= ?,`poster`= ?,`url`= ?,`tags`= ? WHERE `id` = ?');

    $stmt->bind_param('ssssissdssssi', $title, $dates, $desc, $details, $type, $participants, $venue, $fee, $deadline, $newfilename, $url, $tags, $id);

    // execute query
    $stmt->execute();

    echo "<script>alert('Post updated successfully!'); window.location.replace(aagents.phpp);</script>";
} else {
    // Updates details in the Posts table
    $stmt = $conn->prepare('UPDATE `posts` SET `dates`= ?,`short_desc`= ?,`details`= ?,`type`= ?,`participants`= ?,`venue`= ?,`fee`= ?,`deadline`= ?,`url`= ?,`tags`= ? WHERE `id` = ?');

    $stmt->bind_param('sssissdsssi', $dates, $desc, $details, $type, $participants, $venue, $fee, $deadline, $url, $tags, $id);

    // execute query
    $stmt->execute();

    echo "<script>alert('Post updated successfully!'); window.location.replace(aagents.phpp);</script>";
}

?>
