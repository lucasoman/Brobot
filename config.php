<?php
return array(
		'runtime'=> array(
			'command_char'=>'!',
			'plugin_dir'=>'Plugin/',
			'irccommand_dir'=>'IrcCommand/',
			'ircmessage_dir'=>'IrcMessage/',
			'log_file'=>'/tmp/brobot.log',
			),
		'database'=> array(
			'db_user'=>'user',
			'db_pass'=>'password',
			'db_ip'=>'localhost',
			'db_port'=>'3306',
			'db_name'=>'database',
			),
		'plugins'=> array(
			'msgqueue'=> array(
				'batch_seconds'=>'5',
				'batch_size'=>'3',
				'minutes_back'=>'15',
				'command_max_len'=>'255',
				),
			'timeoutcheck'=> array(
				'timeout'=>360,
				),
			),
		'servers'=> array(
			array(
				'server'=>'tandy.irchin.net',
				'port'=>6667,
				'user'=>'brobot_test',
				'nick'=>'brobot_test',
				'channels'=>array(
					'#brobottest',
					),
				),
			),
			);
?>
