<?php include '../view/admin_manager/header_admin.php' ?>
<header>

    <h1>Reset Password User Form</h2>
    <h2>
        Resetting for User
        <?php 
            $selected_user = unserialize($_SESSION['selected_user']);
            echo $selected_user->getUserID()
        ?>
    </h2>
    <?php
        if (isset($_SESSION['admin_fail_msg'])) {
            echo $_SESSION['admin_fail_msg'];
        }
    ?>
</header>

<main>

          
    <form action="admin_management_controller.php" method="POST">
        <input type="hidden" name="action" value="reset_user_pw">

        <div class="input_container">
            <label for="user_password">New User Password</label>
            <input type="password" placeholder="Enter new password" name="user_password" value="" onkeypress="return event.charCode != 32" required><br>
        </div>
        <div class="input_container">
            <label for="user_password_retype">Retype User Password</label>
            <input type="password" placeholder="Retype new password" name="user_password_retype" value="" onkeypress="return event.charCode != 32" required><br>
            <strong id="match_msg">*passwords must match and be at least 8 characters in length</strong>
        </div>
        <div class="input_container">
            <label for="admin_password">Admin Password</label>
            <input type="password" placeholder="Enter admin password" name="admin_password" value="" onkeypress="return event.charCode != 32" required><br>
        </div>         
        
        <button id="reset_password" type="button" onclick="resetPassword();" disabled>Reset Password</button>
        <button id="cancel_changes" type="button" onclick="window.location.reload();" hidden>Cancel Reset</button>
        <button id="confirm_reset" type="submit" hidden>Confirm Reset</button>
        <button type="button" onclick="window.location.href='admin_management_controller.php?action=modify_user_form';">
            Back to Modify User List
        </button>
        <button type="button" onclick="window.location.href='admin_management_controller.php';">
            Back to Administration Manager
        </button>
        <button type="button" onclick="window.location.href='admin_management_controller.php?action=logout';">
            Logout
        </button>
    </form>
</main>
<script type="text/javascript" src="../js/page_manager.js"></script>
<?php include '../view/common/footer.php' ?>