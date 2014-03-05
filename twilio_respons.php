<?php

require_once('./lib/conf.php'); // Loads Settings

// Load functions.
$Other_func = new Other_Functions();
$My_Twlio = new My_Twilio_REST();

// XSS対策
if($_POST):$_POST = $Other_func->html_xss($_POST);
endif;

if($_POST['Digits'] == 1):
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo '<Response>';
	echo '<Say voice="woman" language="ja-jp">';
	echo '電話を転送します';
	echo '</Say>';
	echo '<Dial action="http://test:1234@shared-blog.kddi-web.com/my_twilio/twilio_call_end.php" record="true">+819099999999</Dial>';
	echo '</Response>';
else:
	$My_Twlio->Twilio_XML_Say('さようなら');
endif;