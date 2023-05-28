<?php include '../view/admin_manager/header_admin.php' ?>
<header class="modUser">
    <h1>Report List</h2>
        <h2>Weekly Market Report – Report List</h2>
</header>

<main>
    <?php
    // Errors
    if (!empty($error)) {
        echo "<h3>" . $error . "</h3>";
    }
    ?>
    <section>
        <form class="searchForm" action="grower_consignment_controller.php" method="post">
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
                                        <form class="select_button" action="grower_consignment_controller.php" method="post">
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
                <div id="logout" class="button_box">
                    <button type="button" onclick="window.location.href='grower_consignment_controller.php';">
                        Back to Grower Manager
                    </button>
                    <br>
                    <button type="button" onclick="window.location.href='grower_consignment_controller.php?action=logout';">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../view/common/footer.php' ?>