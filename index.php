<?php

# include pie class
require_once 'pie/pie.php';

# set comments for top of output files
$comments = "/*!\n";
$comments .= " * Pie v1.1.0\n";
$comments .= " * Last Edit " . date('d/m/Y') . "\n";
$comments .= " *\n";
$comments .= " * Copyright (c) " . date('Y') . " Kevin Warren\n";
$comments .= " * Licensed under the The MIT License (MIT)\n";
$comments .= " * http://opensource.org/licenses/MIT\n";
$comments .= " *\n";
$comments .= " * Includes:\n";
$comments .= " * lessphp http://leafo.net/lessphp also licensed under the The MIT License (MIT)\n";
$comments .= " * php-yui-compressor https://github.com/gpbmike/PHP-YUI-Compressor\n";
$comments .= " * BootstrapCDN http://www.bootstrapcdn.com\n";
$comments .= " */\n";

#set options for pie
$options = array('comments'=>$comments, 'cssOutputPath'=>'assets/css/pie.min.css', 'jsOutputPath'=>'assets/css/pie.min.js', 'linebreak'=>false, 'verbose'=>false, 'nomunge'=>false, 'semi'=>false, 'nooptimize'=>false);

# invoke pie class with options which are all optional
$pie = new pie($options);

# add a file
$pie->add('assets/less/pie.less');

# bake that pie & save minified files
$pie->bake();

?>
