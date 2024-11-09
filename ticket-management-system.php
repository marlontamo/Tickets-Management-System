<?php

/*
* Plugin name: Tickets Management System
* Plugin URI: https://example.com/ticket-management-system
* Description: This is a plugin to Manage all tickets.
* Author: Marlon Tamo
* Author URI: https://marlontest.online
* Version: 1.0
* Requires PHP: 7.2
* Requires at least: 6.2
*/

// Constants

define("TMS_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("TMS_PLUGIN_URL", plugin_dir_url(__FILE__));
define("TMS_PLUGIN_BASENMAE", plugin_basename(__FILE__));

include_once TMS_PLUGIN_PATH . 'classes/TicketsManagement.php';

$ticketsManagementObject = new TicketsManagement();

register_activation_hook(__FILE__, array($ticketsManagementObject, "tmsCreateTable"));

register_deactivation_hook(__FILE__, array($ticketsManagementObject, "tmsDropTable"));