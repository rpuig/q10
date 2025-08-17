<?php
namespace App\Libraries\astro\hd;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Libraries\astro\sweph\Sweph;

include("hd_constants.php");
class Hd extends BaseController

{
private $personality;
private $design;
private $centers=
[[1,"root","undefined"],[2,"splenic","undefined"],
[3,"sacral","undefined"],[4,"solar_plexus","undefined"],
[5,"g_center","undefined"],[6,"heart","undefined"],
[7,"throat","undefined"],[8,"aijna","undefined"],
[9,"head","undefined"]];

private $channels=[
["1-8","undefined"],
["10-20","undefined"],
["10-34","undefined"],
["10-57","undefined"],
["11-56","undefined"],
["12-22","undefined"],
["13-33","undefined"],
["17-62","undefined"],
["18-58","undefined"],
["2-14","undefined"],
["20-57","undefined"],
["21-45","undefined"],
["24-61","undefined"],
["25-51","undefined"],
["26-44","undefined"],
["27-50","undefined"],
["28-38","undefined"],
["29-46","undefined"],
["3-60","undefined"],
["30-41","undefined"],
["32-54","undefined"],
["34-20","undefined"],
["34-57","undefined"],
["35-36","undefined"],
["37-40","undefined"],
["4-63","undefined"],
["43-23","undefined"],
["47-64","undefined"],
["48-16","undefined"],
["49-19","undefined"],
["5-15","undefined"],
["52-9","undefined"],
["53-42","undefined"],
["55-39","undefined"],
["6-59","undefined"],
["7-31","undefined"]
];


private $planetData;
private $aspectData;
private $houseData;
private $planetData88;
private $aspectData88;
private $houseData88;

public function __construct($natal,$natal_88){  

        $this->personality=$this->create_hex_prof($natal,"p");    
        $this->design=$this->create_hex_prof($natal_88,"d");  


       // $gates=$this->merge_gates($this->personality, $this->design); 
       // print_r("<br>");  

        // $this->print_Gates($gates);


        // $channels= $this->calculate_channels($hexagram_map);
        // Extracting the required data
       /*  $this->planetData = $this->extractPlanetData($natal);
        $this->aspectData = $this->extractAspectData($natal);
        $this->houseData = $this->extractHouseData($this->aspectData);
        $this->planetData88= $this->extractPlanetData($natal_88);
        $this->aspectData88 = $this->extractAspectData($natal_88);
        $this->houseData88 = $this->extractHouseData($this->aspectData88); */
        //$this->printDataInDivLayout($planetData,$aspectData,$houseData);
        //$this->printDataInDivLayout88_1($planetData,$aspectData,$houseData,$planetData88,$aspectData88,$houseData88);
     }


   

     private function create_hex_prof($natal_result,$flag){

        echo "<script>console.log(" . json_encode($natal_result, JSON_PRETTY_PRINT) . ");</script>";
      
        $this-> planetData = $natal_result->planets;
       // $this-> aspectData = $natal_result->aspects;
        $this-> houseData = $natal_result->houses;

            if (isset($this-> aspectData["house"])) {
            // Remove the subarray using unset()
            unset($this-> aspectData["house"]);
        }

        $this-> aspectData["Sun"]= $this-> planetData[0];
        $this-> aspectData["Moon"]= $this-> planetData[1];
        //$this->planetData[10]["name"]="South Node";
        $this->aspectData["South Node"]= $this-> planetData[10];
       /*  $sn_temp=$this->northToSouthNode($this->planetData[11]["lng"],  $this->planetData[11]["sign"]);
        $this->planetData[10]["lng"]=$sn_temp['southLongitude'];
        $this->planetData[10]["sign"]=$sn_temp['southSign']; */

        //Index 10 =mean node, 11 true node , 20=Earth

        //Sun , Earth, North Node , Soth Node, Moon, Mercury, Venus, Mars, Jupiter , Saturn, Uranus, Neptune, Pluto 
    //   echo $this->debugPlanetsGateLines($this->planetData, false); // false = do not apply legacy +30
    //          exit();

        foreach ($this->planetData as $index => $plData) {   
    
        $long=$plData["lng"];
        $sign=$plData["sign"];
        $body=$plData["name"];
        //$body= $indexes_planets[$index] =[$plData["name"], $this->getIndexesFromLongitude4($long,$sign,$flag)];    
        $indexes_planets[$index] =[$plData["name"], $this->getGateAndLineFromLongitude_v3($long,$body,$flag)];    
          $indexes_planets[$index] =[$plData["name"], $this->getGateAndLineFromLongitudeB($long,$body,$flag)];  
        }

        
      //Sun, Earth, N Node, Su Node, Moon , Mercury,....
            $this->removeElementByKey($indexes_planets,13);
            $this->removeElementByKey($indexes_planets,14);
            $this->removeElementByKey($indexes_planets,15);
            $this->removeElementByKey($indexes_planets,16);
            $this->removeElementByKey($indexes_planets,17);
            $this->removeElementByKey($indexes_planets,18);
            $this->removeElementByKey($indexes_planets,19);   

            $this->shiftElementInArray($indexes_planets,20,11);
            $this->shiftElementInArray($indexes_planets,10,9);            
            $this->shiftElementInArray($indexes_planets,11,10);
            
         return $indexes_planets;
    
    }
    
    /*

INTENDED

Design	Sun	            35	6    
Design	Earth	        5	6
Design	Moon	        52	4
Design	true_node	    46	5
Design	south_node	    25	5
Design	Mercury	        16	3
Design	Venus	        53	6
Design	Mars	        29	3
Design	Jupiter	        39	3
Design	Saturn	        29	1z
Design	Uranus	        44	6
Design	Neptune	        5	6
Design	Pluto	        48	5

ersonality	Sun	        64	4
Personality	Earth	    63	4
Personality	Moon	    44	5
Personality	true_node	6	5 
Personality	south_node	36	5
Personality	Mercury	    29	3
Personality	Venus	    50	5
Personality	Mars	    32	2
Personality	Jupiter	    56	5
Personality	Saturn	    59	6
Personality	Uranus	    1	1
Personality	Neptune	    5	5
Personality	Pluto	    57	1

 */

    private function shift_88($originalLongitude){
        $shiftDegrees=88;
        $shiftedLongitude = $originalLongitude -$shiftDegrees ;

        // Normalize the longitude within the valid range (-180 to 180)
        while ($shiftedLongitude < -180) {
            $shiftedLongitude += 360;
        }
    
        while ($shiftedLongitude > 180) {
            $shiftedLongitude -= 360;
        }
    
        return $shiftedLongitude;

    }

    private function mergeArrays($arrayA, $arrayB) 
    {         
        $temp=[];       
        $temp_arr_keys=array_keys($arrayA);        
        foreach ($temp_arr_keys as $index =>$key){ 
                $temp[$key]=[$arrayA[$key][0],$arrayA[$key][1],$arrayA[$key][2],$arrayB[$key][0],$arrayB[$key][1],$arrayB[$key][2]];
           }

         return $temp;     
    }
   
    private function merge_gates($arrayA, $arrayB) 
    {         
        $temp=[];       
        $temp_arr_keys=array_keys($arrayA); 
        $total_l=count($arrayA)+count($arrayB); 
        $half_total=($total_l/2)-1;
        for ($i=0;$i<$total_l;$i++){ 
            
           
                $temp[$i]=$arrayA[$temp_arr_keys[$i]];
                if ($i>$half_total){
                $temp[$i]=$arrayB[$temp_arr_keys[$i-count($arrayB)]];
                }
            
        }
        return $temp;
    }
    
function northToSouthNode($northLongitude, $northSign) {
    // Calculate South Node absolute longitude by adding 180 degrees
    $southLongitude = $northLongitude + 180;
    
    // Normalize the longitude to the 0-360 range
    $southLongitude = fmod($southLongitude, 360);
    if ($southLongitude < 0) {
        $southLongitude += 360;
    }
    
    // Mapping of zodiac opposites
    $oppositeSigns = [
        'Aries'       => 'Libra',
        'Taurus'      => 'Scorpio',
        'Gemini'      => 'Sagittarius',
        'Cancer'      => 'Capricorn',
        'Leo'         => 'Aquarius',
        'Virgo'       => 'Pisces',
        'Libra'       => 'Aries',
        'Scorpio'     => 'Taurus',
        'Sagittarius' => 'Gemini',
        'Capricorn'   => 'Cancer',
        'Aquarius'    => 'Leo',
        'Pisces'      => 'Virgo'
    ];
    
    // Determine the South Node sign based on the North Node sign
    $southSign = isset($oppositeSigns[$northSign]) ? $oppositeSigns[$northSign] : null;
    
    return [
        'southLongitude' => $southLongitude,
        'southSign'      => $southSign
    ];
}
/* function zodiacToAbbreviation($zodiac) {
        $zodiacMap = [
            'Aries' => 'Ari',
            'Taurus' => 'Tau',
            'Gemini' => 'Gem',
            'Cancer' => 'Can',
            'Leo' => 'Leo',
            'Virgo' => 'Vir',
            'Libra' => 'Lib',
            'Scorpio' => 'Sco',
            'Sagittarius' => 'Sag',
            'Capricorn' => 'Cap',
            'Aquarius' => 'Aqu',
            'Pisces' => 'Pis'
        ];
    
        return $zodiacMap[$zodiac] ?? null; // Returns null if the zodiac name is invalid
    }
     */
  
function absoluteToRelative($absoluteLongitude) {
        // Normalize the absolute longitude to be within 0 and 360 degrees.
        $absoluteLongitude = fmod($absoluteLongitude, 360);
        if ($absoluteLongitude < 0) {
            $absoluteLongitude += 360;
        }
        
        // Each zodiac sign spans 30 degrees.
        // The relative degree is the remainder when dividing by 30.
        $relativeDegrees = $absoluteLongitude - (floor($absoluteLongitude / 30) * 30);
        
        return $relativeDegrees;
    }


function relativeToAbsolute($zodiacIndex, $relativeDegrees) {
        // Ensure zodiac index is between 0 and 11
        $zodiacIndex = $zodiacIndex % 12;
        if ($zodiacIndex < 0) {
            $zodiacIndex += 12;
        }
    
        // Each sign is 30 degrees apart
        $absoluteLongitude = $zodiacIndex * 30 + $relativeDegrees;
    
        // Normalize to 0–360 if needed
        $absoluteLongitude = fmod($absoluteLongitude, 360);
        if ($absoluteLongitude < 0) {
            $absoluteLongitude += 360;
        }
    
        return $absoluteLongitude;
    }


function getGateAndLineFromLongitude($longitude, $body, $flag="p")
{
    $hex_wheel_new = hex_wheel; // your flat list of [gate, degree, sign] entries
    if (empty($hex_wheel_new)) return [null, null];

    // Normalize incoming longitude into 0..360
    $longitude = fmod($longitude, 360);
    if ($longitude < 0) $longitude += 360;

    // Your original shift (you used +30)
    $longitude += 30;
    // Normalize again after the shift
    $longitude = fmod($longitude, 360);
    if ($longitude < 0) $longitude += 360;

    // Special handling for Earth / Nodes (keep simplified: opposite point)
    if ($body === "Earth" || $body === "True Node" || $body === "South Node") {
        $longitude = fmod($longitude + 180, 360);
        if ($longitude < 0) $longitude += 360;
    }

    // Work with zero-indexed sequential array for easier prev/next access
    $entries = array_values($hex_wheel_new);
    $count = count($entries);

    // Iterate entries and find the first entry whose degree is greater than longitude
    for ($i = 0; $i < $count; $i++) {
        list($gate, $degree, $sign) = $entries[$i];

        if ($longitude < $degree) {
            // If this is not the first entry, compute based on previous entry span
            if ($i > 0) {
                list($prevGate, $prevDegree, $prevSign) = $entries[$i - 1];

                // The nextDegree for prev gate is this entry's degree
                $nextDegree = $degree;

                $gateSpan = $nextDegree - $prevDegree;
                if ($gateSpan <= 0) $gateSpan += 360; // safety

                $lineSpan = $gateSpan / 6.0; // six lines
                $line = intval(floor(($longitude - $prevDegree) / $lineSpan)) + 1;

                // clamp line
                $line = max(1, min(6, $line));

                return [$prevGate, $line];
            }

            // If this is the first entry and longitude < first degree, return first gate line 1
            return [$gate, 1];
        }
    }

    // If we reach here, longitude was >= last entry degree -> handle wrap-around
    // Use last entry as previous, and first entry degree + 360 as nextDegree
    list($lastGate, $lastDegree, $lastSign) = $entries[$count - 1];
    list($firstGate, $firstDegree, $firstSign) = $entries[0];

    $nextDegree = $firstDegree + 360;
    $gateSpan = $nextDegree - $lastDegree;
    if ($gateSpan <= 0) $gateSpan += 360; // safety

    $lineSpan = $gateSpan / 6.0;
    // If longitude is less than firstDegree, we should treat it as longitude + 360 for wrap math
    $wrappedLongitude = $longitude;
    if ($wrappedLongitude < $lastDegree) {
        $wrappedLongitude += 360;
    }

    $line = intval(floor(($wrappedLongitude - $lastDegree) / $lineSpan)) + 1;
    $line = max(1, min(6, $line));

    return [$lastGate, $line];
}

function getGateAndLineFromLongitudeB($longitude, $body, $flag="p")
    {
        $hex_wheel_new = hex_wheel; // Make sure this is accessible
        $line = 0;
        $previous = null;
        $longitude = $longitude + 30;
        if ($body == "Earth" || $body == "True Node" || $body== "South Node") {
            $longitude = fmod($longitude + 180, 360);
            if ($longitude < 0) {
                $longitude += 360;
            } else {
                $longitude = abs(180 - $longitude);
            }
        }
    
        foreach ($hex_wheel_new as $index => $entry) {
            list($gate, $degree, $sign) = $entry;
            
            if ($longitude < $degree) {
                if ($previous) {
                    list($prevGate, $prevDegree, $prevSign) = $previous;
    
                    // Find the next entry for this gate to get the gate's span
                    $nextDegree = null;
                    for ($i = $index; $i < count($hex_wheel_new); $i++) {
                        if ($hex_wheel_new[$i][0] !== $prevGate) {
                            $nextDegree = $hex_wheel_new[$i][1];
                            break;
                        }
                    }
                    if ($nextDegree === null) {
                        $nextDegree = 360; // wrap around for last gate
                    }
    
                    $gateSpan = $nextDegree - $prevDegree;
                    $lineSpan = $gateSpan / 6.0; // 6 lines per gate
    
                    $line = intval(floor(($longitude - $prevDegree) / $lineSpan)) + 1;
                    $linea[]=$line;
                    if ($line > 6) $line = 6; // Clamp to 6
                    if ($line < 1) $line = 1; // Clamp to 1
    
                    return [$prevGate, $line];
                } else {
                    // If first element is already greater than longitude
                    return [$gate, 1];
                }
            }
    
            $previous = $entry;
        }
    }

/*debugging*/

/** Normalize into [0,360) */
/* private function normalizeLon(float $lon): float {
    $lon = fmod($lon, 360.0);
    if ($lon < 0) $lon += 360.0;
    return $lon;
}
 */

/** Get sign name from absolute longitude (0..360). Returns full name like "Aries" */
private function signFromLongitude(float $lon): string {
    $signs = [
        "Aries","Taurus","Gemini","Cancer",
        "Leo","Virgo","Libra","Scorpio",
        "Sagittarius","Capricorn","Aquarius","Pisces"
    ];
    $index = intval(floor($lon / 30.0)) % 12;
    return $signs[$index];
}

/** Parse one of your hex_wheel subitems (handles both keyed and keyed-one-based arrays) */
/* private function parseHexItem($item) {
    $degree = null; $sign = null;
    if (!is_array($item)) return [null, null];
    foreach ($item as $v) {
        if ($degree === null && (is_float($v) || is_int($v) || (is_string($v) && is_numeric($v)))) {
            $degree = floatval($v);
        } elseif ($sign === null && is_string($v)) {
            $sign = $v;
        }
    }
    return [$degree, $sign];
}
 */
/**
 * Compute gate & line.
 *
 * @param float  $absoluteLongitude absolute 0..360 (can be >360 or negative)
 * @param string $body              e.g. "Sun", "Earth", "South Node", "True Node"
 * @param bool   $applyShift        optional old +30 behaviour (default false)
 * @return array [gateNumber|null, lineNumber|null, debugArray]
 */
public function computeGateLine(float $absoluteLongitude, string $body = 'Sun', bool $applyShift = false): array {
    // 1) normalize
    $lon = $this->normalizeLon($absoluteLongitude);

    // 2) optional legacy shift (default OFF)
    if ($applyShift) {
        $lon = $this->normalizeLon($lon + 30.0);
    }

    // 3) Node/Earth inversion: opposite point
    if (in_array($body, ["Earth", "South Node", "True Node"])) {
        $lon = $this->normalizeLon($lon + 180.0);
    }

    // 4) derive sign and relative degree within sign [0..30)
    $signName = $this->signFromLongitude($lon);
    $signAbbr = $this->zodiacToAbbreviation($signName);
    $relative = $lon - (floor($lon / 30.0) * 30.0);
    // clamp float precision
    if ($relative < 0) $relative += 30.0;
    if ($relative >= 30.0) $relative = 29.9999999;

    $debug = [
        'input' => $absoluteLongitude,
        'normalized' => $lon,
        'sign' => $signName,
        'signAbbr' => $signAbbr,
        'relative' => $relative
    ];

    // 5) walk your hex_wheel (uses constant hex_wheel you showed earlier)
    $hex_wheel = hex_wheel;
    foreach ($hex_wheel as $gate => $signData) {
        // does this gate belong to our sign? (search signAbbr in all subitems)
        $belongs = false;
        $anchors = [];
        foreach ($signData as $item) {
            list($d, $s) = $this->parseHexItem($item);
            if ($s !== null && $s === $signAbbr) $belongs = true;
            if ($d !== null) $anchors[] = floatval($d);
        }
        if (!$belongs) continue;
        if (empty($anchors)) continue;

        // Convert anchors to monotone "extended" scale within 0..30: if anchor drops (e.g., 28,29,0,0.9..)
        $ext = [];
        $prev = null;
        foreach ($anchors as $d) {
            $val = $d;
            if ($prev !== null && $val < $prev - 1e-9) {
                // treat small values (near 0) as 30+ to preserve order
                if ($val < 1.0) $val += 30.0;
            }
            $ext[] = $val;
            $prev = $val;
        }
        // build bounds: ext[0], ext[1], ..., ext[last], bound = ext[0] + 30
        $extBound = $ext;
        $extBound[] = $ext[0] + 30.0;

        // Map relative into same extended scale for comparison
        $relExt = $relative;
        // if relExt < ext[0] and ext[0] is > ext[last], we may be in wrap zone -> add 30
        if ($relExt < $ext[0] && $ext[count($ext)-1] > $ext[0]) {
            // only add if it helps (common when anchor list crosses zero)
            $relExt += 30.0;
        }

        // search interval i where extBound[i] <= relExt < extBound[i+1]
        for ($i = 0; $i < count($ext); $i++) {
            $start = $extBound[$i];
            $end   = $extBound[$i+1];
            $debug['candidate_' . $gate][] = ['start' => $start, 'end' => $end, 'line' => $i+1];
            if ($relExt + 1e-9 >= $start && $relExt < $end - 1e-9) {
                $line = $i + 1;
                if ($line < 1) $line = 1;
                if ($line > 6) $line = 6;
                $debug['matched_gate'] = $gate;
                $debug['matched_line'] = $line;
                $debug['anchors'] = $anchors;
                return [$gate, $line, $debug];
            }
        }
        // else continue with next gate
    }

    // fallback: no match
    $debug['error'] = 'no_gate_matched';
    return [null, null, $debug];
}

/**
 * Diagnostic routine — compare computed gate/line for every planet in the provided array.
 * $planets is the planets array structure you pasted earlier.
 * $applyShift default false (set true if you know you were using +30 previously).
 */
public function debugPlanetsGateLines(array $planets, bool $applyShift = false): string {
    $out = "";
    foreach ($planets as $idx => $p) {
        $name = $p['name'];
        $lng  = floatval($p['lng']);
        // pass body name; for nodes use "True Node" or "South Node" as appropriate
        $body = $name;
        list($gate, $line, $debug) = $this->computeGateLine($lng, $body, $applyShift);
        $out .= sprintf(
            "%s (abs: %.6f) => Gate: %s, Line: %s\nDebug: %s\n\n",
            $name,
            $lng,
            ($gate === null ? 'NULL' : $gate),
            ($line === null ? 'NULL' : $line),
            json_encode($debug)
        );
    }
    return nl2br($out);
}
/** Map full sign name to abbreviation used in hex_wheel */
private function zodiacToAbbreviation($zodiac) {
    $zodiacMap = [
        'Aries' => 'Ari','Taurus' => 'Tau','Gemini' => 'Gem','Cancer' => 'Can',
        'Leo' => 'Leo','Virgo' => 'Vir','Libra' => 'Lib','Scorpio' => 'Sco',
        'Sagittarius' => 'Sag','Capricorn' => 'Cap','Aquarius' => 'Aqu','Pisces' => 'Pis'
    ];
    return $zodiacMap[$zodiac] ?? null;
}

/*end debugging*/
// helper: normalize to [0,360)
private function normalizeLon(float $lon): float {
    $lon = fmod($lon, 360.0);
    if ($lon < 0) $lon += 360.0;
    return $lon;
}

// helper: parse a hex_wheel item like array(1 => 0.1236, "Pis") or [0.1236, "Pis"]
private function parseHexItem($item) {
    $degree = null; $sign = null;
    if (!is_array($item)) return [null, null];
    foreach ($item as $v) {
        if ($degree === null && (is_float($v) || is_int($v) || (is_string($v) && is_numeric($v)))) {
            $degree = floatval($v);
            continue;
        }
        if ($sign === null && is_string($v)) {
            $sign = $v;
        }
    }
    return [$degree, $sign];
}

/**
 * Returns [gateNumber, lineNumber] or [null, null].
 * - $longitude: absolute degrees (can be >360 or negative)
 * - $body: used to decide node inversion ("Earth","True Node","South Node" invert by +180)
 */
public function getGateAndLineFromLongitude_v3(float $longitude, string $body = "Sun") {
    // normalize
    $lon = $this->normalizeLon($longitude);

    // NOTE: remove any unexplained +30 shift unless you confirmed you need it.
    // If you previously used $longitude += 30, test results both with and without it.
    // $lon += 30; $lon = $this->normalizeLon($lon);

    // If Earth/Node semantics: opposite point
    if ($body === "Earth" || $body === "True Node" || $body === "South Node") {
        $lon = $this->normalizeLon($lon + 180.0);
    }

    // sign name and abbreviation
    $signs = ["Aries","Taurus","Gemini","Cancer","Leo","Virgo","Libra","Scorpio","Sagittarius","Capricorn","Aquarius","Pisces"];
    $signIndex = intval(floor($lon / 30.0)) % 12;
    $signName = $signs[$signIndex];
    $signAbbr = $this->zodiacToAbbreviation($signName);

    // relative degree within sign: 0 .. <30
    $relative = $lon - (floor($lon / 30.0) * 30.0);
    if ($relative < 0) $relative += 30.0;
    if ($relative >= 30.0) $relative = 29.9999999;

    // Walk hex_wheel and test gates that belong to this sign
    $hex_wheel = hex_wheel;
    foreach ($hex_wheel as $gate => $signData) {
        // find if gate belongs to target sign
        $belongs = false;
        $degrees = [];
        foreach ($signData as $item) {
            list($d, $s) = $this->parseHexItem($item);
            if ($s !== null && $s === $signAbbr) $belongs = true;
            if ($d !== null) $degrees[] = floatval($d);
        }
        if (!$belongs) continue;
        if (empty($degrees)) continue;

        // make monotonic sequence (handle wrap: values like 28,29,0,1 -> convert 0,1 to 30..)
        $first = $degrees[0];
        $ext = [];
        $prev = null;
        foreach ($degrees as $d) {
            $val = $d;
            // if this value is less than previous, assume wrap inside sign -> add 30
            if ($prev !== null && $val < $prev - 1e-9) {
                // treat as wrapped
                $val += 30.0;
            }
            $ext[] = $val;
            $prev = $val;
        }
        // append end boundary as first + 30 (end of gate span)
        $extBound = $ext;
        $extBound[] = $ext[0] + 30.0;

        // Map relative to same scale:
        $relExt = $relative;
        // if relative is less than ext[0] but ext[0] indicates a later start (>rel), bring relative into wrapped domain
        if ($relExt + 1e-9 < $ext[0]) $relExt += 30.0;

        // find interval
        for ($i = 0; $i < count($ext); $i++) {
            $start = $extBound[$i];
            $end   = $extBound[$i+1];
            if ($relExt + 1e-9 >= $start && $relExt < $end - 1e-9) {
                $line = $i + 1; // 1..6
                if ($line < 1) $line = 1;
                if ($line > 6) $line = 6;
                return [$gate, $line];
            }
        }
        // try next gate
    }

    // No gate matched — helpful debug output
    error_log("HD debug: no_gate_matched for input={$longitude}, normalized={$lon}, sign={$signName}, signAbbr={$signAbbr}, relative={$relative}");
    // extra debug: dump gate candidates (optional)
    foreach ($hex_wheel as $gate => $signData) {
        // print gates for this sign to error_log to inspect anchors
        foreach ($signData as $itm) {
            list($d,$s) = $this->parseHexItem($itm);
            if ($s === $signAbbr) {
                error_log("HD debug gate {$gate} anchors: " . json_encode($signData));
                break;
            }
        }
    }

    return [null, null];
}


/*debugging*/




/*end debugging*/


    function gpt_getGateAndLineFromLongitude($longitude, $body, $flag = "p") {
        $hex_wheel = hex_wheel;
    
        // Normalize longitude
        $longitude = fmod($longitude + 360, 360);
    
        // Adjust Earth and True Node (Human Design logic)
        if ($body === "Earth" || $body === "True Node") {
            $longitude = fmod($longitude + 180, 360);
        }
    
        $gate = null;
        $line = null;
    
        for ($i = 0; $i < count($hex_wheel) - 1; $i++) {
            $curr = $hex_wheel[$i];
            $next = $hex_wheel[$i + 1];
    
            if ($longitude >= $curr[1] && $longitude < $next[1]) {
                $gate = $curr[0];
                $line = ($i % 6) + 1; // every 6 entries = 6 lines
                return [$gate, $line];
            }
        }
    
        // Wrap around for the last gate
        $last = end($hex_wheel);
        $gate = $last[0];
        $line = 6;
    
        return [$gate, $line];
    }
    
    
function old_working_getGateAndLineFromLongitude($longitude,$body,$flag="p")
{
    $hex_wheel_new=hex_wheel_new; // Make sure this is accessible
   
    $previous = null;
    $longitude= $longitude+30;
    if ($body=="Earth"||$body=="True Node"  ){
        $longitude = fmod($longitude + 180, 360);
        if ($longitude < 0) {
            $longitude += 360;
        }

         else $longitude=abs(180-$longitude);} 


        /*  if($flag=="d"){
              $longitude =$this->shift_88($longitude ); 

                                        }  */

    foreach ($hex_wheel_new as $index => $entry) {
        list($gate, $degree, $sign) = $entry;

        if ($longitude < $degree) {
            if ($previous) {
                list($prevGate, $prevDegree, $prevSign) = $previous;

                // Determine line number (0-based within that gate)
                $gateCount = 0;
                foreach ($hex_wheel_new as $e) {
                    if ($e[0] === $prevGate) {
                        if ($e[1] === $prevDegree) {
                            break;
                        }
                        $gateCount++;
                    }
                }

                $line = $gateCount + 1; // convert to 1-based
                return [$prevGate, $line];
            } else {
                // If first element is already greater than longitude
                return [$gate, 1];
            }
        }

        $previous = $entry;
    }

    // If longitude is greater than all entries, return the last
    list($lastGate, $lastDegree, $lastSign) = end($hex_wheel_new);

    // Count how many entries have this same gate to get line
    $lines = array_filter($hex_wheel_new, fn($e) => $e[0] === $lastGate);
    $line = count($lines); // should be 6 for normal cases

    return [$lastGate, $line];
}




function removeElementByKey(&$array, $key) {
    if (array_key_exists($key, $array)) {
        unset($array[$key]);
    }
}

function insertArrayBeforeKey(&$originalArray, $newArray, $key) {
    $result = array();
    
    foreach ($originalArray as $k => $value) {
        if ($k === $key) {
            // Insert the new array before the specified key
            foreach ($newArray as $newKey => $newValue) {
                $result[$newKey] = $newValue;
            }
        }

        $result[$k] = $value;
    }

    // If the specified key wasn't found, append the new array at the end
    if (!isset($result[$key])) {
        foreach ($newArray as $newKey => $newValue) {
            $result[$newKey] = $newValue;
        }
    }

    $originalArray = $result;
}

function shiftElementInArray(&$array, $index, $positionsBack) {
    if (array_key_exists($index, $array)) {
        $element = $array[$index];
        $keys = array_keys($array);
        unset($array[$index]);

       
        $insertIndex = array_search($index, $keys) - $positionsBack;

        if ($insertIndex < 0) {
            $insertIndex = 0;
        }

        $array = array_slice($array, 0, $insertIndex, true) +
                 array($index => $element) +
                 array_slice($array, $insertIndex, count($array) - $insertIndex, true);
    }
}
private function calculate_channels($hexagrams){
    
    foreach  ($this->channels as $index=>$value){

        $channel=$value[0];
        $state=$value[1];
        $gates=explode("-",$channel,2);

    } 


}



function dmsToDecimal($degrees, $minutes = 0, $seconds = 0) {
    // Ensure all components are numeric
    $degrees = is_numeric($degrees) ? (float)$degrees : 0;
    $minutes = is_numeric($minutes) ? (float)$minutes : 0;
    $seconds = is_numeric($seconds) ? (float)$seconds : 0;

    // Calculate the decimal degrees
    $decimalDegrees = $degrees + ($minutes / 60) + ($seconds / 3600);

    return $decimalDegrees;
}
private function DDtoDMS($dec)
	{
		// Converts decimal format to DMS ( Degrees / minutes / seconds ) 
		$vars = explode(".",$dec);
		$deg = $vars[0];
		$tempma = "0.".$vars[1];

		$tempma = $tempma * 3600;
		$min = floor($tempma / 60);
		$sec = $tempma - ($min*60);

		return array("deg"=>$deg,"min"=>$min,"sec"=>$sec);
	}    




function extractHouseData($data) {
    $houses = $data["house"];
    

    $houseData = array();
    foreach ($houses as $houseIndex => $value) {
        $houseData[$houseIndex] = array(
            'House name' => $value["house number"],
            'sign' => $value["sign"],
            'longitude' => $value["longitude"]
        );
    }

    return $houseData;
}




//Print hd
function printDataInDivLayout() {
    $output="";
    $output.='<div class="row">';
    
    // Print the modified data with 88 degrees back
    $output.= '<div class="col">';
    $output.= '<h2>Design</h2>';
    $data = $this->design;
    $outputD="";
    foreach ($data as $planet => $info) {
        
            $outputD.= "$planet: {$info[0]}: Gate:{$info[1][0]},Line:  {$info[1][1]} <br>";
       
    }

    $output.= $outputD;
    
    $output.= '</div>';
    
      // Print the original data
      $output.= '<div class="col">';
      $output.= '<h2>Personality</h2>';
     
      $data = $this->personality;
     
      $outputP="";
      foreach ($data as $planet => $info) {
       
        $outputP.= "$planet: {$info[0]}: Gate:{$info[1][0]},Line:  {$info[1][1]} <br>";
    }

      $output.= $outputP;
      $output.= '</div>';
      $output.= '</div>';
     return $output;
    }


function printToCsv($filePath){
        $data = $this->design;
        $outputD = "";
        // Create or open the file for writing
        $file = fopen($filePath, 'w');
        // Add headers to CSV file
        fputcsv($file, ['Type', 'Planet', 'Sign', 'Gate', 'Line']);
        // Write design data to the file
        foreach ($data as $planet => $info) {
            fputcsv($file, ['Design', $planet, $info[0], $info[1], $info[2]]);
        }
        // Write personality data to the file
      
        $data = $this->personality;
        foreach ($data as $planet => $info) {
            fputcsv($file, ['Personality', $planet, $info[0], $info[1], $info[2]]);
        }
        // Close the file
        fclose($file);
    }


// Ensure this function is within the Hd class
function appendToCsv($filePath){
    // Read existing CSV data
    $existingData = [];
    if (file_exists($filePath)) {
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle)) !== FALSE) {
                $existingData[] = $row;
            }
            fclose($handle);
        }
    }
    // Compile new data set without headers
    $newData = [];
    $types = ['Design' => $this->design, 'Personality' => $this->personality];
    foreach ($types as $dataType => $data) {
        foreach ($data as $planet => $info) {
            // Find the index of the corresponding row in existing data
            $rowIndex = null;
            foreach ($existingData as $index => $row) {
                if ($row[0] == $dataType && $row[1] == $planet) {
                    $rowIndex = $index;
                    break;
                }
            }
            // If the row exists, append new info data
            if ($rowIndex !== null) {
                $existingData[$rowIndex] = array_merge($existingData[$rowIndex], [$info[0], $info[1], $info[2]]);
            } else {
                // If the row does not exist, create a new one (for new planets)
                $existingData[] = [$dataType, $planet, $info[0], $info[1], $info[2]];
            }
        }
    }
    // Write back to CSV
    $handle = fopen($filePath, 'w');
    foreach ($existingData as $row) {
        fputcsv($handle, $row);
    }
    fclose($handle);
}

function print_Gates($gates){
    echo("<table>");
    echo("<tr>");
   
    echo("<td>Sign</td>");
    echo("<td>Gate</td>");
    echo("<td>Line</td>");
    echo("</tr>");

   

foreach($gates as $index =>$value){
        echo("<tr>");
        
        if($index>12){
            echo(" <td style=\"background-color=\"red\"\"> ".$value[0]."  </td> ");
            echo("<td style=\"background=\"red\"\">  ".$value[1]."  </td> ");
            echo(" <td style=\"background=\"red\"\">  ".$value[2]."  </td> ");

        }
        else{
        echo("  <td> ".$value[0]."  </td> ");
        echo("  <td> ".$value[1]."  </td> ");
        echo("  <td> ".$value[2]."  </td> ");
        echo("</tr>");}
       }  


echo("</table>");
return 0;
}

public function get_hd_result_display(){
    $hd_display=$this->printDataInDivLayout();
    return $hd_display;
}




}
