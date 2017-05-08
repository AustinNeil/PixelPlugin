<?php

if (!defined("WP_UNINSTALL_PLUGIN")){
	exit;
}

delete_option('PixelID');
delete_option('CustomTrackingURL1');
// delete_option('Option3');
// delete_option('Option4');
// delete_option('Option5');
