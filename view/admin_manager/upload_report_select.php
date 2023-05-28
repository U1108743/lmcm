<?php include '../view/admin_manager/header_admin.php' ?>
<header class="modUser">
    <h1>Upload Report</h2>
        <h2>Upload Report and Select Users With Access</h2>
</header>

<main>
    <?php
    if (!empty($error)) {
        echo "<h3>" . $error . "<h3>";
        unset($error);
    }
    if (!empty($upload_error)) {
        echo "<h3>" . $upload_error . "<h3>";
        unset($upload_error);
    }
    if (!empty($r_clash_msg)) {
        echo "<h3>" . $r_clash_msg . "</h3>";
    }
    ?>
    <?php
    if (isset($_SESSION['admin_fail_msg'])) {
        echo $_SESSION['admin_fail_msg'];
    }
    ?>

    <section>
        <div class="container_box">
            <form action="admin_management_controller.php" enctype="multipart/form-data" method="post">
                <input type="hidden" name="action" value="upload_report_selection">
                <input type="hidden" name="upload_date" value="<?php echo htmlspecialchars(date('Y-m-d H:i:s')); ?>">
                <label for="pdf_file">Click Edit Access & Select a File:</label>
                <div class="input_container">
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                    <input type="file" name="pdf_file" disabled required>
                    <label for="report_id">Report ID</label>
                    <input type="number" name="report_id" min="1000" max="8999" placeholder="1234" required disabled><br>
                </div>
                <?php if ($users) : ?>
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
                            <?php foreach ($users as $user) : ?>
                                <tr <?php echo htmlspecialchars(($user->getUserStatus()) ? 'class=active' : 'class=inactive'); ?>>
                                    <td><?php echo htmlspecialchars($user->getUserID()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getFirstName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getSurname()); ?></td>
                                    <td></td>
                                    <td><?php echo htmlspecialchars($user->getUserStatus()) ? 'Active' : 'Inactive'; ?></td>
                                    <td>
                                        <div class="input_container">
                                            <?php if ($user->getUserStatus() == 1) : ?>
                                                <input type="hidden" name="grower_id_list[]" value="<?php echo htmlspecialchars($user->getUserID()); ?>" checked>
                                                <input type="checkbox" name=grower_ids[] value=<?php echo htmlspecialchars($user->getUserID()) ?> checked disabled></input>
                                            <?php else : ?>
                                                <input type="hidden" name="grower_id_list[]" value="<?php echo htmlspecialchars($user->getUserID()); ?>" checked>
                                                <input type="checkbox" name=grower_ids[] value=<?php echo htmlspecialchars($user->getUserID()) ?> disabled></input>
                                            <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <label for="admin_password">Admin Password</label>
                <input type="password" placeholder="Enter admin password" name="admin_password" value="" onkeypress="return event.charCode != 32" required><br>

                <button id="edit_upload_access" type="button" onclick="editUploadAccess();">Upload & Edit Access</button>
                <button id="cancel_changes" type="button" onclick="window.location.reload();" hidden>Cancel Changes</button>
                <button id="upload_report" type="submit" disabled>Upload Report</button>
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
    </section>
</main>
<script type="text/javascript" src="../js/page_manager.js"></script>
<?php include '../view/common/footer.php' ?>
