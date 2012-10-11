<?php

include_once("./language_sv.php"); // använder en simpel språkfil. 
include_once("./player_class.php"); // Min player class. ¨

if(!empty($_POST['players'])){
	$players = explode(",", $_POST['players']); 		// Delar upp spelarna i en array som sedan ger 
	foreach ($players as $id => $name){					// namn åt mina player objekt 
		$player[] = new Player($name); 					// Skapar en array av player objekt 
	}
	
	foreach ($player as $p_id => $value){
		unset($temp);
		if($p_id == 0){									// Om det är första spelaren så läggs den till listan direkt
			$board[] = $value;
		}else{											// Annars så går vi igenom listan

			$player_hi = $value->get_total_score();		// Spelaren som vi ska lägga tills hiscore
			
			foreach($board as $b_id => $player_id){
				
				$board_p_hi = $player_id->get_total_score();		// Den vi kollar på i listans hiscore 
				
				if($player_hi > $board_p_hi){ 						// kollar om den nya spelaren har bättre poäng än den som är först i listan.
					$temp[] = $value;								// Lägger till spelaren först. 
					foreach ($board as $bo_id => $player_id2){		// Lägger till de andra spelarna efter
						$temp[] = $player_id2;
					} 
					$board = $temp;									// Skapar listan igen
					break;
				} else {
					if (empty($board[$b_id+1])){ 					// Kollar om det finns en spelare till i listan
							$board[] = $value;
						break;
					} else {																// Om det fanns en spelare efter  
						$next_on_list = $board[$b_id+1];
						$next_hi = $next_on_list->get_total_score();	
													
						if($player_hi > $next_hi) {											// Ska kolla om den som ligger tvåa i listan är sämmre än den som ska läggas till.
							$temp = array_slice($board, 0, $b_id+1);						// Lägger till spelarna före
							$temp[] = $value;												// Lägger till spelaren
							foreach (array_slice($board, $b_id+1) as $bo_id => $player_id2){// Lägger till alla spelare efter
								$temp[] = $player_id2;		
							}
							$board = $temp;
							break;
						}
					}
				}
			}
		}
	}
	

	$score_board = '<div class="container-fluid ">'; // öppnar containern 
		$score_board .= '<div class="row-fluid">';		// öppnar row-fluid header
			$score_board .= '<div class="span1 border"><h5>'.$player_name.'</h5></div>';
			for($i = 1; $i <= 10; $i++){
				if($i != 10){
					$score_board .= '<div class="span1 border" style="text-align:center;"><h5>'.$i.'</h5></div>';
				} else {
					$score_board .= '<div class="span2 border" style="text-align:center;"><h5>'.$i.'</h5></div>';
				}
			}
		$score_board .= '</div>';						// Stänger row fluid header

			foreach($board as $id => $player){
				$score_board .= '<div class="row-fluid">';		// öppnar row-fluid spelaren
				$score_board .= '<div class="span1 border" style="text-align:center;"><h5>'.$player->get_name().'</h5></div>';
				foreach ($player->get_score() as $key => $value){
						if($key != 9){
						$score_board .= '<div class="span1" style="text-align:center;">';
						$score_board .= '<div class="row-fluid ">';
							$score_board .= '<div class="span6 border">'.$value['0'].'</div>';
							$score_board .= '<div class="span6 border">'.$value['1'].'</div>';
							$score_board .= '</div>';
							$score_board .= '<div class="row-fluid">';
								$score_board .= '<div class="span12 border">'.$value['total'].'</div>';
							$score_board .= '</div>';
							
						}else{
						$score_board .= '<div class="span2" style="text-align:center;">';
						$score_board .= '<div class="row-fluid ">';
							$score_board .= '<div class="span4 border">'.$value['0'].'</div>';
							$score_board .= '<div class="span4 border">'.$value['1'].'</div>';
							$score_board .= '<div class="span4 border">'.$value['2'].'</div>';
							$score_board .= '</div>';
							$score_board .= '<div class="row-fluid">';
								$score_board .= '<div class="span12 border"><b>'.$total_points.'</b> '.$player->get_total_score().'</div>';
							$score_board .= '</div>';
						}
					$score_board .= '</div>';
				}
				$score_board .= '</div>';						// Stänger row fluid spelaren
			}
	$score_board .= '</div>';						// Stänger containern
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>HL Design, Bowling och Disco</title>
		<meta name="keywords" content="HL Design, Bowling och Disco">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	</head>
	<body>
	
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#"><?php print $project_name; ?></a>
        </div>
      </div>
    </div>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="hero-unit">
					<h3><?php print $name_players; ?></h3>
					<form method="post" action="index.php">
						<input type="hidden" name="players" id="players">
						<input type="text" id="player_name">
						<br />
						<input type="button" value="<?php print $add_player;?>" onclick="add_player()">
						<input type="submit" id="start" name="start" value="<?php print $start_game;?>" style="visibility:hidden" onclick="start_game()">
					</form>
					<p id="players_in_game">
				</div>
			</div>
			<div class="span9">
				<div class="hero-unit">
					<?php
						if(empty($_POST['players'])){
							print $info_box; // Infon i boxen. 
						} else {
							print $score_board;
						}
					?>
				</div>
			</div>
		</div>
	</div>
	
<script type="text/javascript"> 
var player = new Array();
var id = 0;
var player_list = "<?php print $player_list_text;?>";


function add_player(){
	
	if(document.getElementById("player_name").value != ""){
		player[id] = document.getElementById("player_name").value;
		player_list += document.getElementById("player_name").value + " <br />";
		document.getElementById("player_name").value = "";
		id++;
		document.getElementById("players_in_game").innerHTML = player_list;
		
		document.getElementById("start").style.visibility = "visible";
	}
}

function start_game(){
	add_player();
	var element = document.getElementById("players");
	element.value = player;
    element.form.submit();
}

</script>
</html>

