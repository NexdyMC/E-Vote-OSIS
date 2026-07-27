<?php


function random($length = 12) {
  $array = [ "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n",
 "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z" ];
 
  $cuid = "";

  for ($i = 0 ; $i < $length ; $i++) {
      
      $biner_x = rand(0, 1);
      $biner_y = rand(0, 1);
      $indexHuruf = rand(0, 25);

      
      if ($biner_x == 1) {
          $cuid .= strtoupper($array[$indexHuruf]);
      } else {
          $cuid .= rand(0, 9); 
      }
  }
  
  return $cuid;

}
