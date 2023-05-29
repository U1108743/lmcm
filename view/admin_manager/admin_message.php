<?php include '../view/admin_manager/header_admin.php' ?>

<main>
    <section>
        <header id="head">
            <?php echo $_SESSION['add_user_submission_msg']; ?>
        </header>
        <div class="icon_box">
            <div class="admin_icon">
                <button onclick="window.location.href='admin_management_controller.php';">
                    Back to Administration Manager
                </button>
                <br>
                <?php if ($_SESSION['message_type'] == 'add_user') : ?>
                    <button onclick="window.location.href='admin_management_controller.php?action=add_user_form';">
                        Add Another User
                    </button>
                <?php elseif ($_SESSION['message_type'] == 'update_user') : ?>
                    <button onclick="window.location.href='admin_management_controller.php?action=modify_user_form';">
                        Modify Another User
                    </button>
                <?php elseif ($_SESSION['message_type'] == 'reset_user_pw') : ?>
                    <button onclick="window.location.href='admin_management_controller.php?action=modify_user_form';">
                        Modify Another User
                    </button>
                <?php endif; ?>
                <br>
                <button onclick="window.location.href='admin_management_controller.php?action=logout';">
                    Logout
                </button>
            </div>
        </div>
    </section>
</main>

<?php include '../view/common/footer.php' ?>