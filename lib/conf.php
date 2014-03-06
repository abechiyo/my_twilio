<?php

/*******************************

// Settings

*******************************/

class My_Twilio_Settings
{

	// ログデータの格納場所
	public $SERVER_ROOT_PATH = '/usr/home/aa115zaox6/data';
	
	// Twilio SID、token
	public $Twilio_Sid       = "Your Sid Here"; 
	public $Twilio_Token     = "Your Token Here";

}


/*******************************

// Twilio APIS

*******************************/
class My_Twilio_REST extends My_Twilio_Settings
{

	// Connect to Twilio REST API
	public function twilio_conect_api(){
		$client = new Services_Twilio($this->Twilio_Sid, $this->Twilio_Token);
		return $client;
	}


	public function get_callnumber_from_parentcallsid($callsid,$client){
		foreach ($client->account->calls->getIterator(0, 1, array(
			"ParentCallSid" => $callsid)) as $call
		) { $ToNumber = $call->to; }
		return $ToNumber;
	}

	public function Twilio_XML_Say($say){
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo '<Response>';
		echo '<Say voice="woman" language="ja-jp">';
		echo $say;
		echo '</Say>';
		echo '</Response>';
	}
}

/*******************************

// Other

*******************************/

class Other_Functions extends My_Twilio_Settings
{

	// XSS対策
	public function html_xss($post_data){
		foreach ($post_data as $key => $value){
		  $return_value = htmlspecialchars($value, ENT_QUOTES);
		  $return_value_arr[$key] = $return_value;
		}
		return $return_value_arr;
	}

	// ログデータ保存
	public function put_log_data($log_data){
		/* ログデータをファイルに保存 */
		$log_data_file = $this->SERVER_ROOT_PATH . '/filename.txt';
		$fp = fopen($log_data_file , 'ab');
		if ($fp){
		       fwrite($fp,  $log_data);}
		fclose($fp);
	}

	// mp3ファイルダウンロード
	public function mp3_download($url, $referer, $name)
	{
	    $path = $this->SERVER_ROOT_PATH.'/'.$name.'.mp3';
	    $fp = fopen($path, 'w');
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_FILE, $fp);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	                'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:13.5) Gecko/20100101 Firefox/13.4.9\r\n',
	                "Referer: $referer" 
	    ));
	    $data = curl_exec($ch);
	    curl_close($ch);
	    fwrite($fp, $data);
	    fclose($fp);
	}

}







