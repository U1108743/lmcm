<?php include '../view/admin_manager/header_admin.php' ?>

<header>
    <h1>Add User Form</h2>
        <h2>Add New Grower or Administrator</h2>
</header>

<main>
    <?php
    if (!empty($g_clash_msg)) {
        echo "<h3>" . $g_clash_msg . "</h3>";
    }
    if (!empty($e_clash_msg)) {
        echo "<h3>" . $e_clash_msg . "</h3>";
    }
    ?>

    <form action="admin_management_controller.php" method="POST">
        <input type="hidden" name="action" value="add_grower">

        <div class="input_container">
            <label for="grower_id">Grower ID</label>
            <input type="number" name="grower_id" min="1000" max="8999" placeholder="1234" required><br>
        </div>
        <div class="input_container">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" required><br>
        </div>
        <div class="input_container">
            <label for="surname">Surname</label>
            <input type="text" name="surname" required><br>
        </div>
        <div class="input_container">
            <label for="business_name">Business Name</label>
            <input type="text" name="business_name" required><br>
        </div>
        <div class="input_container">
            <label for="email">Email Address</label>
            <input type="email" name="email" required><br>
        </div>
        <div class="input_container">
            <label for="mobile">Mobile Number</label>
            <input type="tel" name="mobile" pattern="04[0-9]{8}" placeholder="0412345678" minlength="10" maxlength="10" required><br>
        </div>
        <div class="input_container">
            <label class="match_password" for="user_password">Password</label>
            <input type="password" name="user_password" onkeypress="return event.charCode != 32" required><br>
        </div>
        <div class="input_container">
            <label class="match_password" for="user_password_retype">Re-type Password</label>
            <input type="password" name="user_password_retype" onkeypress="return event.charCode != 32" required>
            <strong id="match_msg">*passwords must match and be at least 8 characters long</strong><br>
        </div>
        <div class="input_container">
            <label for="user_type">User Type</label>
            <select name="user_type" required>
                <option value="grower" selected>Grower</option>
                <option value="admin">Administrator</option>
            </select><br>
        </div>
        <div class="input_container">
            <label for="user_status">Reporting Status</label>
            <select name="user_status" required>
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
            </select><br>
        </div>
        <button type="submit">Add User</button>
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