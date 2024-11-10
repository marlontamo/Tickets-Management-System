<?php

if(!class_exists("WP_List_Table")){

    include_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class TicketsListTable extends WP_List_Table{

    public function prepare_items(){
        
        global $wpdb;

        $tablePrefix = $wpdb->prefix;
        $per_page = 5; // 4 + 4 + 1

        // Order by
        $orderBy = isset($_GET['orderby']) ? $_GET['orderby'] : "id";
        $order = isset($_GET['order']) ? $_GET['order'] : "ASC";

        // Search keyword
        $search = isset($_GET['s']) ? $_GET['s'] : false;

        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        // (2 - 1) * 4
        // 1 * 4 = 4
        // 3 - 1 = 2 * 4 = 8

        $this->_column_headers = array($this->get_columns(), [], $this->get_sortable_columns());

        if($search){ // Search value is available

            // Total number of books
            $totalBooks = $wpdb->get_results("SELECT * FROM {$tablePrefix}tickets_system WHERE name LIKE '%{$search}%' OR author LIKE '%{$search}%'", ARRAY_A);

            // Books on limit
            $books = $wpdb->get_results("
            SELECT * FROM {$tablePrefix}tickets_system 
            WHERE name LIKE '%{$search}%' OR author LIKE '%{$search}%'
            ORDER BY {$orderBy} {$order} 
            LIMIT {$offset}, {$per_page}", 
            ARRAY_A);

            $totalBookItems = count($totalBooks);
        }else{

            // Total number of books
            $totalBooks = $wpdb->get_results("SELECT * FROM {$tablePrefix}tickets_system", ARRAY_A);

            // Books on limit
            $books = $wpdb->get_results("
            SELECT * FROM {$tablePrefix}tickets_system 
            ORDER BY {$orderBy} {$order} 
            LIMIT {$offset}, {$per_page}", 
            ARRAY_A);

            $totalBookItems = count($totalBooks);
        }

        // 0.5 -> 1, 0.2 -> 1

        $this->set_pagination_args(array(
            "total_items" => $totalBookItems,
            "per_page" => $per_page,
            "total_pages" => ceil($totalBookItems/$per_page)
        ));

        $this->items = $books;
    }

    // Return column name
    public function get_columns(){

        // Key => value
        // DB Table column key => Front-end table column headers
        $columns = [
            "cb" => '<input type="checkbox" />',
            "id" => "ID",
            "name" => "Ticket Name",
            "author" => "Author Name",
            "profile_image" => "Ticket Cover",
            "ticket_price" => "Ticket Cost",
            "created_at" => "Created at",
        ];

        return $columns;
    }

    // No data found
    public function no_items(){

        echo "No Ticket(s) Found";
    }

    // To display data
    // public function column_default($singleBook, $col_name){

    //     return isset($singleBook[$col_name]) ? $singleBook[$col_name] : "N/A";
    // }

    // Add Sorting Icons
    public function get_sortable_columns(){

        $columns = array(
            "id" => array("id", true), // desc
            "name" => array("name", false) // asc
        );

        return $columns;
    }

    // Add Checkbox to rows
    public function column_cb($book){

        return '<input type="checkbox" name="book_id[]" value="'.$book['id'].'" />';
    }

    // Render Image in place of URL
    public function column_profile_image($book){

        return '<img src="'.$book['profile_image'].'" height="100px" width="100px"/>';
    }
    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'id':
                $actions = [];
                $actions['edit'] = '<a href="' . admin_url('admin.php?page=edit-ticket-system&action=edit&id=' . $item['id']) . '">Edit</a>';
                $actions['delete'] = '<a href="' . wp_nonce_url(admin_url('admin.php?page=delete-ticket-system&action=delete&id=' . $item['id']), 'delete_item_' . $item['id']) . '" onclick="return confirm(\'Are you sure you want to delete this item? This will Permanently Delete this Ticket\');">Delete</a>';
                return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions));
            case 'name':
            case 'author':
            case 'profile_image':
            case 'ticket_price':
            case 'created_at':
                return $item[$column_name];
            default:
                return print_r($item, true); // For debugging
        }
    }
}