<?php

if (!isset($_GET['message']) || empty($_GET['message'])) {
	exit;
}

require(LIB_PATH.'/autoload.php');
$al->register();

$db = DatabaseFactory::getInstance(DatabaseFactory::TYPE_MASTER);

$channel = '';
if (isset($_GET['channel'])) {
	$channel = '#'.$db->real_escape_string(stripslashes($_GET['channel']));
}
$message = 'PRIVMSG '.$channel.' :'.$db->real_escape_string(stripslashes($_GET['message']));

$query = "
INSERT INTO
	botMsgQueue
SET
	message='".$message."',
	channel='".$channel."',
	messageTime=NOW()
";
if ($db->query($query,__FILE__,__LINE__)) {
	echo 'success';
} else {
	echo 'failure';
}

?>
