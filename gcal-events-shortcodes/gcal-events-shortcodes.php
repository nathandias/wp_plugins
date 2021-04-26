<?php
 
/**
 * Plugin Name: Google Calendar Events Shortcodes
 * Plugin URI:  https://nathandias.com/gcal-events-shortcodes
 * Description: Adds shortcodes to display events from a Google Calendar
 * Version:     1.0.0
 * Author:      Nathan Dias
 * Author URI:  https://nathandias.com/
 * Text Domain: gcal-events-shortcode
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

require_once 'vendor/autoload.php';

function list_google_calendar_events() {

    $output .= "<p>Before " . time() . "</p>\n";

    $client = new Google\Client();
    $client->setApplicationName("gcal-events-shortcodes");
    $client->setDeveloperKey("AIzaSyCy4Ydui1IkBNFn3-Jw48HXvuqmbg6NYNM");

    $service = new Google_Service_Calendar($client);

    $calendarList = $service->calendarList->listCalendarList();

    $output .= "<ul>\n";

    while(true) {
      foreach ($calendarList->getItems() as $calendarListEntry) {
        $output .= "<li>" . $calendarListEntry->getSummary() . "</li>\n";
      }
      $pageToken = $calendarList->getNextPageToken();
      if ($pageToken) {
        $optParams = array('pageToken' => $pageToken);
        $calendarList = $service->calendarList->listCalendarList($optParams);
      } else {
        break;
      }
    }
    
    $output .= "</ul>\n";

    // $optParams = array(
    //     'calendarId' => 'primary',
    //     'maxResults' => 5
    // );
    // $events = $service->events->listEvents($optParams);
    // $output .= "<p>Middle" . time() . "</p>\n";

    $output .= "<ul>\n";
    // // while(true) {

    // //     foreach ($events->getItems() as $event) {
    // //       $output .= "<li>" . $event->getSummary() . "</li>\n";
    // //     }
    // //     $pageToken = $events->getNextPageToken();
    // //     if ($pageToken) {
    // //       $optParams = array('pageToken' => $pageToken);
    // //       $events = $service->events->listEvents('primary', $optParams);
    // //     } else {
    // //       break;
    // //     }
    // // }
    $output .= "</ul>\n";

    $output .= "<p>After " . time() . "</p>\n";

    return $output;
}

add_shortcode('gcal-events-list', 'list_google_calendar_events');