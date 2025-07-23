<?php




$headerStyleArray = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => '000000'],
        'size' => 12,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['argb' => 'FFAEC6F9'], // Example: Blue background
    ],
    'borders' => [
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'],
        ],
    ],
    // Add more styling as needed
];
$styles = [
    'YangWater' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFAED6F1']], // Light Blue
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'YinWater' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD4E6F1']], // Softer Blue
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'YangWood' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD0ECE7']], // Mint Green
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'YinWood' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE9F7EF']], // Sage Green
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'YangFire' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFADBD8']], // Soft Red
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'YinFire' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4500']], // Peach
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'YangEarth' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFEDBB99']], // Soft Orange
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'YinEarth' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF5CBA7']], // Light Brown
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'YangMetal' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD5DBDB']], // Light Grey
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'YinMetal' => [
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFBFC9CA']], // Grey-Blue
        'font' => ['color' => ['argb' => 'FF000000']], // Black font
    ],
    'conflict' => [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => 'a83273'], // Example conflict color (Red)
        ],
        'font' => [
            'color' => ['argb' => 'FFFFFFFF']] // White font color
        ],
     'Yellow' => [
       'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => 'f9e076'], // Example conflict color (Red)
            ],
        'font' => [
            'color' => ['argb' => '000000']] // White font color
            ],
    'Blue' => [
            'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '6693F5'], // Example conflict color (Red)
                    ],
                'font' => [
                    'color' => ['argb' => '000000']] // White font color
                    ],
    
     'Red' => [
                        'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'ff4c4c'], // Example conflict color (Red)
                                ],
                            'font' => [
                                'color' => ['argb' => '000000']] // White font color
                                ],
                
        
     'White' => [
                                    'fill' => [
                                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                            'startColor' => ['argb' => 'FFFFF'], // Example conflict color (Red)
                                            ],
                                        'font' => [
                                            'color' => ['argb' => '000000']] // White font color
                                            ],
                            
    
    ]
;


function cell_conditiona_formatting($value,$sheet){
    // Assuming $row is your fetched row from the database
    $rowIndex = 2; // Start from the second row since the first row is for headers
    
    
        foreach ($value as $cellValue) {
            // Determine the cell to format
            $cell = $colIndex . $rowIndex;
    
            // Apply conditional formatting
            if ($cellValue == 'Some Condition') {
                $sheet->getStyle($cell)->getFont()->setBold(true);
                $sheet->getStyle($cell)->getFill()
                      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('FFFF0000'); // Example: Red fill for a specific condition
            } else {
                // Apply different formatting or leave as default
            }
    
            // Move to the next column
            $colIndex++;
        }
    
        // Move to the next row
        $rowIndex++;
    
    }


    function getStyleBasedOnCellValue($cellValue, $styles) {
        // Split the string by commas to get the individual numbers
        $numbers = explode(',', $cellValue);
        // Convert string numbers to integers for comparison
        $numbers = array_map('intval', $numbers);
    
        // Check for conflicts - if any number is the same as another
        $uniqueNumbers = array_unique($numbers);
        if (count($uniqueNumbers) < count($numbers)) {
            // Conflict detected, return the 'conflict' style
            return $styles['conflict'];
        }
    
        // Determine the order of the numbers
        $sortedNumbers = $numbers; // Copy the array
        rsort($sortedNumbers); // Sort numbers in descending order
    
        // Find the highest number's position
        $highestNumber = $sortedNumbers[0];
        $position = array_search($highestNumber, $numbers) + 1;
    
        // Determine the style based on the position of the highest number
        switch ($position) {
            case 1:
                return $styles['YinEarth'];
            case 2:
                return $styles['YinMetal'];
            case 3:
                return $styles['YinWater'];
            case 4:
                return $styles['YinWood'];
            case 5:
                return $styles['YinFire'];
            default:
                return []; // Default style if needed
        }
    }
    