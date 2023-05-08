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
  var consignment_form = $("#container_father");
  consignment_form.children().each(function () {
    $(this).attr("id", "container_child" + index);
    var label_index = 1;
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