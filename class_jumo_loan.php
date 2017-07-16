<?php

class output_results {
	
		// -----------------------------------------------
        // Group by Network only
        public function group_network($myarray) {
            $arr2 = array();
            // $arr1 = $loan_array;
            $arr1 = $myarray;
            foreach ($arr1 as $a) {

            unset($a['MSISDN']);
            unset($a['Date']);
            unset($a['Product']);
            $key = $a['Network'];

			isset($key['Count']);
			
            if (isset($arr2[$key])) {
                $arr2[$key]['Amount'] += $a['Amount'];
				$arr2[$key]['Count']++;
            } else {
                $arr2[$key] = $a;
				$arr2[$key]['Count']++;
            }

            }
          //  print_r(array_values($arr2));
		  $this->output_network = $arr2;
        }
		
		// -----------------------------------------------
		// Group by Product only
        public function group_product($myarray) {
            $arr2 = array();
            $arr1 = $myarray;
            foreach ($arr1 as $a) {

            unset($a['MSISDN']);
            unset($a['Date']);
            unset($a['Network']);
            $key = $a['Product'];

			isset($key['Count']);
			
            if (isset($arr2[$key])) {
                $arr2[$key]['Amount'] += $a['Amount'];
				$arr2[$key]['Count']++;
            } else {
                $arr2[$key] = $a;
				$arr2[$key]['Count']++;
            }

            }
		  $this->output_product = $arr2;
        }
		
		// -----------------------------------------------
		// Group by Date only
        public function group_date($myarray) {
            $arr2 = array();
            $arr1 = $myarray;
            foreach ($arr1 as $a) {

            unset($a['MSISDN']);
            unset($a['Product']);
            unset($a['Network']);			
			isset($key['Count']);
			
			// Remove the single quote from the string			
			$a['Date'] = str_replace("'"," ",$a['Date']);
			
			// Convert to month
			$a['Date'] = date("M",strtotime($a['Date']));
			// $a['Date'] = date('Y-m-d',$a['Date']);
			
			$key = $a['Date'];
			
            if (isset($arr2[$key])) {
                $arr2[$key]['Amount'] += $a['Amount'];
				$arr2[$key]['Count']++;
            } else {
                $arr2[$key] = $a;
				$arr2[$key]['Count']++;
            }

            }
		  $this->output_date = $arr2;
        }	
		
		// -----------------------------------------------
		// Group by Network, Product and Date
        public function group_all($myarray) {
            $arr2 = array();
            $arr1 = $myarray;
            foreach ($arr1 as $a) {

            unset($a['MSISDN']);
			
			// Remove the single quote from the string & convert to month			
			$a['Date'] = str_replace("'"," ",$a['Date']);
			$a['Date'] = date("M",strtotime($a['Date']));

            $key = $a['Network'] . $a['Product'] . $a['Date'];

			isset($key['Count']);
			
            if (isset($arr2[$key])) {
                $arr2[$key]['Amount'] += $a['Amount'];
				$arr2[$key]['Count']++;				
            } else {
                $arr2[$key] = $a;
				$arr2[$key]['Count']++;
            }

            }
		  $this->output_all = $arr2;
        }				

		// -----------------------------------------------
		// Summarise cost totals for dashboard
        public function summarise_totals($myarray) {
            $arr1 = $myarray;
			$total_cost = 0.00;
            foreach ($arr1 as $a) {
    	      //  array_sum($a['Amount']);
			  $total_cost += $a['Amount'];
            }
		  $this->output_sumtotal = $total_cost;
        }	
					
		// -----------------------------------------------
		// MSISDN info dashboard
        public function msisdn_info($myarray) {
            $arr2 = array();
            $arr1 = $myarray;
            foreach ($arr1 as $a) {

            unset($a['Product']);
            unset($a['Date']);
            unset($a['Network']);
            $key = $a['MSISDN'];

			isset($key['Count']);
			
            if (isset($arr2[$key])) {
                $arr2[$key]['Amount'] += $a['Amount'];
				$arr2[$key]['Count']++;
            } else {
                $arr2[$key] = $a;
				$arr2[$key]['Count']++;
            }

            }
		  $this->output_msisdn = $arr2;
        }				


}


		/*
        // Pull the info fro the CSV and map the rows
        $loan_array = array_map('str_getcsv', file('Loans.csv'));
        
        // convert from simple array to associative array with headings as keys
        $header = array_shift($loan_array);
        array_walk($loan_array, '_combine_array', $header);
        
        // Callback function 
        function _combine_array(&$row, $key, $header) {
            $row = array_combine($header, $row);
        }

        // Execute the class with it's methods
		
        $loan = new output_results();
        $loan->group_network($loan_array);
		*/
?>