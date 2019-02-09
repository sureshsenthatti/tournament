<?php
$players_list = array(
  "Adam" => "P",
  "Andrew" => "S",
  "Chris" => "R",
  "Casey" => "P", 
  "Cadman" => "R"
);
session_start();
//unset($_SESSION['lastplayer']);
if(sizeof($players_list) === 1) {
  echo 'Tournament Cancelled';
}
else {
  $array_chunk = array_chunk($players_list, 2, true);
  echo firstround($array_chunk, $players_list);
}

function firstround($array_chunk, $players_list) {
  $players = array();
  foreach($array_chunk as $key => $players) {
    if(count($players) > 1) {
      $playerinfo = array_values($players);
      $player1 = $playerinfo[0];
      $player2 = $playerinfo[1];

      //Round One
      if( ($player1 == 'P' && $player2 == 'S') || ($player1 == 'R' && $player2 == 'P')) {
        $secondround = secondround($player2, $players_list);
        if(isset($secondround)) {
          if(isset($_SESSION['lastplayer'])) {
            $lastplayer = $_SESSION['lastplayer'];
            return recusiveround($secondround, $lastplayer, $players_list);
          }
          else {
            //$playerslist = array_flip($players_list);
            //return $playerslist[$secondround];
            return $secondround;
          }
        }
      }
    }
    if (count($players) === 1) {
      $last_player = array_values($players);
      $_SESSION['lastplayer'] = $last_player[0];
    }
  }
}
function secondround($player2, $players_list) {
  //echo $player2;

  $playerslist = array_flip($players_list);
  foreach($playerslist as $key => $a) {
    if($player2 == 'S' && $key == 'S') {
      return $key;
    }
    /*else {
      $lp = @$_SESSION['lastplayer'];
      if($lp == 'R' && $player2 == 'S') {
        return $playerslist[$lp];
      }
      else {
        return $playerslist[$player2];
      }      
    }*/
  }
  
}
function recusiveround($player1, $player2, $players_list) {
  if( ($player1 == 'P' && $player2 == 'S') || ($player1 == 'R' && $player2 == 'P') || ($player1 == 'S' && $player2 == 'R') ) {
    $playerslist = array_flip($players_list);
    //unset($_SESSION);
    return $playerslist[$player2];
  }
}
?>
