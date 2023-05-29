<?php include '../view/admin_manager/header_admin.php' ?>
<header>
    <h1>Modify User Form</h2>
        <h2>
            Modifying User
            <?php
            $selected_user = unserialize($_SESSION['selected_user']);
            echo $selected_user->getUserID()
            ?>
        </h2>
</header>

<main>
    <?php
    if (!empty($g_clash_msg)) {
        echo "<h3>" . $g_clash_msg . "</h3>";
    }
    if (!empty($e_clash_msg)) {
        echo "<h3>" . $e_clash_msg . "</h3>";
    }
    if (!empty($other_error)) {
        echo "<h3>" . $e_clash_msg . "</h3>";
    }
    ?>
    <?php
    if (isset($_SESSION['admin_fail_msg'])) {
        echo $_SESSION['admin_fail_msg'];
    }
    ?>

    <form action="admin_management_controller.php" method="POST">
        <input type="hidden" name="action" value="update_user">

        <div class="input_container">
            <label for="grower_id">User ID</label>
            <input type="number" name="grower_id" min="1000" max="6999" placeholder="1234" value="<?php echo $selected_user->getUserID() ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" value="<?php echo $selected_user->getFirstName() ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="surname">Surname</label>
            <input type="text" name="surname" value="<?php echo $selected_user->getSurname() ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="business_name">Business Name</label>
            <input type="text" name="business_name" value="<?php echo $selected_user->getBusinessName() ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="email">Email Address</label>
            <input type="email" name="email" value="<?php echo $selected_user->getEmail() ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="mobile">Mobile Number</label>
            <input type="tel" name="mobile" pattern="04[0-9]{8}" placeholder="0412345678" minlength="10" maxlength="10" value="<?php echo $selected_user->getPhoneNo() ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="user_type">User Type</label>
            <select name="user_type" required disabled>
                <?php if ($selected_user->getUserType() == "grower") : ?>
                    <option value="grower" selected>Grower</option>
                    <option value="admin">Administrator</option>
                <?php else : ?>
                    <option value="grower">Grower</option>
                    <option value="admin" selected>Administrator</option>
                <?php endif; ?>
            </select><br>
        </div>
        <div class="input_container">
            <label for="user_status">Reporting Status</label>
            <select name="user_status" required disabled>
                <?php if ($selected_user->getUserStatus() == 1) : ?>
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                <?php else : ?>
                    <option value="1">Active</option>
                    <option value="0" selected>Inactive</option>
                <?php endif; ?>
            </select><br>
        </div>
        <div class="input_container">
            <label for="admin_password">Admin Password</label>
            <input type="password" placeholder="Enter admin password" name="admin_password" value="" onkeypress="return event.charCode != 32" required><br>
        </div>
        <button id="edit_user" type="button" onclick="editUser();">Edit User</button>
        <button id="cancel_changes" type="button" onclick="window.location.reload();" hidden>Cancel Changes</button>
        <button id="update_user" type="submit" disabled>Update User</button>
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