<!-- JavaScript -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();

        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
        });
    });

</script>

</body>

<footer>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark footer">
        <div class="container">
            <div style="font-size: 15px; color: #A5A6A8; margin-top: 14px;">
                <p>© 2018 Maersk </p>
            </div>

            <div class="align-items-end mr-4" style="font-size: 15px; color: #f5f5f5;">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item mr-2">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</footer>

</html>
