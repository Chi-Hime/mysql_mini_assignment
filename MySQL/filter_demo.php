<?php
$badString = "Ke<script src='...'>n";
$sanitized = filter_var($badString, FILTER_SANITIZE_STRING);
echo $sanitized;
$badNumber = "12)<br>4";
$sanitizeNumber = filter_var($badNumber, FILTER_SANITIZE_NUMBER_INT);
echo "<br>";
echo $sanitizeNumber;
$model_update = filterString($_POST["car_model"]);
	
	function filterString($string){
		return filter_var($string, FILTER_SANITIZE_STRING);
	}
?>