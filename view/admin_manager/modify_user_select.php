<?php include '../view/admin_manager/header_admin.php' ?>
<header class="modUser">
    <h1>Modify User List</h2>
        <h2>Modify Grower or Administrator</h2>
</header>

<main>
    <section>
        <form class="searchForm" action="admin_management_controller.php" method="post">
            <input type="hidden" name="action" value="search_user">

            <label>Search:</label>
            <input type="text" name="search_input">
            <button type="submit">Search</button>
        </form>
    </section>

    <section>
        <div class="container_box">
            <div class="result_box">
                <h2>Results</h2>
                <?php if ($users) : ?>
                    <table class='result_table'>
                        <tbody>
                            <tr>
                                <th>Grower ID</th>
                                <th>First Name</th>
                                <th>Surname</th>
                                <th class="busName">Business Name</th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user->getUserID()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getFirstName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getSurname()); ?></td>
                                    <td class="busName"><?php echo htmlspecialchars($user->getBusinessName()); ?></td>
                                    <td>
                                        <form class="select_button" action="admin_management_controller.php" method="post">
                                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->getUserID()); ?>">
                                            <input type="hidden" name="action" value="modify_user">
                                            <button type="submit">Edit User
                                                <img src="../image/smallEditNB.png">
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form class="select_button" action="admin_management_controller.php" method="post">
                                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->getUserID()); ?>">
                                            <input type="hidden" name="action" value="user_pw_form">
                                            <button type="submit">Reset Password
                                                <img src="../image/smallPasswordreset.png">
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <div class="modUser">
                    <button type="button" onclick="window.location.href='admin_management_controller.php';">
                        Back to Administration Manager
                    </button>
                    <button type="button" onclick="window.location.href='admin_management_controller.php?action=logout';">
                        Logout
                    </button>
                </div>
            </div>
        </div>


    </section>

</main>

<?php include '../view/common/footer.php' ?>