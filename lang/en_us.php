<?php

/*
Form Tools - Module Language File
---------------------------------

File created: Oct 24th 2007, 2:46 AM

If you would like to help translate Form Tools, please visit:
http://www.formtools.org/translations/
*/

$L = array();

// REQUIRED fields
$L["module_name"] = "Submission ID Manager";
$L["module_description"] = "This module provides advanced controls for form submission IDs: resetting or changing the submission ID number.";

// other fields
$L["phrase_module_title"] = "Submission ID Manager";
$L["phrase_delete_submissions"] = "Delete Submissions";
$L["phrase_select_form"] = "Select Form";
$L["phrase_change_submission_id"] = "Change submission ID";
$L["phrase_change_next_submission_id_to_c"] = "Change next submission ID to:";
$L["phrase_delete_form_submissions_and_reset"] = "Delete form submissions and reset submission ID to zero";

$L["text_module_summary"] = "This module lets you modify or reset the submission IDs for your forms. Note you can only reset the submission ID count for EMPTY forms, and you cannot change the submission ID count to a number lower than the highest submission ID. For convenience, the highest submission ID for each form is provided in parentheses. If the highest submission ID appears as \"unknown\", there are no submissions in the form.";

$L["validation_no_submission_id"] = "Please enter the submission ID that you would like to change.";
$L["validation_invalid_submission_id"] = "Please only enter a numerical value for the next submission ID.";

$L["confirm_truncate_form"] = "Are you sure you want to do this? This will delete all submissions for this form.";

$L["notify_submission_id_changed"] = "The form submission ID counter has been updated.";
$L["notify_submission_id_not_changed"] = "The next form submission ID has not been updated.";
$L["notify_form_submissions_deleted"] = "The form submissions have been deleted and the submission ID count has been reset to zero.";