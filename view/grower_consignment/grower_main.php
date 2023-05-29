<?php include '../view/admin_manager/header_admin.php' ?>

<header>
    <h1>Welcome <?php echo htmlspecialchars($user->getFirstName()); ?></h1>
    <h2>Grower Management</h2>
</header>

<main>
    <div id="admin_box">
        <div class="icon_box">
            <div class="admin_icon">
                <a href="?action=grower_account">
                <img src="../image/growerAccount.png"></a>
                <br>
                <button onclick="window.location.href='?action=grower_account';">
                Account
                </button>
            </div>

            <div class="admin_icon">
                <a href="?action=goto_grower_consignment">
                <img src="../image/consignment.png"></a>
                <br>
                <button onclick="window.location.href='?action=goto_grower_consignment';">
                Consignment
                </button>
            </div>
            
            <div class="admin_icon">
                <a href="?action=grower_view_reports">
                <img src="../image/consignment.png"></a>
                <br>
                <button onclick="window.location.href='?action=grower_view_reports';">
                Reports
                </button>
            </div>

        </div>

        <div id="admin_logout">
            <button class="logout_button" onclick="window.location.href='grower_consignment_controller.php?action=logout';">
                Logout
            </button>
        </div>
    <div>

</main>

<?php include '../view/common/footer.php' ?>