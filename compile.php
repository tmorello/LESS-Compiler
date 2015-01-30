<?php

// eg.: getLess("style.less", "style.css");

function getLess($input, $output) {

	$folder = dirname($input);
	$file = glob($folder."/*.less");
	$file = array_combine($file, array_map("filemtime", $file));
	arsort($file);
	$file = key($file);

	$lessmtime = filemtime($file);

	if (file_exists($output)) {
		$cssmtime = filemtime($output);
	} else {
		$cssmtime = 0;
	};

	if ($lessmtime>$cssmtime) {
		require "less-compiler.php";
		$less = new lessc;
		$less -> setFormatter("compressed");
		$less -> compileFile($input, $output);
	};

	$output = $output."?v=".$cssmtime;
	$style = '<link rel="stylesheet" type="text/css" href="'.$output.'">';
	echo $style;
};

?>
