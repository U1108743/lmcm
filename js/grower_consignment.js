// Keeps track of the number of entry forms
counter = 1;

//Event listener for adding new entry form
$(document).on("click", ".add_entry", function (events) {
    addEntry();
});

//Event Listener for removing entry form
$(document).on("click", ".remove_entry", function (events) {
    removeEntry($(this).parent().parent());
});

//Event listener for radio buttons on consignment form page
$(":radio[name=comment_choice]").on("click", function () {
    if ($(":radio[name=comment_choice]:checked").val() == "yes") {
        $(".comment_text").show();
        $("#comment_area").prop("required", true);
    } else {
        $(".comment_text").hide();
        $("#comment_area").prop("required", false);
    }
});

/**
 * FUNCTION: addEntry
 *
 * Appends a new entry form to the end of the consignment
 *
 * @param none
 * @return none
 */

function addEntry() {
    counter++;
    $("#consignment_entry1")
        .clone()
        .find("input")
        .val("")
        .end()
        .appendTo("#consignment_main");
    relabelEntries();
}

/**
 * FUNCTION: removeEntry
 *
 * Removes an entry form based on the button clicked
 *
 * @param parent -> jquery object of entry form to delete
 * @return none
 */

function removeEntry(parent) {
    if (counter > 1) {
        counter--;
        parent.remove();
        relabelEntries();
    } else {
        alert("Attention: You must have at least one entry form!");
    }
}

/**
 * FUNCTION: relabelEntries
 *
 * When an entry form is added or removed this function will
 * relabel the html attributes of each entry form so that they
 * are in incremental order
 *
 * @param none
 * @return none
 */

function relabelEntries() {
    var index = 1;
    var consignment_form = $("#consignment_main");
    consignment_form.children().each(function () {
        $(this).attr("id", "consignment_entry" + index);
        var label_index = 1;
        $(this).children(".header").text("Entry " + index);
        $(this)
            .children(".input_container")
            .each(function () {
                switch (label_index) {
                    case 1:
                        $(this)
                            .children(".label_name")
                            .attr("for", "fruit_variety" + index);
                        $(this)
                            .children(".drop_down")
                            .attr("name", "fruit_variety" + index);
                        break;
                    case 2:
                        $(this)
                            .children(".label_name")
                            .attr("for", "fruit_size" + index);
                        $(this)
                            .children(".drop_down")
                            .attr("name", "fruit_size" + index);
                        break;
                    case 3:
                        $(this)
                            .children(".label_name")
                            .attr("for", "package_type" + index);
                        $(this)
                            .children(".drop_down")
                            .attr("name", "package_type" + index);
                        break;
                    case 4:
                        $(this)
                            .children(".label_name")
                            .attr("for", "quantity" + index);
                        $(this)
                            .children(".input_box")
                            .attr("name", "quantity" + index);
                        break;
                    case 5:
                        $(this)
                            .children(".label_name")
                            .attr("for", "price" + index);
                        $(this)
                            .children(".input_box")
                            .attr("name", "price" + index);
                        break;
                }
                label_index++;
            });

        index++;
    });

    //setting number of entries that will be submitted for global use
    $("#entry_number").attr("value", index - 1);
}

jQuery.fn.extend({
    renameAttr: function (name, newName, removeData) {
        var val;
        return this.each(function () {
            val = jQuery.attr(this, name);
            jQuery.attr(this, newName, val);
            jQuery.removeAttr(this, name);
            // move original data
            if (removeData !== false) {
                jQuery.removeData(this, name.replace("data-", ""));
            }
        });
    },
});


/* Show Review */
// switch from editing consignment to reviewing but only if all required fields are valid

function showReview() {

    // Check required field validity
    // assume true, any falses lead to false
    if (typeof showReview.validity == 'undefined') {
        showReview.validity = true;
    }

    // Check consignment date is a valid date
    showReview.validity &&= !(Number.isNaN(Date.parse($("#consignment_form_editing").find("[name=consignment_date]").val())));

    // Check market location has been selected
    showReview.validity &&= !($("#consignment_form_editing").find("[name=market_location]").children("option:selected").val() == "Not_Selected");

    // Check if any value in any entry is empty or not selected
    $("#consignment_form_editing").find("#consignment_main").children().each(function () {
        $(this)
            .children(".input_container")
            .each(function () {
                // if it has a selection drop down
                if ($(this).has("select").length) { showReview.validity &&= !($(this).children("select").children("option:selected").val() == "None"); }
                // if it has a number input
                if ($(this).has("input").length) { showReview.validity &&= !($(this).children("input").val().length == 0); }
            });
    });

    // Check if comment radio choice has an option selected
    showReview.validity &&= !($("#consignment_form_editing").find("input[name='comment_choice']:checked").length == 0);

    // Check if comment has text if the box is "yes"
    if ($("#consignment_form_editing").find("input[name='comment_choice']:checked").val() == "yes") {
        showReview.validity &&= !($("#consignment_form_editing").find("textarea[name='comment_text']").val() == "");
    }

    // If anything isn't valid don't toggle and instead show showReview.validity message
    if (!showReview.validity) {
        $(".invalid_input").show();
        // and reset the showReview.validity
        showReview.validity = true;
        return false;
    }

    // If we get here everything is valid we should hide the message
    $(".invalid_input").hide();
    // and reset the showReview.validity
    showReview.validity = true;

    // Hide form
    $("#consignment_form_editing").toggle();

    // Copy data to review form to show
    $('.form_data').clone().appendTo(".consignment_review_form");

    // Remove unnecessary buttons and text
    $(".consignment_review_form").find(".remove_entry").remove();
    $(".consignment_review_form").find(".add_entry").remove();
    $(".consignment_review_form").find(".comment_choice_radio").remove();
    $(".consignment_review_form").find(".radio_label").remove();

    // Check if comment has text if the box is "yes"
    if ($("#consignment_form_editing").find("input[name='comment_choice']:checked").val() == "yes") {
        //Change text where appropriate
        $(".consignment_review_form").find(".comment_box").children(".label_name").text("Comment:");
    }

    // Add selected values to review form and tidy entry header spacing
    $(".consignment_review_form").find("#consignment_main").children().each(function () {
        var value_index = 1;
        $(this).children(".header").after("<br />");
        $(this)
            .children(".input_container")
            .each(function () {
                switch (value_index) {
                    case 1:
                        var name = $(this).children(".drop_down").attr('name');
                        var selectedValue = $("#consignment_form_editing").find("[name=" + name + "]" + " option:selected").val();
                        $(this).children(".drop_down").find("option[value = '" + selectedValue + "']").attr("selected", "selected");
                        break;
                    case 2:
                        var name = $(this).children(".drop_down").attr('name');
                        var selectedValue = $("#consignment_form_editing").find("[name=" + name + "]" + " option:selected").val();
                        $(this).children(".drop_down").find("option[value = '" + selectedValue + "']").attr("selected", "selected");
                        break;
                    case 3:
                        var name = $(this).children(".drop_down").attr('name');
                        var selectedValue = $("#consignment_form_editing").find("[name=" + name + "]" + " option:selected").val();
                        $(this).children(".drop_down").find("option[value = '" + selectedValue + "']").attr("selected", "selected");
                        break;
                }
                value_index++;
            });

    })

    // Add market location selection
    var selectedMarketLocation = $("#consignment_form_editing").find("[name=market_location]" + " option:selected").val();
    $(".consignment_review_form").find("#consignment_start").children(".consignment_details").children(".drop_down").find("option[value = '" + selectedMarketLocation + "']").attr("selected", "selected");


    // Disable inputs
    $(".consignment_review_form").find("#consignment_main").children().each(function () {
        $(this)
            .children(".input_container")
            .each(function () {
                $(this).children("input" | "select").each(function () {
                    $(this).attr("disabled", "true");
                });
            });
    })

    $(".consignment_review_form").find("#consignment_start").children().each(function () {
        $(this)
            .children("input" | "select")
            .each(function () {
                $(this).attr("disabled", "true");
            });
    })

    $(".consignment_review_form").find(".comment_box").children(".comment_text").children("#comment_area").attr("disabled", "true");

    // Show review
    $("#consignment_review").toggle();
}

/* Show Review */
// switch from reviewing consignment to editing

function editConsignment() {
    // Show form
    $("#consignment_form_editing").toggle();
    // Remove copy
    $(".consignment_review_form").empty();
    // Hide review
    $("#consignment_review").toggle();
    // Hide invalid input message
    $(".invalid_input").hide();
}
