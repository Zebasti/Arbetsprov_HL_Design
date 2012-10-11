<?php
/*
 * Player objektet Objektet
 * Innehåller functionerna. 
 * get_score()
 * get_total_score()
 * get_name()
 * do_score()
 * do_final_score()
 * */

class Player {
	
	private $name = "";			// Namn
	private $score = array();	// Poäng array
	private $total_score = 0;	// Total Poängen
	
	/*
	 * get_score 
	 * Returnerar spelarens poäng
	 * */
	public function get_score(){
		return $this->score;
	}
	
	/*
	 * get_total_score 
	 * Returnerar spelarens total poäng
	 * */
	
	public function get_total_score(){
		return $this->total_score;
	}
	/*
	 * get_name 
	 * Returnerar spelarens namn
	 * */
	public function get_name(){
		return $this->name;
	}
	/* 
	 * Skapar spelaren och dess poäng
	 * */
	function __construct($name){
		$this->name = $name;
		$this->do_score();
	}
	
	
	/*
	 * do_score 
	 * Skapar spelarens poäng 
	 * och ger det till objektets 
	 * score variable.
	 * */
	
	private function do_score(){
		for($i = 1; $i <= 10; $i++){
			unset($pins);		
			$pins[] = rand(0, 10);
			if($pins[0] != 10){
				$pins[] = rand(0, 10-$pins[0]);
			} else if($pins[0] == 0){
				$pins[] = rand(0, 10);
				if(($pins[0] + $pins[1]) == 10){ $pins[1] = 10; }
			} else {
				$pins[0] = 10;
				$pins[1] = 0;
			}
			
			if($i == 10 && $pins[0] == 10){
				$pins[1] = rand(0, 10);
				if($pins[1] == 10){
					$pins[2] = rand(0, 10);
				} else {
					$pins[2] = 0;
				}
			} else if($i == 10 && ($pins[0] + $pins[1]) == 10){
				$pins[2] = rand(0, 10);
			} else if($i == 10){
				$pins[2] = 0;
			}
			$this->score[] = $pins;
			// if ($i != 10)
			// $this->score[] = array(10, 0);
			// else $this->score[] = array(10, 10, 10);
			
		}
		$this->do_final_score();
		$this->total_score;
	}
	
	/*
	 * do_final_score 
	 * saknar spärr, stryke och miss tecken
	 * 
	 * Räknar ihop poängen och ger värdet till 
	 * total_score variabln i objektet. 
	 * 
	 * 
	 * */
	
	private function do_final_score() {
		$score = $this->score;
		for($i = 0; $i < 10; $i++){
			if($score[$i][0] == 10){
				if($i < 7){
					$this->score[$i]['total'] = $score[$i][0] + ($score[$i+1][0] + $score[$i+1][1]) + ($score[$i+2][0] + $score[$i+2][1]); // Uträckning om man får en strike
					$this->score[$i][0] = "X";
					$this->score[$i][1] = " ";
				}else if($i == 7){
					$this->score[$i]['total'] = $score[$i][0] + ($score[$i+1][0] + $score[$i+1][1]) + $score[$i+2][0]; // Uträckning om man får en strike
					$this->score[$i][0] = "X";
					$this->score[$i][1] = " ";
				} else if($i == 8){
					$this->score[$i]['total'] = $score[$i][0] + ($score[$i+1][0] + $score[$i+1][1]); // den nionde rutans uträkning för strike
					$this->score[$i][0] = "X";
					$this->score[$i][1] = " ";
				} else {
					$this->score[$i]['total'] = $score[$i][0]+ ($score[$i][1] + $score[$i][2]); //Den tionde rutans uträknnig
					
					$this->score[$i][1] = ($this->score[$i][0] == "0" ? "-" : // Ändrar andra rutan till sträck om den är noll
											  ($this->score[$i][1] == 10 ? "X" : // ändra den till strike om den är 10 
											  	( ($this->score[$i][0] + $this->score[$i][1]) == 10 ? "/" : $this->score[$i][1]) // ändra den till spärr om både första och andra blir 10
											  )
										  );
					$this->score[$i][2] = ($this->score[$i][2] == 10 ? "X" : ($this->score[$i][2] == "0" ? " " : $this->score[$i][2])); 
					$this->score[$i][0] = "X"; 
				}
			} else if(($score[$i][0] + $score[$i][1]) == 10 && $score[$i][0] != 10){
				$this->score[$i]['total'] = ($score[$i][0] + $score[$i][1]) + ($score[$i+1][0]); // Uträkning om man får en spärr
				$this->score[$i][1] = "/";
				($i == 9 ? $this->score[$i][2] = ($this->score[$i][2] == "0" ? " " : $this->score[$i][2]): ""); 
			} else {
				$this->score[$i]['total'] = $score[$i][0] + $score[$i][1];   // Uträkning om man får bara poäng
				$this->score[$i][0] = ($this->score[$i][0] == "0" ? "-" : $this->score[$i][0]);
				$this->score[$i][1] = ($this->score[$i][1] == "0" ? "-" : $this->score[$i][1]);
				($i == 9 ? $this->score[$i][2] = ($this->score[$i][2] == 0 ? " " : $this->score[$i][2]): "");
			}
			$this->total_score += $this->score[$i]['total']; // Lägger till värdet till total beloppet.
		}
	}
}

?> 