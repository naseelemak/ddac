<div class="wrapper">

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="agent.php">
                <h3>Maersk</h3>
            </a>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="ship.php">Shipments</a>
            </li>
            <li>
                <a href="cust.php">Customers</a>
            </li>
            <li>
                <a href="item.php">Items</a>
            </li>
            <li>
                <a href="vess.php">Vessel</a>
            </li>

            <?php

            if (strcasecmp($_SESSION['role'], 'admin') == 0) {
                echo "<hr>";
                echo "<li>";
                echo "<a href='agent.php'>Agents</a>";
                echo "</li>";
            }

            ?>

            <hr class="d-lg-none d-xl-none">

            <li class="d-lg-none d-xl-none">
                <a href="../logout.php" class="dropdown-item">Logout</a>
            </li>
        </ul>
    </nav>
