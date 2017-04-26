<?php
// Settings API Variables
$option_group //Unique group name for option set
$option_name // Name of each option. Can be an array for multiple options
$sanitize_callback // section/field callback function to validate option data
$id  // unique ID for the section/field
$title  //the title of the section/field (displayed on options page)
$callback // callback function to be executed
$page  //options page name (use __FILE__ if creating new options page)
$section // ID of the settings section (needs to be the same as $id in add_settings_section)
$args // array() – additional arguments


settings_fields($option_group);
register_setting($option_group, $option_name, $sanitize_callback=“”);
unregister_setting($option_group, $option_name, $sanitize_callback=“”);
add_settings_section($id, $title, $callback, $page);
add_settings_field($id, $title, $callback, $page, $section, $args = array());
do_settings_sections($page)

?>
