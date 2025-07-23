<?php
function calculateFengShuiKuaNumber($yearOfBirth, $isMale = true) {
    // Check if the year is valid
    if (!is_numeric($yearOfBirth) || $yearOfBirth < 1900 || $yearOfBirth > date('Y')) {
        return false;
    }

    // Extract the last two digits of the year
    $lastTwoDigits = $yearOfBirth % 100;

    // Calculate the Kua Number
    $kuaNumber = $lastTwoDigits % 9;

    // Adjust for females
    if (!$isMale) {
        $kuaNumber = ($kuaNumber + 5) % 9;
    }

    // Handle the case when the result is 0
    if ($kuaNumber === 0) {
        $kuaNumber = 9;
    }

    return $kuaNumber;
}

// Example usage:
$yearOfBirth = 1978; // Replace with the year of birth
$isMale = true; // Set to true for males, false for females
$kuaNumber = calculateFengShuiKuaNumber($yearOfBirth, $isMale);

if ($kuaNumber !== false) {
    $gender = $isMale ? "male" : "female";
    echo "Your Feng Shui Kua Number as a $gender is: $kuaNumber";
} else {
    echo "Invalid year of birth.";
}
?>
