<?php
class Blackjack {
	private $card1 = null;
	private $card2 = null;
	private $faceValueMap = array(
		'a' => 11,
		'k' => 10,
		'q' => 10,
		'j' => 10
	);
	
	private function validateAndAssignInput($argv){
		if(!isset($argv[1]) || !isset($argv[2])){
			die('Usage: php Blackjack.php [card1] [card2]');
		}
		$cardReg = '/^([2-9]|10|A|K|Q|J)(S|C|D|H)$/i';
		if(!preg_match($cardReg, $argv[1])){
			die('Error: The first card is invalid. Card should be in the format of "[facevalue][suit]".'
					.' Facevalue must be 2 to 10 or A or K or Q or J. Suit value must be S or C or D or H. e.g. 2s');
		}
		if(!preg_match($cardReg, $argv[2])){
			die('Error: The second card is invalid. Card should be in the format of "[facevalue][suit]"'
					.' Facevalue must be 2 to 10 or A or K or Q or J. Suit value must be S or C or D or H. e.g. 2s');
		}
		$this->card1 = substr(strtolower($argv[1]), 0, -1); // keep the face value only
		$this->card2 = substr(strtolower($argv[2]), 0, -1); // keep the face value only
	}
	private function calculateBlackjackValue($card1, $card2){
		if(array_key_exists($card1, $this->faceValueMap)){
			$card1 = $this->faceValueMap[$card1];
		}
		if(array_key_exists($card2, $this->faceValueMap)){
			$card2 = $this->faceValueMap[$card2];
		}
		return (int)$card1 + (int)$card2;
	}
	public function getBlackjackValue($argv){
		$this->validateAndAssignInput($argv);
		return $this->calculateBlackjackValue($this->card1, $this->card2);
	} 
}
$blackjack = new Blackjack();
echo 'The blackjack value is ' . $blackjack->getBlackjackValue($argv);