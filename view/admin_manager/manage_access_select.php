<?php include '../view/admin_manager/header_admin.php' ?>
<header class="modUser">
    <h1>Modify Access List for <?php echo htmlspecialchars($report->getReportFilename()); ?></h2>
        <h2>Edit Access for Individuals</h2>
</header>

<main>
    <?php
    if (!empty($error)) {
        echo "<h3>" . $error . "<h3>";
    }
    ?>
    <?php
    if (isset($_SESSION['admin_fail_msg'])) {
        echo $_SESSION['admin_fail_msg'];
    }
    ?>

    <section>
        <div class="container_box">
            <div class="result_box">
                <form action="admin_management_controller.php" method="post">
                    <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($report->getReportID()); ?>">
                    <input type="hidden" name="action" value="user_access_selection">
                    <?php if ($users_with_access) : ?>
                        <table class='result_table'>
                            <tbody>
                                <tr>
                                    <th>Grower ID</th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>&nbsp;</th>
                                    <th>Status</th>
                                    <th>Access</th>
                                </tr>
                                <?php foreach ($users_with_access as $user) : ?>
                                    <tr <?php echo htmlspecialchars(($user[0]->getUserStatus()) ? 'class=active' : 'class=inactive'); ?>>
                                        <td><?php echo htmlspecialchars($user[0]->getUserID()); ?></td>
                                        <td><?php echo htmlspecialchars($user[0]->getFirstName()); ?></td>
                                        <td><?php echo htmlspecialchars($user[0]->getSurname()); ?></td>
                                        <td></td>
                                        <td ><?php echo htmlspecialchars(($user[0]->getUserStatus()) ? 'Active' : 'Inactive'); ?></td>
                                        <td>
                                            <div class="input_container">
                                                <?php if ($user[1] == 'has_access') : ?>
                                                    <input type="hidden" name="grower_id_list[]" value="<?php echo htmlspecialchars($user[0]->getUserID()); ?>" checked>
                                                    <input type="checkbox" name=grower_ids[] value=<?php echo htmlspecialchars($user[0]->getUserID()) ?> checked disabled></input>
                                                <?php else : ?>
                                                    <input type="hidden" name="grower_id_list[]" value="<?php echo htmlspecialchars($user[0]->getUserID()); ?>" checked>
                                                    <input type="checkbox" name=grower_ids[] value=<?php echo htmlspecialchars($user[0]->getUserID()) ?> disabled></input>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <label for="admin_password">Admin Password</label>
                    <input type="password" placeholder="Enter admin password" name="admin_password" value="" onkeypress="return event.charCode != 32" required><br>

                    <button id="edit_access" type="button" onclick="editAccess();">Edit Access</button>
                    <button id="cancel_changes" type="button" onclick="window.location.reload();" hidden>Cancel Changes</button>
                    <button id="update_access" type="submit" disabled>Update Access</button>
                    <button type="button" onclick="window.location.href='admin_management_controller.php?action=manage_reports_select';">
                        Back to Report List
                    </button>
                    <button type="button" onclick="window.location.href='admin_management_controller.php';">
                        Back to Administration Manager
                    </button>
                    <button type="button" onclick="window.location.href='admin_management_controller.php?action=logout';">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript" src="../js/page_manager.js"></script>
<?php include '../view/common/footer.php' ?>