<?php include '../view/grower_consignment/header_consignment.php'?>

<main>
    <section>
        <header id="head">
            <?php echo $_SESSION['add_grower_submission_msg']; ?>
        </header>
        <div class="admin_icon">

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

<?php include '../view/common/footer.php'?>