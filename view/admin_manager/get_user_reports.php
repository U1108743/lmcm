<?php include '../view/admin_manager/header_admin.php' ?>
<header class="modUser">
    <h1>User Report</h2>

</header>

<main>
    <section>
        <div class="container_box">
            <div class="result_box">
                <h2>Entry 1</h2>
                <div class="upload">
                    <input type="file" name="fileupload" id="fileupload">
                </div>

                <br />
                <br />

                <table>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>
                            <select name="reportno" id="reportno">
                                <option value="report1">Report 1</option>
                                <option value="report2">Report 2</option>
                                <option value="report3">Report 3</option>
                            </select>
                        </td>
                        <td>
                            <input type="date" name="date" id="date">
                        </td>
                        <td>
                            <select name="metadata" id="metadata">
                                <option value="">metadata</option>
                                <option value="">metadata</option>
                                <option value="">metadata</option>
                            </select>
                        </td>
                        <td>
                            <button>
                                view pdf
                            </button>
                        </td>
                        <td>
                            <button>
                                Edit access
                            </button>
                        </td>
                </table>
            </div>
        </div>
    </section>


    <section>
        <div class="container_box">
            <div class="result_box">
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