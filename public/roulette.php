<?php 
class Player{

}

class Dealer{ 
	public function getChips($amount, $scale = 1){
		if($amount % $scale)
			return FALSE;
	}
} 

class Table{
	private $black = array(2,4,6,8,10,11,13,15,17,20,22,24,26,28,29,31,33,35);
	private $red = array(1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36);
	private $column_1 = array(1,4,7,10,13,16,19,22,25,28,31,34);
	private $column_2 = array(2,5,8,11,14,17,20,23,26,29,32,35);
	private $column_3 = array(3,6,9,12,15,18,21,24,27,30,33,36);

	public function isBlack($n){
		return in_array($n, $this->black);
	}

	public function isRed($){
		return in_array($n, $this->red);	
	}

	public function isFirstThird($n){
		return $n >= 1 && $n <=12;
	}

	public function isSecondThird($n){
		return $n >= 13 && $n <=24;
	}

	public function isThirdThird($n){
		return $n >= 25 && $n <=36;
	}
} 

final class Wheel{
	private static $wheel = array(
		0,2,14,35,23,4,16,33,21,6,18,31,
		19,8,12,29,25,10,27,'00',1,13,36,24,
		3,15,34,22,5,17,32,20,7,11,30,26,9,28);

	public static function spin(){
		return $this->wheel[array_rand($this->wheel)];
	}
} 

$wheel = new Wheel(); 
for($x=0; $x<1; $x++){
	var_dump($wheel->spin());	
} var_dump('00' == 0); ?>