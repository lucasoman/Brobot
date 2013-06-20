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
			'db_user'=>'',
			'db_pass'=>'',
			'db_ip'=>'localhost',
			'db_port'=>'3306',
			'db_name'=>'',
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
			'responder'=> array(
				array(
					'type'=>'has',
					'match'=>'dude',
					'response'=>'Dude.',
					),
				array(
					'type'=>'command',
					'match'=>'fistbump',
					'response'=>'Yeah man.',
					'except'=>array(
						'#brobottest',
						),
					),
				array(
					'type'=>'command',
					'match'=>'tea',
					'response'=>'One lump or two?',
					'only'=>array(
						'#lounge',
						),
					),
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
