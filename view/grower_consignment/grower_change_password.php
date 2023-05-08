<?php include '../view/admin_manager/header_admin.php' ?>
<header>

    <h1>Change Password Form</h2>
    <h2>
        Changing password for Grower 
        <?php 
            echo $user->getUserID()
        ?>
    </h2>
    <?php
        if (isset($_SESSION['grower_fail_msg'])) {
            echo $_SESSION['grower_fail_msg'];
        }
    ?>
</header>

<main>

          
    <form action="grower_consignment_controller.php" method="POST">
        <input type="hidden" name="action" value="change_password">

        <div class="input_container">
            <label for="user_password">New Password</label>
            <input type="password" placeholder="Enter new password" name="user_password" value="" onkeypress="return event.charCode != 32" required><br>
        </div>
        <div class="input_container">
            <label for="user_password_retype">Retype Password</label>
            <input type="password" placeholder="Retype new password" name="user_password_retype" value="" onkeypress="return event.charCode != 32" required><br>
            <strong id="match_msg">*passwords must match and be at least 8 characters in length</strong>
        </div>
        <div class="input_container">
            <label for="admin_password">Current Password</label>
            <input type="password" placeholder="Enter current password" name="current_password" value="" onkeypress="return event.charCode != 32" required><br>
        </div>         
        
        <button id="reset_password" type="button" onclick="resetPassword();" disabled>Change Password</button>
        <button id="cancel_changes" type="button" onclick="window.location.reload();" hidden>Cancel Password Change</button>
        <button id="confirm_reset" type="submit" hidden>Confirm Password Change</button>
        <button type="button" onclick="window.location.href='grower_consignment_controller.php';">
            Back to Grower Manager
        </button>
        <button type="button" onclick="window.location.href='grower_consignment_controller.php?action=logout';">
            Logout
        </button>
    </form>
</main>
<script type="text/javascript" src="../js/page_manager.js"></script>
<?php include '../view/common/footer.php' ?>