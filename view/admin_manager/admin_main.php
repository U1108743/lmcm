<?php include '../view/admin_manager/header_admin.php' ?>

<header>
    <h1>Welcome <?php echo htmlspecialchars($user->getFirstName()); ?></h1>
    <h2>Administration Management</h2>
</header>

<main>
    <div id="admin_box">
        <div class="icon_box">
            <div class="admin_icon">
                <a href="?action=add_user_form">
                    <img src="../image/addUser1.png"></a>
                <br>
                <button onclick="window.location.href='?action=add_user_form';">
                    Add User
                </button>
            </div>

            <div class="admin_icon">
                <a href="?action=modify_user_form">
                    <img src="../image/editUser.png"></a>
                <br>
                <button onclick="window.location.href='?action=modify_user_form';">
                    Modify User
                </button>
            </div>

            <div class="admin_icon">
                <a href="?action=get_user_reports">
                    <img src="../image/reportControl.png"></a>
                <br>
                <button onclick="window.location.href='?action=get_user_reports';">
                    User Report
                </button>
            </div>

        </div>

        <div id="admin_logout">
            <button class="logout_button" onclick="window.location.href='admin_management_controller.php?action=logout';">
                Logout
            </button>
        </div>
        <div>

</main>

<?php include '../view/common/footer.php' ?>