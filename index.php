<?php

require_once("../../global/library.php");

use FormTools\Core;
use FormTools\Forms;
use FormTools\Modules;

$module = Modules::initModulePage("admin");
$L = $module->getLangStrings();
$LANG = Core::$L;
$db = Core::$db;

// change the next submission ID counter
$success = true;
$message = "";
if (isset($request["update"])) {
    $form_id = $request["form_id"];
    $next_submission_id = $request["next_submission_id"];

    // add a little server-side check, just in case!
    if (empty($next_submission_id) && $next_submission_id !== "0") {
        $success = true;
        $message = $L["validation_no_submission_id"];
    } else {
        $db->query("ALTER TABLE {PREFIX}form_{$form_id} AUTO_INCREMENT = $next_submission_id");
        $db->execute();
        $success = true;
        $message = $L["notify_submission_id_changed"];
    }
} // empty the table, resetting the submission ID counter
else {
    if (isset($request["delete"])) {
        $form_id = $request["form_id"];
        $db->query("TRUNCATE TABLE {PREFIX}form_{$form_id}");
        $db->execute();

        $success = true;
        $message = $L["notify_form_submissions_deleted"];
    }
}


// retrieve all information that the template needs
$forms = Forms::getForms();
$dropdown_info = array();
foreach ($forms as $form_info) {
    $form_id = $form_info["form_id"];

    if ($form_info["is_complete"] == "no") {
        continue;
    }

    // now find the highest submission ID from this form
    $db->query("
        SELECT submission_id
        FROM   {PREFIX}form_{$form_id}
        ORDER BY submission_id DESC
        LIMIT 1
    ");
    $db->execute();

    $count = "unknown";
    if ($db->numRows() == 1) {
        $count = $db->fetch(PDO::FETCH_COLUMN);
    }

    $dropdown_info[$form_id] = "{$form_info["form_name"]} ($count)";
}

// store the information that we're going to pass to the templates in $theme_vars
$page_vars = array(
    "g_success" => $success,
    "g_message" => $message,
    "dropdown_info" => $dropdown_info
);

$page_vars["head_js"] = <<< EOF
$(function() {
  // form 1: check the user has entered a valid submission ID
  $("#change_submission_id_form").bind("submit", function(e) {
    var rules = [];
    rules.push("required,next_submission_id,{$L["validation_no_submission_id"]}");
    rules.push("digits_only,next_submission_id,{$L["validation_invalid_submission_id"]}");
    if (!rsv.validate(this, rules)) {
      e.preventDefault();
    }
  });

  // form 2: check the user really wants to delete all submissions
  var dialog = $("<div></div>");
  $('#delete').bind("click", function(e) {
    ft.create_dialog({
      dialog:     dialog,
      title:      "{$LANG["phrase_please_confirm"]}",
      content:    "{$L["confirm_truncate_form"]}",
      popup_type: "warning",
      buttons: [{
        text:  "{$LANG["word_yes"]}",
        click: function() {
          $("#truncate_form").trigger("submit");
        }
      },
      {
        text:  "{$LANG["word_no"]}",
        click: function() {
          $(this).dialog("close");
        }
      }]
    });
  });
});
EOF;

// load the template page with our custom info
$module->displayPage("templates/index.tpl", $page_vars);
