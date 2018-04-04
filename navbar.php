<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand mr-5" href="index.php">WOKO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item mr-2">
                    <a class="nav-link" href="comp.php">Competitions</a>
                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item dropdown mr-4">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        User Guide
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="guide-student.php">Students</a>
                        <a class="dropdown-item" href="guide-organiser.php">Organisers</a>
                    </div>
                </li>
            </ul>
            <div class="my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                    <?php
                    // if user session is set, display username dropdown
                    if (isset($_SESSION['user'])) {
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hi, ' .
                            $_SESSION["user"] . '&nbsp;</a>';
                        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                        echo '<a class="dropdown-item" href="profile.php">Profile</a>';
                        echo '<a class="dropdown-item" href="change-password.php">Change Password</a>';
                        echo '<div class="dropdown-divider"></div>';
                        echo '<a href="../logout.php" class="dropdown-item">Logout</a>';
                        echo '</div>';
                        echo '</li>';
                    } // else display login / register button
                    else {
                        echo '<li class="nav-item mr-4">
                            <a class="nav-link" href="../misc/login.php">Login / Register</a>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</nav>
