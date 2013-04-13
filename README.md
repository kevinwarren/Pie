# Pie v1.0.0
============

The `less`, `css` &amp; `js`, `compiler` &amp; `compressor`

### How to use Pie to compile less to css &amp; compress (minify) css &amp; js files into one css file & one js file

```php
<?php

# include pie class
require_once 'pie/pie.php';

# set comments for top of output files
$comments = "/*!\n";
$comments .= " * Something v1.0.0\n";
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
