<?php
echo("<pre>");
        $url = "https://api.infusionsoft.com/crm/rest/v1/account/profile?access_token=PIwRxnQAsBVddibWHsAOLCyPpnKS";
        try{
    	    $ch = curl_init();
    	    curl_setopt($ch,CURLOPT_URL, $url);
    	    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    	    $serverOutput = curl_exec($ch);
    	    curl_close($ch);
    	    
    	    print_r(json_decode($serverOutput));
        }catch(Exception $e){
          print_r($e->getMessage());
        }