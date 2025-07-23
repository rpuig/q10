<?php
class cosmo {    

private $dtb;
public $longitude;
public $declination;
public $house_pos;

public function __CONSTRUCT($db){

$this->dtb=$db;


    }
Function GetCosmodynes($longitude1, $declination1, $house_pos1, $longitude2, $declination2, $house_pos2, $hob, $mob)
{
  $dynes = array();
  $aspect_power = array();		//PlanetAspectPower()
  $harmony = array();			//PlanetHarmony()
  $discord = array();			//PlanetDiscord()
  $tot_p = 0;					//TotP1
  $tot_h = 0;					//TotH1

  $p1_limit = 10;
  $p2_limit = 10;

  if (($hob[1] == 12) And ($mob[1] == 0))
  {
    $p1_limit = 9;
  }

  if (($hob[2] == 12) And ($mob[2] == 0))
  {
    $p2_limit = 9;
  }

  for ($y = 0; $y <= $p1_limit; $y++)
  {
    for ($x = 0; $x <= $p2_limit; $x++)
    {
      if (($y == 7 Or $y == 8 Or $y == 9) And ($x == 7 Or $x == 8 Or $x == 9))
      {
        // skip this planet and move to the next
        continue;
      }
      else
      {
        // get house of 1st planet
        $yh = floor($house_pos1[$y]);
        if ($y == 10)
        {
          $yh = 10;
          $orb30y = 3;
          $orb45y = 5;
          $orb60y = 7;
          $orb90y = 10;
          $orb180y = 12;
          $pow30y = 3;
          $pow45y = 5;
          $pow60y = 7;
          $pow90y = 10;
          $pow180y = 12;
        }
        else
        {
          // find ORB for 1st planet ($y), dependent upon what house $y is in AND whether it is a Luminary or a planet
          if (($y != 0 And $y != 1) And ($yh == 3 Or $yh == 6 Or $yh == 9 Or $yh == 12))
          {
            $orb30y = 1;
            $orb45y = 3;
            $orb60y = 5;
            $orb90y = 6;
            $orb180y = 8;
            $pow30y = 1;
            $pow45y = 3;
            $pow60y = 5;
            $pow90y = 6;
            $pow180y = 8;
            if ($y == 2)
            {
              $pow30y += 1;
              $pow45y += 1;
              $pow60y += 1;
              $pow90y += 2;
              $pow180y += 3;
            }
          }
          elseif (($y == 0 Or $y == 1) And ($yh == 3 Or $yh == 6 Or $yh == 9 Or $yh == 12))
          {
            $orb30y = 2;
            $orb45y = 4;
            $orb60y = 6;
            $orb90y = 8;
            $orb180y = 11;
            $pow30y = 2;
            $pow45y = 4;
            $pow60y = 6;
            $pow90y = 8;
            $pow180y = 11;
          }
          elseif (($y != 0 And $y != 1) And ($yh == 2 Or $yh == 5 Or $yh == 8 Or $yh == 11))
          {
            $orb30y = 2;
            $orb45y = 4;
            $orb60y = 6;
            $orb90y = 8;
            $orb180y = 10;
            $pow30y = 2;
            $pow45y = 4;
            $pow60y = 6;
            $pow90y = 8;
            $pow180y = 10;
            if ($y == 2)
            {
              $pow30y += 1;
              $pow45y += 1;
              $pow60y += 1;
              $pow90y += 2;
              $pow180y += 3;
            }
          }
          elseif (($y == 0 Or $y == 1) And ($yh == 2 Or $yh == 5 Or $yh == 8 Or $yh == 11))
          {
            $orb30y = 3;
            $orb45y = 5;
            $orb60y = 7;
            $orb90y = 10;
            $orb180y = 13;
            $pow30y = 3;
            $pow45y = 5;
            $pow60y = 7;
            $pow90y = 10;
            $pow180y = 13;
          }
          elseif (($y != 0 And $y != 1) And ($yh == 1 Or $yh == 4 Or $yh == 7 Or $yh == 10))
          {
            $orb30y = 3;
            $orb45y = 5;
            $orb60y = 7;
            $orb90y = 10;
            $orb180y = 12;
            $pow30y = 3;
            $pow45y = 5;
            $pow60y = 7;
            $pow90y = 10;
            $pow180y = 12;
            if ($y == 2)
            {
              $pow30y += 1;
              $pow45y += 1;
              $pow60y += 1;
              $pow90y += 2;
              $pow180y += 3;
            }
          }
          elseif (($y == 0 Or $y == 1) And ($yh == 1 Or $yh == 4 Or $yh == 7 Or $yh == 10))
          {
            $orb30y = 4;
            $orb45y = 6;
            $orb60y = 8;
            $orb90y = 12;
            $orb180y = 15;
            $pow30y = 4;
            $pow45y = 6;
            $pow60y = 8;
            $pow90y = 12;
            $pow180y = 15;
          }
        }

        // get house of 2nd planet
        $xh = floor($house_pos2[$x]);
        if ($x == 10)
        {
          $xh = 10;
          $orb30x = 3;
          $orb45x = 5;
          $orb60x = 7;
          $orb90x = 10;
          $orb180x = 12;
          $pow30x = 3;
          $pow45x = 5;
          $pow60x = 7;
          $pow90x = 10;
          $pow180x = 12;
        }
        else
        {
          // find ORB for 2nd planet ($x), dependent upon what house $x is in AND whether it is a Luminary or a planet
          if (($x != 0 And $x != 1) And ($xh == 3 Or $xh == 6 Or $xh == 9 Or $xh == 12))
          {
            $orb30x = 1;
            $orb45x = 3;
            $orb60x = 5;
            $orb90x = 6;
            $orb180x = 8;
            $pow30x = 1;
            $pow45x = 3;
            $pow60x = 5;
            $pow90x = 6;
            $pow180x = 8;
            if ($x == 2)
            {
              $pow30x += 1;
              $pow45x += 1;
              $pow60x += 1;
              $pow90x += 2;
              $pow180x += 3;
            }
          }
          elseif (($x == 0 Or $x == 1) And ($xh == 3 Or $xh == 6 Or $xh == 9 Or $xh == 12))
          {
            $orb30x = 2;
            $orb45x = 4;
            $orb60x = 6;
            $orb90x = 8;
            $orb180x = 11;
            $pow30x = 2;
            $pow45x = 4;
            $pow60x = 6;
            $pow90x = 8;
            $pow180x = 11;
          }
          elseif (($x != 0 And $x != 1) And ($xh == 2 Or $xh == 5 Or $xh == 8 Or $xh == 11))
          {
            $orb30x = 2;
            $orb45x = 4;
            $orb60x = 6;
            $orb90x = 8;
            $orb180x = 10;
            $pow30x = 2;
            $pow45x = 4;
            $pow60x = 6;
            $pow90x = 8;
            $pow180x = 10;
            if ($x == 2)
            {
              $pow30x += 1;
              $pow45x += 1;
              $pow60x += 1;
              $pow90x += 2;
              $pow180x += 3;
            }
          }
          elseif (($x == 0 Or $x == 1) And ($xh == 2 Or $xh == 5 Or $xh == 8 Or $xh == 11))
          {
            $orb30x = 3;
            $orb45x = 5;
            $orb60x = 7;
            $orb90x = 10;
            $orb180x = 13;
            $pow30x = 3;
            $pow45x = 5;
            $pow60x = 7;
            $pow90x = 10;
            $pow180x = 13;
          }
          elseif (($x != 0 And $x != 1) And ($xh == 1 Or $xh == 4 Or $xh == 7 Or $xh == 10))
          {
            $orb30x = 3;
            $orb45x = 5;
            $orb60x = 7;
            $orb90x = 10;
            $orb180x = 12;
            $pow30x = 3;
            $pow45x = 5;
            $pow60x = 7;
            $pow90x = 10;
            $pow180x = 12;
            if ($x == 2)
            {
              $pow30x += 1;
              $pow45x += 1;
              $pow60x += 1;
              $pow90x += 2;
              $pow180x += 3;
            }
          }
          elseif (($x == 0 Or $x == 1) And ($xh == 1 Or $xh == 4 Or $xh == 7 Or $xh == 10))
          {
            $orb30x = 4;
            $orb45x = 6;
            $orb60x = 8;
            $orb90x = 12;
            $orb180x = 15;
            $pow30x = 4;
            $pow45x = 6;
            $pow60x = 8;
            $pow90x = 12;
            $pow180x = 15;
          }
        }
      }

      $orb30 = $orb30y;
      if ($orb30x >= $orb30y)
      {
        $orb30 = $orb30x;
      }

      $orb45 = $orb45y;
      if ($orb45x >= $orb45y)
      {
        $orb45 = $orb45x;
      }
      $orb60 = $orb60y;
      if ($orb60x >= $orb60y)
      {
        $orb60 = $orb60x;
      }
      $orb90 = $orb90y;
      if ($orb90x >= $orb90y)
      {
        $orb90 = $orb90x;
      }
      $orb180 = $orb180y;
      if ($orb180x >= $orb180y)
      {
        $orb180 = $orb180x;
      }

      $pow30 = $pow30y;
      if ($pow30x >= $pow30y)
      {
        $pow30 = $pow30x;
      }

      $pow45 = $pow45y;
      if ($pow45x >= $pow45y)
      {
        $pow45 = $pow45x;
      }
      $pow60 = $pow60y;
      if ($pow60x >= $pow60y)
      {
        $pow60 = $pow60x;
      }
      $pow90 = $pow90y;
      if ($pow90x >= $pow90y)
      {
        $pow90 = $pow90x;
      }
      $pow180 = $pow180y;
      if ($pow180x >= $pow180y)
      {
        $pow180 = $pow180x;
      }

      // is there an aspect within orb?
      $da = Abs($longitude1[$y] - $longitude2[$x]);			//$da means distance apart
      if ($da > 180)
      {
        $da = 360 - $da;
      }

      $q = 1;
      $k = $da;

      if ($k <= $orb180)
      {
        $q = 2;
        $orbxx = $pow180;
        $daxx = $da;
      }
      elseif (($k <= (30 + $orb30)) And ($k >= (30 - $orb30)))
      {
        $q = 8;
        $orbxx = $pow30;
        $daxx = $da - 30;
      }
      elseif (($k <= (45 + $orb45)) And ($k >= (45 - $orb45)))
      {
        $q = 9;
        $orbxx = $pow45;
        $daxx = $da - 45;
      }
      elseif (($k <= (60 + $orb60)) And ($k >= (60 - $orb60)))
      {
        $q = 3;
        $orbxx = $pow60;
        $daxx = $da - 60;
      }
      elseif (($k <= (90 + $orb90)) And ($k >= (90 - $orb90)))
      {
        $q = 4;
        $orbxx = $pow90;
        $daxx = $da - 90;
      }
      // $da is checked here to separate the overlap in the two aspects from 129 - 132 degrees for luminaries
      elseif (($da <= 130) And ($k <= (120 + $orb90)) And ($k >= (120 - $orb90)))
      {
        $q = 5;
        $orbxx = $pow90;
        $daxx = $da - 120;
      }
      elseif (($da > 130) And ($k <= (135 + $orb45)) And ($k >= (135 - $orb45)))
      {
        $q = 10;
        $orbxx = $pow45;
        $daxx = $da - 135;
      }
      elseif (($k <= (150 + $orb30)) And ($k >= (150 - $orb30)))
      {
        $q = 11;
        $orbxx = $pow30;
        $daxx = $da - 150;
      }
      elseif ($k >= (180 - $orb180))
      {
        $q = 6;
        $orbxx = $pow180;
        $daxx = $da - 180;
      }

      if ($q > 1)
      {
        // we have an aspect, so get all the proper numbers
        $dyne_val = $orbxx - Abs($daxx);
        $aspect_power[$y] += $dyne_val;

        //get planetary harmony and discord
        if ($q == 3 Or $q == 5 Or $q == 8)
        {
          $harmony[$y] += $dyne_val;
        }

        if ($q == 4 Or $q == 9 Or $q == 10)
        {
          $discord[$y] += $dyne_val;
        }

        if ($q == 2)
        {
          // check out conjunctions between planets
          if (($y == 0 And $x == 1) Or ($x == 0 And $y == 1))
          {
            // these conjunctions treated as harmonious
            $harmony[$y] += $dyne_val;
          }

          if (($y == 0 And $x == 3) Or ($x == 0 And $y == 3))
          {
            // these conjunctions treated as harmonious
            $harmony[$y] += $dyne_val;
          }

          if (($y == 0 And $x == 5) Or ($x == 0 And $y == 5))
          {
            // these conjunctions treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }

          if (($y == 1 And $x == 3) Or ($x == 1 And $y == 3))
          {
            // these conjunctions treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }

          if (($y == 4 And $x == 6) Or ($x == 4 And $y == 6))
          {
            // these conjunctions treated as discordant
            $discord[$y] += ($dyne_val / 2);
          }

          if (($y == 4 And $x == 9) Or ($x == 4 And $y == 9))
          {
            // these conjunctions treated as discordant
            $discord[$y] += ($dyne_val / 2);
          }

          if (($y == 6 And $x == 9) Or ($x == 6 And $y == 9))
          {
            // these conjunctions treated as discordant
            $discord[$y] += ($dyne_val / 2);
          }

          if (($y == 6 And $x == 10) Or ($x == 6 And $y == 10))
          {
            // these conjunctions treated as discordant
            $discord[$y] += ($dyne_val / 2);
          }

          if (($y == 9 And $x == 10) Or ($x == 9 And $y == 10))
          {
            // these conjunctions treated as discordant
            $discord[$y] += ($dyne_val / 2);
          }
        }

        if ($q == 6)
        {
          // some opposition aspects treated as discordant
          if (($y == 4 And $x != 5) Or ($x == 4 And $y != 5))
          {
            if (($y == 4 And $x != 10) Or ($x == 4 And $y != 10))
            {
              if (($y == 4 And $x != 3) Or ($x == 4 And $y != 3))
              {
                // these oppositions treated as discordant
                $discord[$y] += $dyne_val;
              }
            }
          }

          if (($y == 6 And $x != 5) Or ($x == 6 And $y != 5))
          {
            if (($y == 6 And $x != 10) Or ($x == 6 And $y != 10))
            {
              if (($y == 6 And $x != 4) Or ($x == 6 And $y != 4))
              {
                // these oppositions treated as discordant
                if ($y == 6 And $x == 6)
                {
                  // do not do anything with Saturn opposite Saturn
                }
                else
                {
                  $discord[$y] += $dyne_val;
                }
              }
            }
          }

          if (($y == 9 And $x != 5) Or ($x == 9 And $y != 5))
          {
            if (($y == 9 And $x != 10) Or ($x == 9 And $y != 10))
            {
              if (($y == 9 And $x != 4) Or ($x == 9 And $y != 4))
              {
                if (($y == 9 And $x != 6) Or ($x == 9 And $y != 6))
                {
                  // these oppositions treated as discordant
                  $discord[$y] += $dyne_val;
                }
              }
            }
          }

          if (($y == 0 And $x == 1) Or ($x == 0 And $y == 1))
          {
            // these oppositions treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }

          if (($y == 0 And $x == 3) Or ($x == 0 And $y == 3))
          {
            // these oppositions treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }

          if (($y == 0 And $x == 10) Or ($x == 0 And $y == 10))
          {
            // these oppositions treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }

          if (($y == 1 And $x == 10) Or ($x == 1 And $y == 10))
          {
            // these oppositions treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }

          if (($y == 1 And $x == 3) Or ($x == 1 And $y == 3))
          {
            // these oppositions treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }

          if (($y == 3 And $x == 5) Or ($x == 3 And $y == 5))
          {
            // these oppositions treated as harmonious
            $harmony[$y] += $dyne_val;
          }

          if (($y == 3 And $x == 10) Or ($x == 3 And $y == 10))
          {
            // these oppositions treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }

          if (($y == 5 And $x == 10) Or ($x == 5 And $y == 10))
          {
            // these oppositions treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }

          if (($y == 2 And $x == 3) Or ($x == 2 And $y == 3))
          {
            // these oppositions treated as harmonious
            $harmony[$y] += ($dyne_val / 4);
          }
        }

        if ($y == 5 Or $x == 5)
        {
          if (($y == $x) And ($q == 2))
          {
            // ignore Jupiter conjunct Jupiter
          }
          else
          {
            // these treated as harmonious
            $harmony[$y] += ($dyne_val / 2);
          }
        }

        if ($y == 3 Or $x == 3)
        {
          if (($y == 7 Or $y == 8 Or $y == 9 Or $x == 7 Or $x == 8 Or $x == 9) And ($q == 2 Or $q == 6 Or $q == 11))
          {
            // ignore
          }
          else
          {
            // these oppositions treated as harmonious
            $harmony[$y] += ($dyne_val / 4);
          }
        }

        if ($y == 6 Or $x == 6)
        {
          if (($y == $x) And ($q == 2))
          {
            // ignore Saturn conjunct Saturn
          }
          else
          {
            // Saturn aspects treated as discordant
            $discord[$y] += ($dyne_val / 2);
          }
        }

        if ($y == 4 Or $x == 4)
        {
          // Mars aspects treated as discordant
          $discord[$y] += ($dyne_val / 4);
        }
      }

      // now do declinations
      $diff_decl = Abs(Abs($declination1[$y]) - Abs($declination2[$x]));
      if ($diff_decl < 1)
      {
        if (($y != 0 And $y != 1 And $y != 2) And ($yh == 3 Or $yh == 6 Or $yh == 9 Or $yh == 12))
        {
          $orb180y = 8;
        }
        if (($y == 0 Or $y == 1 Or $y == 2) And ($yh == 3 Or $yh == 6 Or $yh == 9 Or $yh == 12))
        {
          $orb180y = 11;
        }

        if (($y != 0 And $y != 1 And $y != 2) And ($yh == 2 Or $yh == 5 Or $yh == 8 Or $yh == 11))
        {
          $orb180y = 10;
        }
        if (($y == 0 Or $y == 1 Or $y == 2) And ($yh == 2 Or $yh == 5 Or $yh == 8 Or $yh == 11))
        {
          $orb180y = 13;
        }

        if (($y != 0 And $y != 1 And $y != 2) And ($yh == 1 Or $yh == 4 Or $yh == 7 Or $yh == 10))
        {
          $orb180y = 12;
        }
        if (($y == 0 Or $y == 1 Or $y == 2) And ($yh == 1 Or $yh == 4 Or $yh == 7 Or $yh == 10))
        {
          $orb180y = 15;
        }

        if (($x != 0 And $x != 1 And $x != 2) And ($xh == 3 Or $xh == 6 Or $xh == 9 Or $xh == 12))
        {
          $orb180x = 8;
        }
        if (($x == 0 Or $x == 1 Or $x == 2) And ($xh == 3 Or $xh == 6 Or $xh == 9 Or $xh == 12))
        {
          $orb180x = 11;
        }

        if (($x != 0 And $x != 1 And $x != 2) And ($xh == 2 Or $xh == 5 Or $xh == 8 Or $xh == 11))
        {
          $orb180x = 10;
        }
        if (($x == 0 Or $x == 1 Or $x == 2) And ($xh == 2 Or $xh == 5 Or $xh == 8 Or $xh == 11))
        {
          $orb180x = 13;
        }

        if (($x != 0 And $x != 1 And $x != 2) And ($xh == 1 Or $xh == 4 Or $xh == 7 Or $xh == 10))
        {
          $orb180x = 12;
        }
        if (($x == 0 Or $x == 1 Or $x == 2) And ($xh == 1 Or $xh == 4 Or $xh == 7 Or $xh == 10))
        {
          $orb180x = 15;
        }

        $orb180 = $orb180y;
        if ($orb180x >= $orb180y)
        {
          $orb180 = $orb180x;
        }

        $decl_power = $orb180 * (1 - $diff_decl);
        $aspect_power[$y] += $decl_power;

        if ($y == 5 Or $x == 5)
        {
          if (($y == $x) And ($q == 2))
          {
            // ignore Jupiter parallel Jupiter
          }
          else
          {
            // these treated as harmonious
            $harmony[$y] += ($decl_power / 2);
          }
        }

        if ($y == 3 Or $x == 3)
        {
          if ($y == 7 Or $y == 8 Or $y == 9 Or $x == 7 Or $x == 8 Or $x == 9)
          {
            // ignore
          }
          else
          {
            // these treated as harmonious
            $harmony[$y] += ($decl_power / 4);
          }
        }

        if ($y == 6 Or $x == 6)
        {
          if (($y == $x) And ($q == 2))
          {
            // ignore Saturn parallel Saturn
          }
          else
          {
            // Saturn aspects treated as discordant
            $discord[$y] += ($decl_power / 2);
          }
        }

        if ($y == 4 Or $x == 4)
        {
          // Mars aspects treated as discordant
          $discord[$y] += ($decl_power / 4);
        }
      }
    }
  }

  for ($y = 0; $y <= $p1_limit; $y++)
  {
    $dynes[0] += $aspect_power[$y];
    $dynes[1] += $harmony[$y] - $discord[$y];
  }

  return $dynes;
}
Function GetMutualReceptions($longitude1, $longitude2)
{
  $num_MRs = 0;

  for ($y = 0; $y <= 9; $y++)
  {

    $sy = floor($longitude1[$y] / 30) + 1;
    for ($x = 0; $x <= 9; $x++)
    {
      // get sign of each planet
      $sx = floor($longitude2[$x] / 30) + 1;

      // look for all mutual receptions
      if ($y == 0 And ($sy == 4 Or $sy == 2) And $x == 1 And ($sx == 1 Or $sx == 5))
        $num_MRs++;
      if ($y == 0 And ($sy == 3 Or $sy == 11) And $x == 7 And ($sx == 1 Or $sx == 5))
        $num_MRs++;
      if ($y == 0 And ($sy == 9 Or $sy == 12) And $x == 8 And ($sx == 1 Or $sx == 5))
        $num_MRs++;
      if ($y == 0 And ($sy == 5 Or $sy == 8) And $x == 9 And ($sx == 1 Or $sx == 5))
        $num_MRs++;
      if ($y == 0 And ($sy == 3 Or $sy == 6 Or $sy == 11) And $x == 2 And ($sx == 1 Or $sx == 5))
        $num_MRs++;
      if ($y == 0 And ($sy == 2 Or $sy == 7 Or $sy == 12) And $x == 3 And ($sx == 1 Or $sx == 5))
        $num_MRs++;
      if ($y == 0 And ($sy == 1 Or $sy == 8 Or $sy == 10) And $x == 4 And ($sx == 1 Or $sx == 5))
        $num_MRs++;
      if ($y == 0 And ($sy == 4 Or $sy == 9 Or $sy == 12) And $x == 5 And ($sx == 1 Or $sx == 5))
        $num_MRs++;
      if ($y == 0 And ($sy == 7 Or $sy == 10 Or $sy == 11) And $x == 6 And ($sx == 1 Or $sx == 5))
        $num_MRs++;

      if ($y == 1 And ($sy == 3 Or $sy == 11) And $x == 7 And ($sx == 2 Or $sx == 4))
        $num_MRs++;
      if ($y == 1 And ($sy == 9 Or $sy == 12) And $x == 8 And ($sx == 2 Or $sx == 4))
        $num_MRs++;
      if ($y == 1 And ($sy == 5 Or $sy == 8) And $x == 9 And ($sx == 2 Or $sx == 4))
        $num_MRs++;
      if ($y == 1 And ($sy == 3 Or $sy == 6 Or $sy == 11) And $x == 2 And ($sx == 2 Or $sx == 4))
        $num_MRs++;
      if ($y == 1 And ($sy == 2 Or $sy == 7 Or $sy == 12) And $x == 3 And ($sx == 2 Or $sx == 4))
        $num_MRs++;
      if ($y == 1 And ($sy == 1 Or $sy == 8 Or $sy == 10) And $x == 4 And ($sx == 2 Or $sx == 4))
        $num_MRs++;
      if ($y == 1 And ($sy == 4 Or $sy == 9 Or $sy == 12) And $x == 5 And ($sx == 2 Or $sx == 4))
        $num_MRs++;
      if ($y == 1 And ($sy == 7 Or $sy == 10 Or $sy == 11) And $x == 6 And ($sx == 2 Or $sx == 4))
        $num_MRs++;

      if ($y == 2 And ($sy == 3 Or $sy == 11) And $x == 7 And ($sx == 3 Or $sx == 6 Or $sx == 11))
        $num_MRs++;
      if ($y == 2 And ($sy == 9 Or $sy == 12) And $x == 8 And ($sx == 3 Or $sx == 6 Or $sx == 11))
        $num_MRs++;
      if ($y == 2 And ($sy == 5 Or $sy == 8) And $x == 9 And ($sx == 3 Or $sx == 6 Or $sx == 11))
        $num_MRs++;
      if ($y == 2 And ($sy == 2 Or $sy == 7 Or $sy == 12) And $x == 3 And ($sx == 3 Or $sx == 6 Or $sx == 11))
        $num_MRs++;
      if ($y == 2 And ($sy == 1 Or $sy == 8 Or $sy == 10) And $x == 4 And ($sx == 3 Or $sx == 6 Or $sx == 11))
        $num_MRs++;
      if ($y == 2 And ($sy == 4 Or $sy == 9 Or $sy == 12) And $x == 5 And ($sx == 3 Or $sx == 6 Or $sx == 11))
        $num_MRs++;
      if ($y == 2 And ($sy == 7 Or $sy == 10 Or $sy == 11) And $x == 6 And ($sx == 3 Or $sx == 6 Or $sx == 11))
        $num_MRs++;

      if ($y == 3 And ($sy == 3 Or $sy == 11) And $x == 7 And ($sx == 2 Or $sx == 7 Or $sx == 12))
        $num_MRs++;
      if ($y == 3 And ($sy == 9 Or $sy == 12) And $x == 8 And ($sx == 2 Or $sx == 7 Or $sx == 12))
        $num_MRs++;
      if ($y == 3 And ($sy == 5 Or $sy == 8) And $x == 9 And ($sx == 2 Or $sx == 7 Or $sx == 12))
        $num_MRs++;
      if ($y == 3 And ($sy == 1 Or $sy == 8 Or $sy == 10) And $x == 4 And ($sx == 2 Or $sx == 7 Or $sx == 12))
        $num_MRs++;
      if ($y == 3 And ($sy == 4 Or $sy == 9 Or $sy == 12) And $x == 5 And ($sx == 2 Or $sx == 7 Or $sx == 12))
        $num_MRs++;
      if ($y == 3 And ($sy == 7 Or $sy == 10 Or $sy == 11) And $x == 6 And ($sx == 2 Or $sx == 7 Or $sx == 12))
        $num_MRs++;

      if ($y == 4 And ($sy == 3 Or $sy == 11) And $x == 7 And ($sx == 1 Or $sx == 8 Or $sx == 10))
        $num_MRs++;
      if ($y == 4 And ($sy == 9 Or $sy == 12) And $x == 8 And ($sx == 1 Or $sx == 8 Or $sx == 10))
        $num_MRs++;
      if ($y == 4 And ($sy == 5 Or $sy == 8) And $x == 9 And ($sx == 1 Or $sx == 8 Or $sx == 10))
        $num_MRs++;
      if ($y == 4 And ($sy == 4 Or $sy == 9 Or $sy == 12) And $x == 5 And ($sx == 1 Or $sx == 8 Or $sx == 10))
        $num_MRs++;
      if ($y == 4 And ($sy == 7 Or $sy == 10 Or $sy == 11) And $x == 6 And ($sx == 1 Or $sx == 8 Or $sx == 10))
        $num_MRs++;

      if ($y == 5 And ($sy == 3 Or $sy == 11) And $x == 7 And ($sx == 4 Or $sx == 9 Or $sx == 12))
        $num_MRs++;
      if ($y == 5 And ($sy == 9 Or $sy == 12) And $x == 8 And ($sx == 4 Or $sx == 9 Or $sx == 12))
        $num_MRs++;
      if ($y == 5 And ($sy == 5 Or $sy == 8) And $x == 9 And ($sx == 4 Or $sx == 9 Or $sx == 12))
        $num_MRs++;
      if ($y == 5 And ($sy == 7 Or $sy == 10 Or $sy == 11) And $x == 6 And ($sx == 4 Or $sx == 9 Or $sx == 12))
        $num_MRs++;

      if ($y == 6 And ($sy == 3 Or $sy == 11) And $x == 7 And ($sx == 7 Or $sx == 10 Or $sx == 11))
        $num_MRs++;
      if ($y == 6 And ($sy == 9 Or $sy == 12) And $x == 8 And ($sx == 7 Or $sx == 10 Or $sx == 11))
        $num_MRs++;
      if ($y == 6 And ($sy == 5 Or $sy == 8) And $x == 9 And ($sx == 7 Or $sx == 10 Or $sx == 11))
        $num_MRs++;

      if ($y == 7 And ($sy == 9 Or $sy == 12) And $x == 8 And ($sx == 3 Or $sx == 11))
        $num_MRs++;
      if ($y == 7 And ($sy == 5 Or $sy == 8) And $x == 9 And ($sx == 3 Or $sx == 11))
        $num_MRs++;

      if ($y == 8 And ($sy == 5 Or $sy == 8) And $x == 9 And ($sx == 9 Or $sx == 12))
        $num_MRs++;


      if ($x == 0 And ($sx == 4 Or $sx == 2) And $y == 1 And ($sy == 1 Or $sy == 5))
        $num_MRs++;
      if ($x == 0 And ($sx == 3 Or $sx == 11) And $y == 7 And ($sy == 1 Or $sy == 5))
        $num_MRs++;
      if ($x == 0 And ($sx == 9 Or $sx == 12) And $y == 8 And ($sy == 1 Or $sy == 5))
        $num_MRs++;
      if ($x == 0 And ($sx == 5 Or $sx == 8) And $y == 9 And ($sy == 1 Or $sy == 5))
        $num_MRs++;
      if ($x == 0 And ($sx == 3 Or $sx == 6 Or $sx == 11) And $y == 2 And ($sy == 1 Or $sy == 5))
        $num_MRs++;
      if ($x == 0 And ($sx == 2 Or $sx == 7 Or $sx == 12) And $y == 3 And ($sy == 1 Or $sy == 5))
        $num_MRs++;
      if ($x == 0 And ($sx == 1 Or $sx == 8 Or $sx == 10) And $y == 4 And ($sy == 1 Or $sy == 5))
        $num_MRs++;
      if ($x == 0 And ($sx == 4 Or $sx == 9 Or $sx == 12) And $y == 5 And ($sy == 1 Or $sy == 5))
        $num_MRs++;
      if ($x == 0 And ($sx == 7 Or $sx == 10 Or $sx == 11) And $y == 6 And ($sy == 1 Or $sy == 5))
        $num_MRs++;

      if ($x == 1 And ($sx == 3 Or $sx == 11) And $y == 7 And ($sy == 2 Or $sy == 4))
        $num_MRs++;
      if ($x == 1 And ($sx == 9 Or $sx == 12) And $y == 8 And ($sy == 2 Or $sy == 4))
        $num_MRs++;
      if ($x == 1 And ($sx == 5 Or $sx == 8) And $y == 9 And ($sy == 2 Or $sy == 4))
        $num_MRs++;
      if ($x == 1 And ($sx == 3 Or $sx == 6 Or $sx == 11) And $y == 2 And ($sy == 2 Or $sy == 4))
        $num_MRs++;
      if ($x == 1 And ($sx == 2 Or $sx == 7 Or $sx == 12) And $y == 3 And ($sy == 2 Or $sy == 4))
        $num_MRs++;
      if ($x == 1 And ($sx == 1 Or $sx == 8 Or $sx == 10) And $y == 4 And ($sy == 2 Or $sy == 4))
        $num_MRs++;
      if ($x == 1 And ($sx == 4 Or $sx == 9 Or $sx == 12) And $y == 5 And ($sy == 2 Or $sy == 4))
        $num_MRs++;
      if ($x == 1 And ($sx == 7 Or $sx == 10 Or $sx == 11) And $y == 6 And ($sy == 2 Or $sy == 4))
        $num_MRs++;


      if ($x == 2 And ($sx == 3 Or $sx == 11) And $y == 7 And ($sy == 3 Or $sy == 6 Or $sy == 11))
        $num_MRs++;
      if ($x == 2 And ($sx == 9 Or $sx == 12) And $y == 8 And ($sy == 3 Or $sy == 6 Or $sy == 11))
        $num_MRs++;
      if ($x == 2 And ($sx == 5 Or $sx == 8) And $y == 9 And ($sy == 3 Or $sy == 6 Or $sy == 11))
        $num_MRs++;
      if ($x == 2 And ($sx == 2 Or $sx == 7 Or $sx == 12) And $y == 3 And ($sy == 3 Or $sy == 6 Or $sy == 11))
        $num_MRs++;
      if ($x == 2 And ($sx == 1 Or $sx == 8 Or $sx == 10) And $y == 4 And ($sy == 3 Or $sy == 6 Or $sy == 11))
        $num_MRs++;
      if ($x == 2 And ($sx == 4 Or $sx == 9 Or $sx == 12) And $y == 5 And ($sy == 3 Or $sy == 6 Or $sy == 11))
        $num_MRs++;
      if ($x == 2 And ($sx == 7 Or $sx == 10 Or $sx == 11) And $y == 6 And ($sy == 3 Or $sy == 6 Or $sy == 11))
        $num_MRs++;


      if ($x == 3 And ($sx == 3 Or $sx == 11) And $y == 7 And ($sy == 2 Or $sy == 7 Or $sy == 12))
        $num_MRs++;
      if ($x == 3 And ($sx == 9 Or $sx == 12) And $y == 8 And ($sy == 2 Or $sy == 7 Or $sy == 12))
        $num_MRs++;
      if ($x == 3 And ($sx == 5 Or $sx == 8) And $y == 9 And ($sy == 2 Or $sy == 7 Or $sy == 12))
        $num_MRs++;
      if ($x == 3 And ($sx == 1 Or $sx == 8 Or $sx == 10) And $y == 4 And ($sy == 2 Or $sy == 7 Or $sy == 12))
        $num_MRs++;
      if ($x == 3 And ($sx == 4 Or $sx == 9 Or $sx == 12) And $y == 5 And ($sy == 2 Or $sy == 7 Or $sy == 12))
        $num_MRs++;
      if ($x == 3 And ($sx == 7 Or $sx == 10 Or $sx == 11) And $y == 6 And ($sy == 2 Or $sy == 7 Or $sy == 12))
        $num_MRs++;

      if ($x == 4 And ($sx == 3 Or $sx == 11) And $y == 7 And ($sy == 1 Or $sy == 8 Or $sy == 10))
        $num_MRs++;
      if ($x == 4 And ($sx == 9 Or $sx == 12) And $y == 8 And ($sy == 1 Or $sy == 8 Or $sy == 10))
        $num_MRs++;
      if ($x == 4 And ($sx == 5 Or $sx == 8) And $y == 9 And ($sy == 1 Or $sy == 8 Or $sy == 10))
        $num_MRs++;
      if ($x == 4 And ($sx == 4 Or $sx == 9 Or $sx == 12) And $y == 5 And ($sy == 1 Or $sy == 8 Or $sy == 10))
        $num_MRs++;
      if ($x == 4 And ($sx == 7 Or $sx == 10 Or $sx == 11) And $y == 6 And ($sy == 1 Or $sy == 8 Or $sy == 10))
        $num_MRs++;

      if ($x == 5 And ($sx == 3 Or $sx == 11) And $y == 7 And ($sy == 4 Or $sy == 9 Or $sy == 12))
        $num_MRs++;
      if ($x == 5 And ($sx == 9 Or $sx == 12) And $y == 8 And ($sy == 4 Or $sy == 9 Or $sy == 12))
        $num_MRs++;
      if ($x == 5 And ($sx == 5 Or $sx == 8) And $y == 9 And ($sy == 4 Or $sy == 9 Or $sy == 12))
        $num_MRs++;
      if ($x == 5 And ($sx == 7 Or $sx == 10 Or $sx == 11) And $y == 6 And ($sy == 4 Or $sy == 9 Or $sy == 12))
        $num_MRs++;

      if ($x == 6 And ($sx == 3 Or $sx == 11) And $y == 7 And ($sy == 7 Or $sy == 10 Or $sy == 11))
        $num_MRs++;
      if ($x == 6 And ($sx == 9 Or $sx == 12) And $y == 8 And ($sy == 7 Or $sy == 10 Or $sy == 11))
        $num_MRs++;
      if ($x == 6 And ($sx == 5 Or $sx == 8) And $y == 9 And ($sy == 7 Or $sy == 10 Or $sy == 11))
        $num_MRs++;

      if ($x == 7 And ($sx == 9 Or $sx == 12) And $y == 8 And ($sy == 3 Or $sy == 11))
        $num_MRs++;
      if ($x == 7 And ($sx == 5 Or $sx == 8) And $y == 9 And ($sy == 3 Or $sy == 11))
        $num_MRs++;

      if ($x == 8 And ($sx == 5 Or $sx == 8) And $y == 9 And ($sy == 9 Or $sy == 12))
        $num_MRs++;
    }
  }

  return $num_MRs;
}
Function Get_NatalData($pl_name, $longitude, $declination, $house_pos, $hr_ob, $min_ob)
{
  $unknown_time = 0;
  if (($hr_ob == 12) And ($min_ob == 0))
  {
    $unknown_time = 1;		// this person has an unknown birth time
  }

  $planets=new stdClass();

  for ($i = 0; $i <= 9; $i++)
  {
     $planets->index[$i]= [$i];
     $planets->name[$i]= $pl_name[$i];
     $planets->long[$i]=$this->Convert_Longitude($longitude[$i]);
     $planets->decl[$i]=$this->Convert_Declination($longitude[$i]);
    
   
    if ($unknown_time == 1)
    {
      $planets->hse[$i]=0;
    }
   
    $planets->hse[$i] = floor($house_pos[$i]);
   
    }

    $aspects=new stdClass();

    if ($unknown_time == 0)
    {
    $house=array();

    for ($i = 10; $i <= 21; $i++)
    {
     
      if ($i == 10)
      {
       $aspects-> ascendant =  $this->Convert_Longitude($longitude[$i]) ;
      }
      elseif ($i == 19)
      {
        $aspects-> midheaven =  $this->Convert_Longitude($longitude[$i]) ;
      }
      else
      {
        $aspects-> house[$i]= $this->Convert_Longitude($longitude[$i]) ;

      }  
      

    }
    //store the reuslts in one object 
    $natal_aspects=new stdClass();

    $natal_aspects->planets_r=$planets;
    $natal_aspects->aspects_r=$aspects;


    return $natal_aspects;
  }
 
}
Function Convert_Longitude($longitude)
{
  $signs = array (0 => 'Ari', 'Tau', 'Gem', 'Can', 'Leo', 'Vir', 'Lib', 'Sco', 'Sag', 'Cap', 'Aqu', 'Pis');

  $sign_num = floor($longitude / 30);
  $pos_in_sign = $longitude - ($sign_num * 30);
  $deg = floor($pos_in_sign);
  $full_min = ($pos_in_sign - $deg) * 60;
  $min = floor($full_min);
  $full_sec = round(($full_min - $min) * 60);

  if ($deg < 10)
  {
    $deg = "0" . $deg;
  }

  if ($min < 10)
  {
    $min = "0" . $min;
  }

  if ($full_sec < 10)
  {
    $full_sec = "0" . $full_sec;
  }

  return $deg . " " . $signs[$sign_num] . " " . $min . "' " . $full_sec . chr(34);
}
Function Convert_Declination($declination)
{
  $deg = floor(abs($declination));
  $min = round((abs($declination) - $deg) * 60);

  if ($deg < 10)
  {
    $deg = "0" . $deg;
  }

  if ($min < 10)
  {
    $min = "0" . $min;
  }

  if ($declination < 0)
  {
    return $deg . " S " . $min;
  }
  else
  {
    return $deg . " N " . $min;
  }
}
Function DisplayResults($dynes, $num_MRs)
{
  $total_harmony = $dynes[1] + ($num_MRs * 5); //Score result from the calculations

  echo "<br />";
  echo "<font color='#ff0000' size='5' face='Arial'><b>RESULTS</b></font><br /><br />";

  echo '<table width="75%" cellpadding="0" cellspacing="0" border="0">';
    echo "<tr><td colspan='4'><hr></td></tr>";

    echo "<tr>";
      echo "<td>";
        ?>
          <div class="clock" >
            <!-- <img src="meter.png" class="clock_img" /> -->
            <div id="speedometer"></div>
          </div>

          <input type="hidden" id="update" value="start" />
          <input type="hidden" id="maxvalue" value="100" />
          <input type="hidden" id="rescale" value="rescale" />
          <input type="hidden" name="mode" id="incremental" checked="checked" />
          <input type="hidden" name="mode" id="random" />
          <input type="hidden" name="matchedScore" id="matchedScore" value="<?php echo $total_harmony; ?>" />
        <?php
      echo "</td>";

      echo "<td>";
        echo "<table align='center'>";
          echo "<tr>";
  echo "<td><font color='#0000ff'><b> Power </b></font></td>";
  echo "<td><font color='#0000ff'><b> Harmony </b></font></td>";
  echo "<td><font color='#0000ff'><b> Mutual<br>Receptions </b></font></td>";
          echo "</tr>";

          echo "<tr>";
  echo "<td>" . sprintf("%.2f", $dynes[0]) . "</td>";

            if ($total_harmony >= 9.8)
  {
              echo "<td><font size='+1' color='#009000'>" . sprintf("%.2f", ($total_harmony)) . "</font></td>";
  }
            elseif ($total_harmony < 0)
  {
              echo "<td><font size='+1' color='#ff0000'>" . sprintf("%.2f", ($total_harmony)) . "</font></td>";
  }
  else
  {
              echo "<td><font size='+1' color='#000000'>" . sprintf("%.2f", ($total_harmony)) . "</font></td>";
  }

  echo "<td>" . $num_MRs . "</td>";
          echo "<tr>";

          echo "<tr>";
            echo "<td colspan='3'>";
              echo "<br />";
  echo "An average HARMONY score is about +10. Negative scores (red) show discord between two people.";
              echo "<br /><br />";

              echo "Each mutual reception adds +5 harmony points, which is included in the harmony total.<br /><br />";
  echo "Learn more about cosmodynes <a href='http://www.astrowin.org/cosmodynes.php'>here</a>.";
            echo "</td>";
          echo "<tr>";
        echo "</table>";
      echo "</td>";
    echo '</tr>';

    echo "<tr><td colspan='4'><hr></td></tr>";
  echo '</table>';

  echo "<br /><br />";
}
Function CalculatePositions($last_id, $swephsrc="",$sweph="")

  {

    $longitude=[]; $declination=[]; $house_pos=[];

    $conn=$this->dtb->makeconnection();
    if( ($swephsrc=="")||($sweph=="")){
    $swephsrc = '/sweph';    //sweph MUST be in a folder no less than at this level
    // $sweph = 'cos/sweph';
    // $swephsrc = '/sweph';    //sweph MUST be in a folder no less than at this level
    // $sweph = '/sweph';
    }
    // Unset any variables not initialized elsewhere in the program
    unset($PATH,$out,$pl_name);
  // $PATH="C:/xampp/htdocs/q10/cos";
   $PATH= getcwd();
    //fetch all data for this record
    $sql = "SELECT * FROM birth_info WHERE ID='$last_id'";
    $result = @mysqli_query($conn, $sql) or error_log(mysqli_error($conn), 0);
    $row = mysqli_fetch_array($result);
    $num_rows = MYSQLI_NUM_rows($result);

    //assign data from database to local variables
    $inmonth = $row['month'];
    $inday = $row['day'];
    $inyear = $row['year'];

    $inhours = $row['hour'];
    $inmins = $row['minute'];
    $insecs = "0";

    $intz = $row['timezone'];

    $my_longitude = $row['ew'] * ($row['long_deg'] + ($row['long_min'] / 60));
    $my_latitude = $row['ns'] * ($row['lat_deg'] + ($row['lat_min'] / 60));


        $abs_tz = abs($intz);
        $the_hours = floor($abs_tz);
        $fraction_of_hour = $abs_tz - floor($abs_tz);
        $the_minutes = 60 * $fraction_of_hour;
        $whole_minutes = floor(60 * $fraction_of_hour);
        $fraction_of_minute = $the_minutes -$whole_minutes;
        $whole_seconds = round(60 * $fraction_of_minute);

        if ($intz >= 0)
        {
          $inhours = $inhours - $the_hours;
          $inmins = $inmins - $whole_minutes;
          $insecs =  $insecs - $whole_seconds;
        }
        else
        {
          $inhours = $inhours + $the_hours;
          $inmins = $inmins + $whole_minutes;
          $insecs =  $insecs + $whole_seconds;
        }
      //end of modified code

      $utdatenow = strftime("%d.%m.%Y", mktime($inhours, $inmins, $insecs, $inmonth, $inday, $inyear));
      $utnow = strftime("%H:%M:%S", mktime($inhours, $inmins, $insecs, $inmonth, $inday, $inyear));

      $put=putenv("PATH=$PATH:$swephsrc");
      $sweph="/sweph";
      $sweph="$PATH/sweph";
      // get 10 planets and all house cusps
    $sw=exec("$sweph/swetest -edir$sweph -b$utdatenow -ut$utnow -p0123456789 -eswe -house$my_longitude,$my_latitude, -fPldj -g, -head 2>&1", $out);
     
    //https://www.php.net/manual/en/function.exec.php
   // $struenode=exec ("swetest -edir$sweph -b$utdatenow -ut$utnow -pt -eswe -house$my_longitude,$my_latitude, -fPldj -g, -head", $outrue);    
      // $truenode= ;

      

      // Each line of output data from swetest is exploded into array $row, giving these elements:
      // 0 = planet name
      // 1 = longitude
      // 2 = declination
      // 3 = house position
      // planets are index 0 - index 9, house cusps are index 10 - 21
      foreach ($out as $key => $line)
      {
        $row = explode(',',$line);
        $pl_name[$key] = $row[0];
        $longitude[$key] = $row[1];
        $declination[$key] = $row[2];
        $house_pos[$key] = $row[3];
      };

      

      //I want this routine to change the data in the house position array, hence my use of "&$house_pos"
      for ($x = 1; $x <= 12; $x++)
      {
        for ($y = 0; $y <= 9; $y++)

        {
          $pl = $longitude[$y] + (1 / 36000);
          if ($x < 12 And $longitude[$x + 9] > $longitude[$x + 10])
          {
            If (($pl >= $longitude[$x + 9] And $pl < 360) Or ($pl < $longitude[$x + 10] And $pl >= 0))
            {
              $house_pos[$y] = $x;
              continue;
            }
          }

          if ($x == 12 And ($longitude[$x + 9] > $longitude[10]))
          {
            if (($pl >= $longitude[$x + 9] And $pl < 360) Or ($pl < $longitude[10] And $pl >= 0))
            {
              $house_pos[$y] = $x;
            }
            continue;
          }

          if (($pl >= $longitude[$x + 9]) And ($pl < $longitude[$x + 10]) And ($x < 12))
          {
            $house_pos[$y] = $x;
            continue;
          }

          if (($pl >= $longitude[$x + 9]) And ($pl < $longitude[10]) And ($x == 12))
          {
            $house_pos[$y] = $x;
          }
        }
      }

      // foreach ($outrue as $key => $line)
      // {
      //   $row = explode(',',$line);
      //   $pl_name[$key] = $row[0];
      //   $longitude[$key] = $row[1];
      //   $declination[$key] = $row[2];
      //   $house_pos[$key] = $row[3];
      // };



      $this->declination=$declination;
      $this->longitude=$longitude;
      $this->house_pos=$house_pos;

      return $this;
    }









}