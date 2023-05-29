<?php include '../view/grower_consignment/header_consignment.php' ?>

<main>
    <section>
        <header id="head">
            <h2><?php echo $user->getFirstName() . " your consignment has been submitted!"; ?></h2>
            <h3><?php echo "Your consignment id is <strong>" . $_SESSION["consignment_id"] . "</strong>"; ?></h3>
        </header>
        <div class="admin_icon">
            <button onclick="window.location.href='grower_consignment_controller.php?action=goto_grower_consignment';">
                New Consignment
            </button>
            <br>
            <button onclick="window.location.href='grower_consignment_controller.php';">
                Back to Grower Manager
            </button>
            <br>
            <button onclick="window.location.href='grower_consignment_controller.php?action=logout';">
                Logout
            </button>
        </div>
    </section>
</main>

<?php include '../view/common/footer.php' ?>