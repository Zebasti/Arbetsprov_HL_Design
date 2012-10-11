<?php
/*
 * Player objektet Objektet
 * Inneh�ller functionerna. 
 * get_score()
 * get_total_score()
 * get_name()
 * do_score()
 * do_final_score()
 * */

class Player {
	
	private $name = "";			// Namn
	private $score = array();	// Po�ng array
	private $total_score = 0;	// Total Po�ngen
	
	/*
	 * get_score 
	 * Returnerar spelarens po�ng
	 * */
	public function get_score(){
		return $this->score;
	}
	
	/*
	 * get_total_score 
	 * Returnerar spelarens total po�ng
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
	 * Skapar spelaren och dess po�ng
	 * */
	function __construct($name){
		$this->name = $name;
		$this->do_score();
	}
	
	
	/*
	 * do_score 
	 * Skapar spelarens po�ng 
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
	 * saknar sp�rr, stryke och miss tecken
	 * 
	 * R�knar ihop po�ngen och ger v�rdet till 
	 * total_score variabln i objektet. 
	 * 
	 * 
	 * */
	
	private function do_final_score() {
		$score = $this->score;
		for($i = 0; $i < 10; $i++){
			if($score[$i][0] == 10){
				if($i < 7){
					$this->score[$i]['total'] = $score[$i][0] + ($score[$i+1][0] + $score[$i+1][1]) + ($score[$i+2][0] + $score[$i+2][1]); // Utr�ckning om man f�r en strike
					$this->score[$i][0] = "X";
					$this->score[$i][1] = " ";
				}else if($i == 7){
					$this->score[$i]['total'] = $score[$i][0] + ($score[$i+1][0] + $score[$i+1][1]) + $score[$i+2][0]; // Utr�ckning om man f�r en strike
					$this->score[$i][0] = "X";
					$this->score[$i][1] = " ";
				} else if($i == 8){
					$this->score[$i]['total'] = $score[$i][0] + ($score[$i+1][0] + $score[$i+1][1]); // den nionde rutans utr�kning f�r strike
					$this->score[$i][0] = "X";
					$this->score[$i][1] = " ";
				} else {
					$this->score[$i]['total'] = $score[$i][0]+ ($score[$i][1] + $score[$i][2]); //Den tionde rutans utr�knnig
					
					$this->score[$i][1] = ($this->score[$i][0] == "0" ? "-" : // �ndrar andra rutan till str�ck om den �r noll
											  ($this->score[$i][1] == 10 ? "X" : // �ndra den till strike om den �r 10 
											  	( ($this->score[$i][0] + $this->score[$i][1]) == 10 ? "/" : $this->score[$i][1]) // �ndra den till sp�rr om b�de f�rsta och andra blir 10
											  )
										  );
					$this->score[$i][2] = ($this->score[$i][2] == 10 ? "X" : ($this->score[$i][2] == "0" ? " " : $this->score[$i][2])); 
					$this->score[$i][0] = "X"; 
				}
			} else if(($score[$i][0] + $score[$i][1]) == 10 && $score[$i][0] != 10){
				$this->score[$i]['total'] = ($score[$i][0] + $score[$i][1]) + ($score[$i+1][0]); // Utr�kning om man f�r en sp�rr
				$this->score[$i][1] = "/";
				($i == 9 ? $this->score[$i][2] = ($this->score[$i][2] == "0" ? " " : $this->score[$i][2]): ""); 
			} else {
				$this->score[$i]['total'] = $score[$i][0] + $score[$i][1];   // Utr�kning om man f�r bara po�ng
				$this->score[$i][0] = ($this->score[$i][0] == "0" ? "-" : $this->score[$i][0]);
				$this->score[$i][1] = ($this->score[$i][1] == "0" ? "-" : $this->score[$i][1]);
				($i == 9 ? $this->score[$i][2] = ($this->score[$i][2] == 0 ? " " : $this->score[$i][2]): "");
			}
			$this->total_score += $this->score[$i]['total']; // L�gger till v�rdet till total beloppet.
		}
	}
}

?> 