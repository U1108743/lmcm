<?php include '../view/grower_consignment/header_consignment.php' ?>

<main>
    <section>
    <header id="head">
        <h2>Consignment Review</h2>
    </header>
    <form id="review_form">
        <div class="form_box">
        <div id="consignment_start" class="consignment_box">
            <div class="consignment_details">
                <label class="label_name" for="consignment_date">Consignment Date</label>
                <input class="input_box" type="date" name="consignment_date" required><br>
            </div>
            <div class="consignment_details">
                <label class="label_name" for="market_location">Market Location</label>
                <select class="drop_down" name="market_location" required>
                    <option value="Not_Selected" disabled selected hidden></option>
                    <option value="BRISBANE">Brisbane</option>
                    <option value="SYDNEY">Sydney</option>
                    <option value="MELBOURNE">Melbourne</option>
                    <option value="ADELAIDE">Adelaide</option>
                    <option value="PERTH">Perth</option>
                </select>
            </div>
        </div>
        <div class="consignment_box">
            <h2>Entries</h2>
            <div id="review_main">
            <table border="0" id="review_table">
                <thead>
                <th>Fruit Variety</th>
                <th>Fruit Size</th>
                <th>Package Type</th>
                <th>Quantity</th>
                <th>Price</th>
                </thead>
                <tbody>
                <tr>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                </tr>
                <tr>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                </tr>
                <tr>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                </tr>
                <tr>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                    <td><input type="text"  /></td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div id="logout" class="button_box">
            <button type="button" onclick="window.location.href='grower_consignment_controller.php';">
                Edit Consignment
            </button> <br>
            <button type="button" onclick="window.location.href='grower_consignment_controller.php?action=consignment_submitted';">
                Submit
            </button>
        </div>
        </div>
    </form>
    </section>
</main>
<script type="text/javascript" src="../js/grower_consignment.js"></script>
<?php include '../view/common/footer.php' ?>

