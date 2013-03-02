<?php
return array(
		'runtime'=> array(
			'handler_dir'=>'Handler/',
			'plugin_dir'=>'Plugin/',
			'irccommand_dir'=>'IrcCommand/',
			'ircmessage_dir'=>'IrcMessage/',
			'command_char'=>'!',
			'log_file'=>'/tmp/brobot.log',
			),
		'database'=> array(
			'db_user'=>'',
			'db_pass'=>'',
			'db_ip'=>'',
			'db_port'=>'',
			'db_name'=>'',
			),
		'servers'=> array(
			array(
				'server'=>'irc.freenode.net',
				'port'=>6667,
				'user'=>'brobot_test',
				'nick'=>'brobot_test',
				'channels'=>array(
					'##brobottest',
					),
				),
			),
			);
?>
