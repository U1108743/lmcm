<?php include '../view/admin_manager/header_admin.php' ?>
<header class="modUser">
    <h1>Report List</h2>
        <h2>View Reports or Change Access</h2>
</header>

<main>
    <?php
    // Errors
    if (!empty($error)) {
        echo "<h3>" . $error . "</h3>";
    }
    if (!empty($_SESSION['message_type']) && $_SESSION['message_type'] == 'update_access') {
        echo "<h3>" . $_SESSION['change_access_msg'] . "</h3>";
        // clear the message buffer
        unset($_SESSION['message_type']);
        unset($_SESSION['change_access_message']);
    } ?>
    <section>
        <form class="searchForm" action="admin_management_controller.php" method="post">
            <input type="hidden" name="action" value="search_report">

            <label>Search:</label>
            <input type="text" name="search_input">
            <button type="submit">Search</button>
        </form>
    </section>

    <section>
        <div class="container_box">
            <div class="result_box">
                <h2>Results</h2>
                <?php if ($reports) : ?>
                    <table class='result_table'>
                        <tbody>
                            <tr>
                                <th>Report Title</th>
                                <th>Date Uploaded</th>
                                <th>File Size</th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php foreach ($reports as $report) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($report->getReportFilename()); ?></td>
                                    <td><?php echo htmlspecialchars($report->getUploadDate()); ?></td>
                                    <td><?php echo htmlspecialchars($report->getFormattedReportSize()); ?></td>
                                    <td>
                                        <form class="select_button" action="admin_management_controller.php" method="post">
                                            <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($report->getReportID()); ?>">
                                            <input type="hidden" name="action" value="manage_access_select">
                                            <button type="submit">Edit Access List
                                                <img src="../image/smallEditNB.png">
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form class="select_button" action="admin_management_controller.php" method="post">
                                            <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($report->getReportID()); ?>">
                                            <input type="hidden" name="action" value="view_report">
                                            <button type="submit" formtarget="_blank">View Report
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
                    <button type="button" onclick="window.location.href='admin_management_controller.php?action=upload_report';">
                        Upload New Report
                    </button>
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