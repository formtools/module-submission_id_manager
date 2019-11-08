<?php


namespace FormTools\modules\SubmissionIdManager;

use FormTools\Module as FormToolsModule;


class Module extends FormToolsModule
{
    protected $moduleName = "Submission ID Manager";
    protected $moduleDesc = "This module provides advanced controls for form submission IDs: resetting or changing the submission ID number.";
    protected $author = "Ben Keen";
    protected $authorEmail = "ben.keen@gmail.com";
    protected $authorLink = "https://formtools.org";
    protected $version = "2.0.2";
    protected $date = "2019-11-07";
    protected $originLanguage = "en_us";

    protected $nav = array(
        "module_name" => array("index.php", false)
    );
}
