<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-05-18 14:34:14 --- ERROR: Kohana_Exception [ 0 ]: Unable to connect to MongoDB server at connecting to mongodb://127.0.0.1 failed: Transport endpoint is not connected ~ MODPATH/mango/classes/mangodb.php [ 132 ]
2011-05-18 14:39:36 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.ID JOIN `private_conversations` ON () WHERE `read_to` = 0 AND `message_to` = '4' at line 1 ( SELECT COUNT(message_id) AS `total` FROM `private_conversation_messages` PRIVATE_CONVERSATIONS.ID JOIN `private_conversations` ON () WHERE `read_to` = 0 AND `message_to` = '4' ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-05-18 14:44:37 --- ERROR: ErrorException [ 2 ]: Missing argument 3 for Kohana_Database_Query_Builder_Select::on(), called in /var/www/swiftsharing/application/classes/model/member.php on line 584 and defined ~ MODPATH/database/classes/kohana/database/query/builder/select.php [ 138 ]
2011-05-18 14:45:02 --- ERROR: ErrorException [ 8 ]: Undefined variable: blab ~ APPPATH/views/feed/blab.php [ 1 ]
2011-05-18 14:45:07 --- ERROR: ErrorException [ 8 ]: Undefined variable: blab ~ APPPATH/views/feed/blab.php [ 1 ]
2011-05-18 14:45:54 --- ERROR: Kohana_Cache_Exception [ 0 ]: Memcache PHP extention not loaded ~ MODPATH/cache/classes/kohana/cache/memcache.php [ 120 ]