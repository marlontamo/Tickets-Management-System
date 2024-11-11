<?php 

class ticketsManagement {

    private $message = "";

    public function __construct(){
        
        // Add Menu
        add_action("admin_menu", array($this, "addTMSMenus"));

        // Add Plugin Scripts
        add_action("admin_enqueue_scripts", array($this, "addTMSPluginScripts"));
    }

    // Setup Menus and Submenus
    public function addTMSMenus(){

        add_menu_page("Tickets Management System", "Tickets System", "manage_options", "tickets-system", array($this, "tmsAddBookHandler"), "dashicons-book-alt", 14);

        add_submenu_page("tickets-system", "Add ticket Page", "Add Ticket", "manage_options", "tickets-system", array($this, "tmsAddBookHandler"));
         
        add_submenu_page("tickets-system", "List Tickets Page", "List Tickets", "manage_options", "list-tickets", array($this, "tmsListBooksHandler"));
        add_submenu_page("tickets-system", "Edit ticket Page", "", "manage_options", "edit-ticket-system", array($this, "tmsEditTicket"));
        add_submenu_page("tickets-system", " ", "", "manage_options", "delete-ticket-system", array($this, "tmsDeleteTicket"));
        add_submenu_page("tickets-system", "Settings ticket Page", "Ticket System Settings", "manage_options", "settings-ticket-system", array($this, "tmsTicketSettings"));
    }
    //Plugin Settings Page  
    public function tmsTicketSettings(){
            ob_start();
            include_once TMS_PLUGIN_PATH .'pages/settings-ticket.php';
            $content = ob_get_contents();
            

    }
    //Plugin Plugin delete CallBack
    public function tmsDeleteTicket(){
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (empty($id)) {
            // Handle error: Ticket ID is missing
            wp_die('Invalid ticket ID.');
        }
    
        global $wpdb;
        $query = $wpdb->prepare("DELETE FROM {$wpdb->prefix}tickets_system WHERE ID = %d", $id);
    
        if ($wpdb->query($query)) {
            // Ticket deleted successfully
            ob_start();
            include_once TMS_PLUGIN_PATH .'pages/delete-ticket.php';
            $content = ob_get_contents();
            ob_end_clean();
            exit;
        } else {
            // Error deleting ticket
            wp_die('Error deleting ticket.');
        }
    }
    //Plugin Edit CallBack 
    public function tmsEditTicket() {
        if (isset($_POST['ticket_id'], $_POST['ticket_name'], $_POST['author_name'])) {
            global $wpdb;
    
            $tid = intval($_POST['ticket_id']);
            $tprice =intval($_POST['ticket_price']);
            $tname = sanitize_text_field($_POST['ticket_name']);
            $tAname = sanitize_text_field($_POST['author_name']);
            $timage = sanitize_text_field($_POST['cover_image']);
    
            $query = $wpdb->prepare("UPDATE {$wpdb->prefix}tickets_system SET 
                                     name = %s, author = %s, profile_image = %s, ticket_price = %d 
                                      WHERE ID = %d", $tname, $tAname,$timage ,$tprice, $tid );
    
            if ($wpdb->query($query)) {
                // Update successful
                $this->message = "Ticket was Updated Successfully";
                ob_start();
        include_once TMS_PLUGIN_PATH . 'pages/edit-ticket.php';
        $content = ob_get_contents();
           
            } else {
                wp_die('Error deleting ticket.');
                $this->message = "Failed to create ticket"; 
            }
                
            
        }
        ob_start();
        include_once TMS_PLUGIN_PATH . 'pages/edit-ticket.php';
        $content = ob_get_contents();
        
        
    }
    // public function addBooksSystemHandler(){

    //     echo "This is a sample message";
    // }
    //Plugin Insert data CallBack
    public function tmsAddBookHandler(){

        $this->saveTicketData();

        $response = $this->message;

        
        ob_start(); 
        include_once TMS_PLUGIN_PATH . 'pages/add-tickets.php'; // Read Content
        $content = ob_get_contents(); // Content stored in variable
        ob_end_clean(); // Buffer clean

        echo $content; // Content print
    }

    private function saveTicketData(){

        global $wpdb;

        $tablePrefix = $wpdb->prefix; // wp_

        if( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST['btn_form_submit'])){

            // Sanitize
            $ticket_name = sanitize_text_field($_REQUEST['ticket_name']);
            $ticket_author = sanitize_text_field($_REQUEST['author_name']);
            $ticket_price = sanitize_text_field($_REQUEST['ticket_price']);
            $ticket_image = sanitize_text_field($_REQUEST['cover_image']);

            // Insert data
            $wpdb->insert("{$tablePrefix}tickets_system", [
                "name" => $ticket_name,
                "author" => $ticket_author,
                "ticket_price" => $ticket_price,
                "profile_image" => $ticket_image
            ]);

            $ticket_id = $wpdb->insert_id;

            if($ticket_id > 0){

                $this->message = "Successfully, book has been created";
            }else{

                $this->message = "Failed to create ticket";
            }
        }
    }

    public function tmsListBooksHandler(){

        //echo "<h3 class='bms-h3'>This is List Book Page</h3>";

        ob_start();

        include_once TMS_PLUGIN_PATH . 'pages/list-tickets.php';
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;

    }

    // Create table structure
    public function tmsCreateTable(){

        global $wpdb;

        $table_prefix = $wpdb->prefix; // wp_, tbl_

        $tableSql = 'CREATE TABLE `'.$table_prefix.'tickets_system` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(120) NOT NULL,
            `author` varchar(120) NOT NULL,
            `profile_image` text,
            `ticket_price` int DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';

        dbDelta($tableSql);
    }

    // Drop Table
    public function tmsDropTable(){

        global $wpdb;

        $tablePrefix = $wpdb->prefix; // wp_, tbl_

        $tableDropMySQL = "DROP TABLE IF EXISTS {$tablePrefix}tickets_system";

        $wpdb->query($tableDropMySQL);
    }

    // Add Plugin Scripts
    public function addTMSPluginScripts(){

        // CSS
        wp_enqueue_style("tms-style", TMS_PLUGIN_URL . 'assets/css/style.css', array(), "1.0", "all");

        // JS
        wp_enqueue_media();
        wp_enqueue_script("tms-validation", TMS_PLUGIN_URL . 'assets/js/jquery.validate.min.js', array("jquery"), "1.0");
        wp_enqueue_script("tms-script", TMS_PLUGIN_URL . 'assets/js/script.js', array("jquery"), "1.0");
    }
}