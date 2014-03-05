<?php
require_once('./twilio-php/Services/Twilio.php'); // Loads the library
require_once('./lib/conf.php'); // Loads Settings


// Load MyTwilio Class
$My_Twilio = new My_Twilio_REST();
// Load functions.
$Other_func = new Other_Functions();

// // // // // // // // // // // 
// XSS対策
$_POST = $Other_func->html_xss($_POST);

// // // // // // // // // // // 
// Conect to REST API
$client = $My_Twilio->twilio_conect_api();

// // // // // // // // // // // 
// 音声ファイルの保存
$url = $_POST["RecordingUrl"];
$name = 'twilio_record_file';
$referer = "http://shared-blog.kddi-web.com/";

$Other_func->mp3_download($url, $referer, $name);

// // // // // // // // // // // 
// 音声ファイル保存後、Twilioに保存しているファイルを削除する
$client->account->recordings->delete($_POST["RecordingSid"]);

/* ログデータ準備 */
$log_data = 'Call_Sid='.$_POST["CallSid"]."\n";
$log_data .= 'DialCallStatus='.$_POST["DialCallStatus"]."\n";
$log_data .= 'AccountSid='.$_POST["AccountSid"]."\n";
$log_data .= 'CallDuration='.$_POST["DialCallDuration"]."\n";
$log_data .= 'RecordingUrl='.$_POST["RecordingUrl"]."\n";
$log_data .= 'ToNumber='.$My_Twilio->get_callnumber_from_parentcallsid($_POST["CallSid"],$client)."\n";
$log_data .= '----------終了-------------'."\n\n";

// データ保存
$Other_func->put_log_data($log_data);

// 応答メッセージ
$My_Twilio->Twilio_XML_Say('ありがとうございました');







