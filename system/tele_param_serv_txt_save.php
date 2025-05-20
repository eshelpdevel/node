<?php
###############################################################################################################
# Date          |    Type    |   Version                                                                      # 
############################################################################################################### 
#07-05-2025    |   Create   |  1.1.0705.2025                                                                 #
############################################################################################################### 
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";
include "global_func_report.php";

$condb = connectDB();

$v_agentid      = get_session("v_agentid");
$v_agentlevel   = get_session("v_agentlevel");

$param_id = mysqli_real_escape_string($condb,get_param("param_id"));
$parm_value = mysqli_real_escape_string($condb,get_param("parm_value"));

// echo "string $param_id||$parm_value";
// die();

//trail log
$reason_log = "cc_parameter_service_txt $server_ip";

$msg = "";
$sfile = ".";
$response = array();
$response["data"] = array();
	
if($param_id!=''){

			unlink("/var/www/html/wom/service/sosmed/param_txt.txt");

			$myfile = fopen("/var/www/html/wom/service/sosmed/param_txt.txt", "w") or die("Unable to open file!");
			$txt = $parm_value;
			fwrite($myfile, $txt);
			fclose($myfile);
			// die();
			$h['msg']  = "Success";
		    $h['type'] = "updated successfully".$sfile;


          array_push($response["data"], $h);
      $msg .= json_encode($response);
		
}

  echo $msg;
disconnectDB($condb);

?>