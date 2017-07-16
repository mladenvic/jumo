<?php
error_reporting(0);
include('../class_jumo_loan.php');	
		
        // Pull the info fro the CSV and map the rows
        $loan_array = array_map('str_getcsv', file('../Loans.csv'));
        
        // convert from simple array to associative array with headings as keys
        $header = array_shift($loan_array);
        array_walk($loan_array, '_combine_array', $header);
        
        // Callback function 
        function _combine_array(&$row, $key, $header) {
            $row = array_combine($header, $row);
        }
		
		// instantiate the object based on the class
        $loan = new output_results();
		$loan->group_network($loan_array);
        
		
// OUTPUT JSON BELOW
$output = array();
// print_r($loan->output_network);
// $output = explode($loan->group_network($loan_array),"\n");
$output = array_values($loan->output_network);
// $json_output = json_encode($output);
// print_r($output);
// echo $output[0]['Network'];

for ($i=0;$i<count($output);$i++) {
 $data .= '["'.$output[$i]['Network'].'","'.$output[$i]['Count'].'","'.$output[$i]['Amount'].'"],';
}

echo $data_output = '{"data": [' . rtrim($data,',') . ']}';

?>