<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

    <!-- Page Content -->
    <div class="container-md">
        <header>
            <h1>Menu</h1>
        </header>
        <hr>
            <!-- Page Features -->
            <div class="row text-center">
                <!-- get_menu is defined in config.php, used to fetch menu from the menu table in dabax database -->
                <?php get_menu(); ?> 
            </div>
        <hr>
        <!-- Footer -->
    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>