
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Set the browser tab title -->
    <title>DMS Conversion</title>
</head>
<body>
	<?php 





function dmsToDecimal($degrees, $minutes, $seconds, $direction) {
    $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);
    if ($direction == 'S' || $direction == 'W') {
        $decimal *= -1; // For South or West, make the result negative
    }
    return $decimal;
}

// Example usage:
$degrees = 14;
$minutes =31;
$seconds = 59.3480140854945;
$sign="vir";
$direction = 'N';
$sign_array=

$decimalDegrees = dmsToDecimal($degrees, $minutes, $seconds, $direction);
echo  ("DMS  ".$decimalDegrees);


?>
</body>
</html>