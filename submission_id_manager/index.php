<?php

require_once("../../global/library.php");
ft_init_module_page();

$request = array_merge($_POST, $_GET);

// change the next submission ID counter
if (isset($request["update"]))
{
  $form_id = $request["form_id"];
  $next_submission_id = $request["next_submission_id"];

  // add a little server-side check, just in case!
  if (empty($next_submission_id) && $next_submission_id !== "0")
  {
    $g_success = true;
    $g_message = $L["validation_no_submission_id"];
  }
  else
  {
    mysql_query("ALTER TABLE {$g_table_prefix}form_{$form_id} AUTO_INCREMENT = $next_submission_id");
    $g_success = true;
    $g_message = $L["notify_submission_id_changed"];
  }
}

// empty the table, resetting the submission ID counter
else if (isset($request["delete"]))
{
  $form_id = $request["form_id"];
  mysql_query("TRUNCATE TABLE {$g_table_prefix}form_{$form_id}");

  $g_success = true;
  $g_message = $L["notify_form_submissions_deleted"];
}


// retrieve all information that the template needs
$forms = ft_get_forms();
$dropdown_info = array();
foreach ($forms as $form_info)
{
  $form_id = $form_info["form_id"];

  if ($form_info["is_complete"] == "no")
    continue;

  // now find the highest submission ID from this form
  $query = mysql_query("
    SELECT submission_id
    FROM   {$g_table_prefix}form_{$form_id}
    ORDER BY submission_id DESC
    LIMIT 1
      ");

  $count = "unknown";
  if (mysql_num_rows($query) == 1)
  {
    $info = mysql_fetch_assoc($query);
    $count = $info["submission_id"];
  }

  $dropdown_info[$form_id] = "{$form_info["form_name"]} ($count)";
}

// ----------------------------------------------------------------------------------

// store the information that we're going to pass to the templates in $theme_vars
$page_vars = array();
$page_vars["dropdown_info"] = $dropdown_info;
$page_vars["head_js"] =<<< EOF
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
ft_display_module_page("index.tpl", $page_vars);
