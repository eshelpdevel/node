<?php
	######################################
		$nodejs 		= "https://devcrm.wom.co.id:8766/blashwa";
		$fourdigit_code = '1014';
		$delaytime 		= 30;
		//pastikan direktori /var/www/html/Blastchecker eksis untuk menyimpan log
	######################################

	$timestart = date('Y-m-d H:i:s');
	function microtime_float(){
	    list($usec, $sec) = explode(" ", microtime());
	    return ((float)$usec + (float)$sec);
	}
	$vtemp = file_get_contents('php://input');
	$vtemp = json_decode($vtemp,true);
	$cleanTemp = $vtemp;


	$kirimdata['to'] 														= $vtemp['destination']['username'];
	$kirimdata['toname'] 													= $vtemp['destination']['usercontactname'];
	$kirimdata['type'] 														= 'template';
	$kirimdata['template']['namespace'] 									= $vtemp['ref']['template_namespace'];
	$kirimdata['template']['name'] 											= $vtemp['ref']['template_name'];
	$kirimdata['template']['language']['code'] 								= $vtemp['ref']['language_code'];
	$kirimdata['template']['language']['policy'] 							= 'deterministic';
	$pnom=0;
	if (isset($vtemp['body']['raw']['header'])) {
		$kirimdata['template']['components'][$pnom]['type'] 					= 'header';
		for ($i=0; $i <count($vtemp['body']['raw']['header']) ; $i++) { 

			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[cust]",  $vtemp['destination']['usercontactname'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[unit]",  $vtemp['destination']['unit'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[tahun_unit]",  $vtemp['destination']['tahun'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[cusid]",  $vtemp['destination']['cusid'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[cabang]",  $vtemp['destination']['cabang'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[orderno]",  $vtemp['destination']['orderno'], $vtemp['body']['raw']['header'][$i]['value']);

			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[label]",  $vtemp['destination']['label'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[produk]",  $vtemp['destination']['produk'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[nominaldenda]",  $vtemp['destination']['nominaldenda'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[dpd]",  $vtemp['destination']['dpd'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[nopolisi]",  $vtemp['destination']['nopolisi'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[jatuhtempo]",  $vtemp['destination']['jatuhtempo'], $vtemp['body']['raw']['header'][$i]['value']);
			$vtemp['body']['raw']['header'][$i]['value'] = str_replace("[angsuranke]",  $vtemp['destination']['angsuranke'], $vtemp['body']['raw']['header'][$i]['value']);

			if ($vtemp['body']['raw']['header'][$i]['type']  == 'text') {
				$kirimdata['template']['components'][$pnom]['parameters'][$i]['type'] 		= $vtemp['body']['raw']['header'][$i]['type'];
				$kirimdata['template']['components'][$pnom]['parameters'][$i]['text'] 		= $vtemp['body']['raw']['header'][$i]['value'];
			}elseif($vtemp['body']['raw']['header'][$i]['type']  == 'image'){
				$kirimdata['template']['components'][$pnom]['parameters'][$i]['type'] 		= $vtemp['body']['raw']['header'][$i]['type'];
				$kirimdata['template']['components'][$pnom]['parameters'][$i]['image']['link'] 		= $vtemp['body']['raw']['header'][$i]['value'];
			}else{
				$kirimdata['template']['components'][$pnom]['parameters'][$i]['type'] 		= $vtemp['body']['raw']['header'][$i]['type'];
				$kirimdata['template']['components'][$pnom]['parameters'][$i]['text'] 		= $vtemp['body']['raw']['header'][$i]['value'];
			}
		}
		$pnom++;
	}
	if (isset($vtemp['body']['raw']['body'])) {
		$kirimdata['template']['components'][$pnom]['type'] 					= 'body';
		for ($i=0; $i <count($vtemp['body']['raw']['body']) ; $i++) { 

			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[cust]",  $vtemp['destination']['usercontactname'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[unit]",  $vtemp['destination']['unit'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[tahun_unit]",  $vtemp['destination']['tahun'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[cusid]",  $vtemp['destination']['cusid'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[cabang]",  $vtemp['destination']['cabang'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[orderno]",  $vtemp['destination']['orderno'], $vtemp['body']['raw']['body'][$i]['value']);

			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[label]",  $vtemp['destination']['label'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[produk]",  $vtemp['destination']['produk'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[nominaldenda]",  $vtemp['destination']['nominaldenda'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[dpd]",  $vtemp['destination']['dpd'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[nopolisi]",  $vtemp['destination']['nopolisi'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[jatuhtempo]",  $vtemp['destination']['jatuhtempo'], $vtemp['body']['raw']['body'][$i]['value']);
			$vtemp['body']['raw']['body'][$i]['value'] = str_replace("[angsuranke]",  $vtemp['destination']['angsuranke'], $vtemp['body']['raw']['body'][$i]['value']);

			
			$kirimdata['template']['components'][$pnom]['parameters'][$i]['type'] 		= $vtemp['body']['raw']['body'][$i]['type'];
			$kirimdata['template']['components'][$pnom]['parameters'][$i]['text'] 		= $vtemp['body']['raw']['body'][$i]['value'];
		}
	}


	
	$kirimdata = json_encode($kirimdata);	

	$Apichat_protocol 	= $vtemp['Apichat_protocol'];
	$Apichat_host 		= $vtemp['Apichat_host'];

	if ($vtemp['whatsapp_model'] == 'intikom_onpremise') {

		$url        			= $vtemp['base_url']."/v1/messages";
	    $ch         			= curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_ENCODING, '');
	    curl_setopt($ch, CURLOPT_MAXREDIRS, '10');
	    curl_setopt($ch, CURLOPT_TIMEOUT, '0');
	    curl_setopt($ch, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
          'Authorization: Bearer '.$vtemp['token'],  
          'Content-Type: application/json',
          'Content-Length: '.strlen($kirimdata))                                                                       
        );      
        curl_setopt($ch, CURLOPT_POSTFIELDS, $kirimdata);    
        
        $output     				= curl_exec($ch);
        curl_close($ch);

        if ($output == "") {
        	$response = "No Response from Apichat";
				$sent_status = 2;
				$output['errors'][0]['code'] 	= "1234 - No Response from Apichat";
				$custom_uid = "No Response from Apichat";
        }else{
        	$output = json_decode($output,true);
				if (isset($output['errors'][0]['code'])) {
					$sent_status = 2;
					$custom_uid = $output['errors'][0]['code']." - ".$output['errors'][0]['title']." (".$output['errors'][0]['details'].")";
				}else{
					$custom_uid = $output['messages'][0]['id'];
					$response = "";
					$sent_status = 1;
				}
        }

	}else{
		 $sent_status 			= 2;
		 $responsite['error'] 	= "Elyphsoft Library For Model ".$vtemp['model']." Undefined";
		 $output['errors'][0]['code'] 	= "Elyphsoft Library For Model ".$vtemp['model']." Undefined";
		 $responset 			= "Elyphsoft Library For Model ".$vtemp['model']." Undefined";
	}

	
	if (($sent_status == 2)AND(substr($output['errors'][0]['code'], 0, 4) == $fourdigit_code)) {
		
		$myfile = fopen("../../../../Blastchecker/Log".date('YmdH').".txt", "a", "a");
		if ($myfile) {
			$txt = "".date('H:i:s')." > ".$sent_status." [".$output['errors'][0]['code']."]  \n";
			fwrite($myfile, $txt);
			$txt = "Data : ".json_encode($vtemp)."\n";
			fwrite($myfile, $txt);
			$txt = "Result : Repush after {{".$delaytime."}} seconds \n";
			fwrite($myfile, $txt);
			$txt = "\n----\n";
			fwrite($myfile, $txt);
			fclose($myfile);
		}
		sleep($delaytime);
		
		//kirim blast ulang 
		$body = json_encode($vtemp);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $nodejs);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'token: '.$token
		));
		$exec = curl_exec($ch);
		curl_close($ch);
	
	}else{

		$myfile = fopen("../../../../Blast/blast_report".date('YmdHis').".txt", "a") or die("Unable to open file!");
		$laporan['time']['start']		= $timestart;
		$laporan['time']['last'] 		= date('Y-m-d H:i:s');
		$laporan['request'] 	= $vtemp;
		$laporan['responset']['sent_status'] 	= $sent_status;
		$laporan['responset']['description'] 	= $response;
		$laporan['responset']['custom_uid'] 	= $custom_uid;
		$laporan['responset']['raw'] 			= $output;
		$laporan['form']['raw'] 			= json_decode($kirimdata,true);
		$laporan['form']['url'] 			= $url;

		$txt = json_encode($laporan)."[!elyphsoft_partition&^!]";

		fwrite($myfile, $txt);
		
		
		fclose($myfile);



		$myfile = fopen("../../../../Blastchecker/Log".date('Ymd').".txt", "a", "a");
		if ($myfile) {
			$txt = "".date('H:i:s')." > ".$sent_status." [".$output['errors'][0]['code']."]  \n";
			fwrite($myfile, $txt);
			$txt = "Data : ".json_encode($vtemp)."\n";
			fwrite($myfile, $txt);
			$txt = "Result : Done \n";
			fwrite($myfile, $txt);
			$txt = "\n----\n";
			fwrite($myfile, $txt);
			fclose($myfile);
		}
	}
	//catet outbox

		
		
		
?>