<?php

/**
 * Class to use Benford's Law to predict if the numbers provided are possibly fraud or not   REF - https://en.wikipedia.org/wiki/Benford%27s_law
 * @Author Rochak Chauhan <rochakchauhan@gmail.com>
 *
 */
class PhpBenfordsLaw{
	private $financial_numbers = Array();
	private $results = Array();
	private $percentage_results = Array();
	private $base_numbers = Array(1,2,3,4,5,6,7,8,9);
	private $benford_results = Array("1"=>30.1, "2"=>17.6, "3"=>12.5, "4"=>9.7, "5"=>7.9, "6"=>6.7, "7"=>5.8, "8"=>5.1, "9"=>4.6); 
	
	function __construct($input_numbers){		
		foreach($input_numbers as $financial_number){
			$financial_number = (string) $financial_number;
			for($a=0; $a< strlen($financial_number); $a++){
				$num = trim($financial_number[$a]);
				if(in_array($num, $this->base_numbers) ){
					$this->financial_numbers[] = $num;
				}
			}			
 		}
		
		$this->results = array_count_values($this->financial_numbers);
		ksort($this->results);
		$this->calculate_percentage();
	}
	
	public function debug(){
		echo "<pre><hr /> financial_numbers: ";
		print_r($this->financial_numbers);
		
		echo "<hr /> our_results: ";
		print_r($this->results);
		
		echo "<hr /> percentage_results: ";
		print_r($this->percentage_results);
		
		echo "<hr /> benford_results: ";
		print_r($this->benford_results);
		
	}
	
	private function calculate_percentage(){
		$sum = array_sum($this->results);
		foreach($this->results as $k => $result) {			
			$percentage = ($result/$sum)*100;
			$this->percentage_results[$k] = intval($percentage);
		}		
	}
	
	private function low_accuracy_check(){
		$percentage_results = $this->percentage_results;
		ksort($percentage_results);
		
		$last_number =0;
		foreach($percentage_results as $percentage_result){
			if($last_number>0 && $percentage_result > $last_number){
				return false;
			}
			$last_number = $percentage_result;
		}		
		return true;
	}
		
	public function get_result($ACCURACY_LEVEL="H"){
		$result_message = "Possible Fraudulent Data";
		
		if( strtoupper(trim($ACCURACY_LEVEL)) == "H" ){
			$threshold = 1;
			$LEVEL = "High";
		}
		elseif( strtoupper(trim($ACCURACY_LEVEL)) == "M" ){
			$threshold = 2;
			$LEVEL = "Medium";
		}
		elseif( strtoupper(trim($ACCURACY_LEVEL)) == "L" ){
			$LEVEL = "Low";
			//Basic check for decreasing order
			$result = $this->low_accuracy_check();
			if($result){
				return ["CODE"=>200, "MESSAGE"=> "Unlikely Fraudulent Data with $LEVEL level of Assurance"];
			}
			else{
				return ["CODE"=>200, "MESSAGE"=> $result_message]; 
			}
		}
		else{
			//throw error
			return ["CODE"=>500, "MESSAGE"=> "INVALID ACCURACY_LEVEL"];
		}
		
		//Check 
		for($x=1; $x<=count($this->percentage_results); $x++){
			$result = $this->percentage_results[$x];
			$benford_result = $this->benford_results[$x];

			$diff = abs(floor($benford_result)) - abs(floor($result));
			$diff = abs(floor($diff));
			//echo "<hr /> ===>  $benford_result -  $result   =  $diff   || $threshold ";
			if($diff > $threshold){
				return ["CODE"=>200, "MESSAGE"=> $result_message]; 
			}			
		}		
		return ["CODE"=>200, "MESSAGE"=> "Unlikely Fraudulent Data with $LEVEL level of Assurance"];
		
	}
	
}
?>