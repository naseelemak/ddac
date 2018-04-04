<?php

$currentPage = 'Home';

include 'header.php';
include 'navbar.php';

?>

    <div class="homepage bg-ship text-white">
        <div class="container homepage-head">
            <h1 class="homepage-title">Maersk</h1>
            <h5 class="homepage-subtitle">Moving more than cargo.</h5>

            <h6 class="homepage-subtitle-btn">Login to begin.</h6>

            <div class="homepage-btn-area">
                <!-- Login Button -->
                <a class="btn btn-primary btn-lg homepage-btn" href="login.php" role="button">Login</a>
            </div>

            <!--            <ul class="homepage-tips-area">-->
            <!--                <a href="about.php" class="homepage-tips-item">-->
            <!--                    <li>-->
            <!--                        <hr class="homepage-line">-->
            <!--                        <div>-->
            <!--                            <h3 class="homepage-tips-title">About Us</h3>-->
            <!--                            <p class="homepage-tips-description">What does Maersk have to offer? Read-->
            <!--                                more over here.</p>-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                </a>-->
            <!---->
            <!---->
            <!--                <a href="contact.php" class="homepage-tips-item">-->
            <!--                    <li>-->
            <!--                        <hr class="homepage-line">-->
            <!--                        <div>-->
            <!--                            <h3 class="homepage-tips-title">Contact Us</h3>-->
            <!--                            <p class="homepage-tips-description">Have a question? Send us a message.</p>-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                </a>-->
            <!--            </ul>-->
        </div>
    </div>


<?php
include 'footer.php';
?>