<?php
return array(
		'runtime'=> array(
			'handler_dir'=>'Handler/',
			'plugin_dir'=>'Plugin/',
			'irccommand_dir'=>'IrcCommand/',
			'command_char'=>'!',
			'log_file'=>'/tmp/brobot.log',
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
