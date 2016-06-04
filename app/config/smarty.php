<?php

// smarty.php - Configuration file for smarty
// By Anton Van Eechaute

include($project_dir . '/vendors/Smarty/Smarty.class.php');

$smarty = new Smarty();

$smarty->setTemplateDir($project_dir . 'app/templates');
$smarty->setCompileDir($project_dir . 'app/cache/smarty');

// add module specific template directories
$smarty->addTemplateDir($project_dir . 'src/Devine/Framework/templates');
