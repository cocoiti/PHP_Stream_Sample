<?php
$lib = dirname(__FILE__) . '/../../libs/';
set_include_path(get_include_path() . PATH_SEPARATOR . $lib);
require dirname(__FILE__) . '/../../Stream_Smarty/Smarty.php';

// oh.....
Stream_Smarty::register();
Stream_Smarty::setTemplateDir(dirname(__FILE__) . '/templates/');
Stream_Smarty::setCompileDir('/tmp/');
Stream_Smarty::assign('a', 'a');
Stream_Smarty::assign('b', 'b');

require('smarty://test.tpl');
assert($a === 'a');
assert($b === 'b');

