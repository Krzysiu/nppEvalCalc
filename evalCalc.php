<?php
	ob_start();
	
	$config = 
	[
	/*
		floatPrecission (integer) - maximal float precision
		with value set to 4 it will render "1" as "1", "1.5000" as "1.5" (hence _maximal_) and "1.666666..." as "1.669"  (rounding)
	*/
	'floatPrecission' => 5, 
	
	/*
		decimalSeparator (string) - floating point symbol
		with '.' it will render "3/2" as "1.5", with "," as "1,5"
	*/
	'decimalSeparator' => '.',
	
	/*
		thousandsSeparator (string) - thousands separator symbol
		with " " it will render "999" as "999" and "1234567" as "1 234 567"; empty string ('') to turn off
	*/	
	'thousandsSeparator' => ' ',
	
	/*
		includeOriginalExpression (boolean) - return expression and result or just result
		with true "5 + 5" will be rendered as "5 + 5 = 25"; with false it will be just "25"
	*/	
	'includeOriginalExpression' => true,
	
	/*
		equalsString (string) - symbol between equation and result
		if the original expression is kept, it's separator between equation and result
	*/	
	'equalsString' => ' = ',
	
	/*
		caretToPower (boolean)
		convert ^ symbol to ** (power in PHP)
	*/
	'caretToPower' => true,
	
	/*
		semicolonToDivision (boolean)
		convert : symbol to / (division in PHP)
	*/
	'semicolonToDivision' => true,
	];
	
	if (!isset($argv[1]) || empty($argv[1])) die();
	$expr = $argv[1];
	$expr = trim($expr);
	$eol = (strpos($expr, "\r\n") !== false) ? "\r\n" : "\n";
	$expr = explode($eol, $expr);
	
	$out = '';
	foreach ($expr as $data) {
		$procExpr = $data;
		if ($config['caretToPower']) $procExpr = str_replace('^', '**', $data); // allow use of standard power operator (^)
		if ($config['semicolonToDivision']) $procExpr = str_replace(':', '/', $procExpr); // allow use of different division operator (:)
		if ($config['decimalSeparator'] !== '.') $procExpr = str_replace($config['decimalSeparator'], '.', $procExpr); // allow use of standard power operator (^)
		
		$procExpr = trim($procExpr);
		$calcCmd = sprintf('$evalOut = %s;', $procExpr);
		eval($calcCmd);
		
		if ( !( is_integer($evalOut) || is_float($evalOut) ) ) $evalOut = 'ERR: non-numeric output';
		else {
			$evalOut = number_format($evalOut, ($evalOut != floor($evalOut) ? $config['floatPrecission'] : 0), $config['decimalSeparator'], $config['thousandsSeparator']);
			if (strpos($evalOut, $config['decimalSeparator']) !== false) $evalOut = rtrim($evalOut, '0'); // trim trailing zeros after dec. point
		}
		
		if ($config['includeOriginalExpression'])	$out .= sprintf('%s%s%s%s', $data, $config['equalsString'], $evalOut, $eol);
		else $out .= $evalOut . $eol;
	}
	ob_clean();
	echo $out;
