# Pie v1.1.1
============

Pie is a PHP class to compile less to css and compress/minify css &amp; js files eg. `pie.min.css` &amp; `pie.min.js`

The Pie class makes use of:

lessphp <http://leafo.net/lessphp> also licensed under the The MIT License (MIT)

php-yui-compressor <https://github.com/gpbmike/PHP-YUI-Compressor>

BootstrapCDN <http://www.bootstrapcdn.com>

### How to use Pie to 

```php
<?php

# include pie class
require_once 'pie/pie.php';

# set comments for top of output files
$comments = "/*!\n";
$comments .= " * Something v1.1.1\n";
$comments .= " * Last Edit " . date('d/m/Y') . "\n";
$comments .= " *\n";
$comments .= " * Copyright (c) " . date('Y') . " Someone\n";
$comments .= " * Licensed under the The MIT License (MIT)\n";
$comments .= " * http://opensource.org/licenses/MIT\n";
$comments .= " */\n";

#set options for pie
$options = array('comments'=>$comments, 'cssOutputPath'=>'assets/css/pie.min.css', 'jsOutputPath'=>'assets/css/pie.min.js', 'linebreak'=>false, 'verbose'=>false, 'nomunge'=>false, 'semi'=>false, 'nooptimize'=>false);

# invoke pie class with options which are all optional
$pie = new pie($options);

# add files
$pie->add('assets/less/pie.less');
$pie->add('assets/css/pie.css');
$pie->add('assets/js/pie.js');
$pie->add('assets/js/pie-more.js');

# bake that pie & save minified files
$pie->bake();

?>
```
