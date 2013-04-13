<?php
/*!
 * Pie v1.0.0
 * Last Edit 13/04/2013
 *
 * Copyright (c) 2013 Kevin Warren
 * Licensed under the The MIT License (MIT)
 * http://opensource.org/licenses/MIT
 */

# include lessphp class - http://leafo.net/lessphp/
require_once 'lessc.inc.php';
 
# include php-yui-compressor class - https://github.com/gpbmike/PHP-YUI-Compressor
require_once 'yuicompressor.php';

# pie class
class pie {
  
	# set current yuicompressor.jar file - http://yui.github.io/yuicompressor/
	private $jarPath = 'pie/yuicompressor-2.4.7.jar';
	
	# set temp path directory for php-yui-compressor
	private $tempPath = 'pie/temp/';
	
	# set options for pie/php-yui-compressor
	private $options = array('comments'=>'', 'cssOutputPath'=>'assets/css/pie.min.css', 'jsOutputPath'=>'assets/css/pie.min.js', 'linebreak'=>false, 'verbose'=>false, 'nomunge'=>false, 'semi'=>false, 'nooptimize'=>false);
	
	private $less;
	private $yui;
	private $css = '';
	private $js = '';
	private $cssMin = '';
	private $jsMin = '';
	
	# __construct the base of pie
	public function __construct($options = array()) {
		
		echo '<!DOCTYPE html><html lang="en"><head><title>Pie - The less, css &amp; js, compiler &amp; compressor</title>';
		echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
		#echo '<link rel="stylesheet" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css">';
		echo '<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/2.3.1/spacelab/bootstrap.min.css">';
		echo '<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->';
		echo '</head><body><div class="container-fluid">';
		
		echo '<h1 class="well">Pie - The less, css &amp; js, compiler &amp; compressor</h1>';
		
		$error = false;
		# check yuicompressor.jar file exists
		if (!is_file($this->jarPath)) {
			echo '<div class="alert alert-error"><strong>Fatal Error!</strong> ' . $this->jarPath . ', file not found.</div>';
			$error = true;
		}
		# check temp path is writable
		$testFile = $this->tempPath . md5(mt_rand()) . '.test';
		if (file_put_contents($testFile, 'test') === false) {
			echo '<div class="alert alert-error"><strong>Fatal Error!</strong> ' . $this->tempPath . ', is not writeable.</div>';
			$error = true;
		} else {
			unlink($testFile);
		}
		# css output path is writable
		if (!is_file($this->options['cssOutputPath'])) {
			$testFile = $this->options['cssOutputPath'];
			if (file_put_contents($testFile, 'test') === false) {
				echo '<div class="alert alert-error"><strong>Fatal Error!</strong> ' . $this->options['cssOutputPath'] . ', is not writeable.</div>';
				$error = true;
			} else {
				unlink($testFile);
			}
		} elseif (!is_writable($this->options['cssOutputPath'])) {
			echo '<div class="alert alert-error"><strong>Fatal Error!</strong> ' . $this->options['cssOutputPath'] . ', is not writeable.</div>';
			$error = true;
		}
		# js output path is writable
		if (!is_file($this->options['jsOutputPath'])) {
			$testFile = $this->options['jsOutputPath'];
			if (file_put_contents($testFile, 'test') === false) {
				echo '<div class="alert alert-error"><strong>Fatal Error!</strong> ' . $this->options['jsOutputPath'] . ', is not writeable.</div>';
				$error = true;
			} else {
				unlink($testFile);
			}
		} elseif (!is_writable($this->options['jsOutputPath'])) {
			echo '<div class="alert alert-error"><strong>Fatal Error!</strong> ' . $this->options['jsOutputPath'] . ', is not writeable.</div>';
			$error = true;
		}
		if ($error) {
			exit;
		}
		
		# invoke lessphp class
		$this->less = new lessc;
		
		# invoke php-yui-compressor class
		$this->yui = new YUICompressor($this->jarPath, $this->tempPath, $options);
		
		# set options if argument is passed
		foreach ($options as $option => $value) {
			$this->setOption($option, $value);
		}
		
		echo '<div class="alert alert-info"><strong>Info!</strong> Pie is ready for the meat &amp; veg a.k.a files.</div>';
		
	}
	
	# set oven temperature etc
	public function setOption($option, $value) {
		if (array_key_exists($option, $this->options)) {
			$this->options[$option] = $value;
		} else {
			echo '<div class="alert alert-warning"><strong>Warning!</strong> $option \'' . $option . '\' is not a valid option.</div>';
		}
	}
	
	# add chunky meat & veg into the pie
	public function add($file) {
		if (is_file($file)) {
			if (substr($file, -5) == '.less') {
				# compile less file & return css
				try {
					$this->css .= ' ' . $this->less->compileFile($file);
				} catch (exception $e) {
					echo '<div class="alert alert-error"><strong>Fatal Error!</strong> ' . $e->getMessage() . '</div>';
				}
				echo '<div class="alert alert-info"><strong>Info!</strong> ' . $file . ' added.</div>';
			} elseif (substr($file, -4) == '.css') {
				# get css file contents
				$this->css .= ' ' . file_get_contents($file);
				echo '<div class="alert alert-info"><strong>Info!</strong> ' . $file . ' added.</div>';
			} elseif (substr($file, -3) == '.js') {
				# get js file contents
				$this->js .= ' ' . file_get_contents($file);
				echo '<div class="alert alert-info"><strong>Info!</strong> ' . $file . ' added.</div>';
			} else {
				echo '<div class="alert alert-warning"><strong>Warning!</strong> ' . $file . ', invalid file type.</div>';
			}
		} else {
			echo '<div class="alert alert-error"><strong>Error!</strong> ' . $file . ', file not found.</div>';
		}
	}
	
	# bake the pie!
	public function bake() {
		if (!empty($this->css)) {
			# set type to css
			$this->yui->setOption('type', 'css');
			# add string
			$this->yui->addString($this->css);
			# compress
			$this->cssMin .= $this->yui->compress();
			# save compressed css to file
			file_put_contents($this->options['cssOutputPath'], $this->options['comments'] . $this->cssMin);
		}
		if (!empty($this->js)) {
			# set type to js
			$this->yui->setOption('type', 'js');
			# add string
			$this->yui->addString($this->js);
			# compress
			$this->jsMin .= $this->yui->compress();
			# save compressed js to file
			file_put_contents($this->options['jsOutputPath'], $this->options['comments'] . $this->jsMin);
		}
		echo '<div class="alert alert-success"><strong>Baked!</strong> Your pie is ready!</div>';
		echo '</div></body></html>';
	}
}
?>
