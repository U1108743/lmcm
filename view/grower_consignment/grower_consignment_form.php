<?php include '../view/grower_consignment/header_consignment.php' ?>
<main>
    <section>
        <header id="head">
            <h2>Weekly Market Report</h2>
        </header>
        <form id="consignment_form" name="consignment_form" action="grower_consignment_controller.php" method="post">
            <div class="form_box">
                <input type="hidden" name="action" value="submit_consignment">
                <input id="entry_number" type="hidden" name="entry_number" value="1">
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
                    <h2>Entry 1</h2>
                    <div id="consignment_main">
                        <div id="consignment_entry1">
                            <div class="input_container">
                                <label class="label_name" for="fruit_variety1">Fruit Variety</label>
                                <select class="drop_down" name="fruit_variety1" required>
                                    <option value="None" disabled selected hidden></option>
                                    <option value="Jiro">Jiro</option>
                                    <option value="Fuyu">Fuyu</option>
                                    <option value="Other sweet">Other sweet varieties</option>
                                    <option value="Astringent">Astringent varieties</option>
                                </select>
                            </div>
                            <div class="input_container">
                                <label class="label_name" for="fruit_size1">Fruit Size</label>
                                <select class="drop_down" name="fruit_size1" required>
                                    <option value="None" disabled selected hidden></option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    <option value="18">18</option>
                                    <option value="20">20</option>
                                    <option value="23">23</option>
                                    <option value="25">25</option>
                                    <option value="28">28</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                            <div class="input_container">
                                <label class="label_name" for="package_type1">Package Type</label>
                                <select class="drop_down" name="package_type1" required>
                                    <option value="None" disabled selected hidden></option>
                                    <option value="Trays">Tray (4kg)</option>
                                    <option value="Boxes">Box (10kg)</option>
                                </select>
                            </div>
                            <div class="input_container">
                                <label class="label_name" for="quantity1">Quantity</label>
                                <input class="input_box" name="quantity1" type="number" min="1" max="1000" required>
                            </div>
                            <div class="input_container">
                                <label class="label_name" for="price1">Price</label>
                                <input class="input_box" name="price1" type="number" min="0.00" step="0.01" required>
                            </div>
                            <div class="input_container">
                                <button class="consignment_button remove_entry" type="button">
                                    <img src="../image/remove.png">
                                    <div class="button_text"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="consignment_add_remove">
                        <button class="consignment_button add_entry" type="button">
                            <img src="../image/add1.png">
                            <div class="button_text">Add Entry</div>
                        </button>
                    </div>
                </div>
                <div class="consignment_box comment_box">
                    <label class="label_name" for="comment_choice">Would you like to leave a comment?</label>
                    <input class="comment_choice_radio" type="radio" name="comment_choice" value="yes" required>
                    <label class="radio_label" for="yes">Yes</label>
                    <input class="comment_choice_radio" type="radio" name="comment_choice" value="no" required>
                    <label class="radio_label" for="no">No</label>
                    <div class="comment_text" hidden>
                        <label for="comment_text"></label>
                        <textarea form="consignment_form" name="comment_text" id="comment_area" rows="8" cols="80" placeholder="add comments here..." required></textarea>
                    </div>
                </div>
                <div id="consignment_submit" class="button_box">
                    <button type="submit">Submit</button>
                </div>
                <div id="logout" class="button_box">
                    <button type="button" onclick="window.location.href='grower_consignment_controller.php';">
                        Back to Grower Manager
                        <br>
                        <button type="button" onclick="window.location.href='grower_consignment_controller.php?action=logout';">
                            Logout
                        </button>
                </div>
            </div>
            </div>
            </div>
        </form>
    </section>
</main>
<script type="text/javascript" src="../js/grower_consignment.js"></script>
<?php include '../view/common/footer.php' ?>