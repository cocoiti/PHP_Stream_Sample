<?php
$lib = dirname(__FILE__) . '/../../libs/';
set_include_path(get_include_path() . PATH_SEPARATOR . $lib);
require dirname(__FILE__) . '/../../Stream_Raw/Raw.php';


Stream_Raw::register();
$php = <<<EOD_PHP
<?php
  \$a = 'a';
  \$b = 'b';
EOD_PHP;



require('raw://' . $php);
assert($a === 'a');
assert($b === 'b');

