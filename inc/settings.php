<?php
//email settings for contact forms
//Settings for all form scripts



include("./email_settings.php");
//load database for wedding information
    $wedding_query = ('SELECT wedding_name, wedding_date FROM wedding LIMIT 1');
    $wedding_result = $db->query($wedding_query);

    $wedding = $db->prepare($wedding_query);
    $wedding->execute();

    $wedding->bind_result($wedding_name, $wedding_date);
    $wedding->fetch();
    $wedding->close();
    $cd_date = $wedding_date; //date variable for countdown timer
    $weddingdate = strtotime($wedding_date);
    $wedding_date = date('d m Y', $weddingdate);
    //load events
    $events = $db->query('SELECT event_location, event_address FROM wedding_events ORDER BY event_time LIMIT 1');
    $events_result = $events->fetch_assoc();
    $event_location = $events_result['event_location'];
    $event_address = $events_result['event_address'];
    
////////////////Modules Available\\\\\\\\\\\\\\\\\\\\
//connect to modules table and load available modules
$modules_query = ('SELECT wedding_module_name, wedding_module_status FROM wedding_modules');
$modules = $db->query($modules_query);
$modules_result = $modules->fetch_assoc();
//Reviews
$module_reviews = "On";
$api_key = ""; //api key from google source
$place_id = ""; //Found from google places api
//Image Gallery


foreach ($modules as $module) {
    //RSVP
    if ($module['wedding_module_name'] == "Guest Area") {
        $guest_area_status = $module['wedding_module_status'];
    }

}