<?php include '../view/admin_manager/header_admin.php' ?>
<header>
    <h1>Grower Account</h2>
    <h2>
        Account information for
        <?php 
            echo $user->getFirstName();
        ?>
    </h2>
    <h3>This page can be used to change your password.  All other fields cannot be edited.  Please contact the Administrator if any fields need updating.</h3>
</header>

<main>
          
    <form action="grower_consignment_controller.php" method="POST">
        <input type="hidden" name="action" value="update_user">

        <div class="input_container">
            <label for="grower_id">User ID</label>
            <input type="number" name="grower_id" min="1000" max="6999" placeholder="1234" value="<?php echo htmlspecialchars($user->getUserID()); ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user->getFirstName()); ?>" required disabled><br>
        </div>       
        <div class="input_container">
            <label for="surname">Surname</label>
            <input type="text" name="surname" value="<?php echo htmlspecialchars($user->getSurname()); ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="business_name">Business Name</label>
            <input type="text" name="business_name" value="<?php echo htmlspecialchars($user->getBusinessName()); ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="email">Email Address</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required disabled><br>
        </div>
        <div class="input_container">
            <label for="mobile">Mobile Number</label>
            <input type="tel" name="mobile" pattern="04[0-9]{8}" placeholder="0412345678" 
            minlength="10" maxlength="10" value="<?php echo htmlspecialchars($user->getPhoneNo()); ?>" required disabled><br>
        </div>
        <button type="button" onclick="window.location.href='grower_consignment_controller.php?action=change_password_form';">
            Change Password
        </button>
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