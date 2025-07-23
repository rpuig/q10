Start
  |
  v
**Constructor: Hd($natal, $natal_88)**
  |
  v
-----------------------------------------------
| Call `create_hex_prof($natal, "p")`       |
|    |                                        |
|    | Extract and process planet, aspect,    |
|    | and house data                         |
|    v                                        |
| Update $this->personality                   |
|---------------------------------------------|
  |
  v
-----------------------------------------------
| Call `create_hex_prof($natal_88, "d")`     |
|    |                                        |
|    | Extract and process planet, aspect,    |
|    | and house data                         |
|    v                                        |
| Update $this->design                        |
|---------------------------------------------|
  |
  v
-----------------------------------------------
| Methods invoked by create_hex_prof():      |
|---------------------------------------------|
| extractPlanetData($natal_result)           |
| extractAspectData($natal_result)           |
| extractHouseData($aspectData)              |
| getIndexesFromLongitude($longitude, $flag) |
| removeElementByKey(&$array, $key)          |
| insertArrayBeforeKey(&$origArray, $newArr, |
| $key)                                       |
| shiftElementInArray(&$array, $index,       |
| $positionsBack)                            |
-----------------------------------------------
  |
  v
-----------------------------------------------
| Utility methods:                           |
|---------------------------------------------|
| dmsToDecimal($deg, $min = 0, $sec = 0)     |
| DDtoDMS($dec)                              |
| DMStoDD($deg, $min, $sec)                  |
| shift_88($originalLongitude)               |
| mergeArrays($arrayA, $arrayB)              |
| merge_gates($arrayA, $arrayB)              |
-----------------------------------------------
  |
  v
-----------------------------------------------
| Display methods:                           |
|---------------------------------------------|
| printDataInDivLayout()                     |
| printDataInDivLayout2()                    |
| print_Gates($gates)                        |
| get_hd_result_display()                    |
-----------------------------------------------
  |
  v
End