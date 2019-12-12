<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class CustomerListTable extends WP_List_Table {
    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'customer',     //singular name of the listed records
            'plural'    => 'customers',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );   
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'customer':
            case 'id':
            case 'email':
            case 'telephone':
            case 'date':
                return $item[$column_name];
            default:
                return print_r($item,true); 
        }
    }

    function column_customer($item){
        
        //Build row actions
        $actions = array(
            'delete'    => sprintf('<a href="?page=%s&action=%s&customer=%s">Delete</a>',$_REQUEST['page'],'single_delete',$item['id']),
        );
        
        //Return the title contents
        return sprintf('<a href="?page=%1$s&action=%2$s&customer=%3$s">%5$s %6$s</a><span style="color:silver">(id:%3$s)</span>%7$s',
            $_REQUEST['page'],
            'edit',
    /*$2%s*/ $item['id'],
    /*$1%s*/ $item['customer'],
    /*$1%s*/ $item['first_name'],
    /*$1%s*/ $item['last_name'],
             $this->row_actions($actions)
        );
    }


    function column_telephone($item){
        //Return the title contents
        return sprintf($item['telephone'] ? '<a href="tel:%1$s"><span class="dashicons dashicons-phone" style="color: green;"></span></a>' : '<span class="dashicons dashicons-phone" disabled"></span>',
            $item['telephone']
        );
    }
        
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
        );
    }


    function get_columns() {

        $columns = array(
            'cb'        => '<input type="checkbox" />',
            "customer" => "Customer",
            "id" => "ID",
            "email" => "Email",
            "telephone" => "Telephone",
            "date" => "Registered",
        );
        return $columns;
    }

    function get_sortable_columns() {
        return array(
            "customer" => array("customer", false),
            "email" => array("email", false),
            "date" => array("date", false)
        );
    }


    function get_bulk_actions() {
        return array( 'delete'    => 'Delete');
    }

    function process_bulk_action() {
        if( 'delete'===$this->current_action() ) {
            foreach($_GET['customer'] as $customer) {
                wp_delete_user($customer);
            }
        }

        elseif( 'single_delete'===$this->current_action() ) {
            wp_delete_user($_GET['customer']);
        }

        $this->items = $this->wp_list_table_data($orderby, $order, $search_term);

    }

    function prepare_items() {

        global $wpdb; //This is used only if making any database queries

        $orderby = isset($_GET['orderby']) ? trim($_GET['orderby']) : "";
        $order = isset($_GET['order']) ? trim($_GET['order']) : "";

        $search_term = isset($_POST['s']) ? trim($_POST['s']) : "";

        $this->items = $this->wp_list_table_data($orderby, $order, $search_term);

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        
        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = count($this->items);

        $this->items = array_slice($this->items,(($current_page-1)*$per_page),$per_page);
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }

    function wp_list_table_data($orderby = '', $order = '', $search_term = '') {

        global $wpdb;
        
        if (!empty($search_term)) {

            $users = new WP_User_Query( array(
                'role' => 'customer',
                'search'         => '*'.esc_attr( $search_term ).'*',
                'search_columns' => array(
                    'user_login',
                    'user_nicename',
                    'user_email',
                    'user_url',
                    'display_name',
                    'telephone',
                ),
            ) );

            $all_posts = $users->get_results() ? $users->get_results() : [];
        }
        else {
            if ($orderby == "customer" && $order == "desc") {
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'DESC', 'orderby' => 'display_name' ) );
            }
            elseif ($orderby == "customer" && $order == "asc")  {
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'ASC', 'orderby' => 'display_name' ) );
            }
            elseif ($orderby == "email" && $order == "asc")  {
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'ASC', 'orderby' => 'user_email' ) );
            }
            elseif ($orderby == "email" && $order == "desc")  {
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'DESC', 'orderby' => 'user_email' ) );
            }
            elseif ($orderby == "date" && $order == "desc")  {
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'DESC', 'orderby' => 'user_registered' ) );
            }
            elseif ($orderby == "date" && $order == "asc")  {
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'ASC', 'orderby' => 'user_registered' ) );
            }
            else {
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'ASC' ) );
            }
        }


        $posts_array = array();

        if (count($all_posts) > 0) {
            foreach ($all_posts as $index => $post) {
                $posts_array[] = array(
                    "id" => $post->ID,
                    "customer" => $post->display_name,
                    "email" => $post->user_email,
                    "date" => $post->user_registered,
                    "first_name" => get_usermeta($post->ID, 'first_name'),
                    "last_name" => get_usermeta($post->ID, 'last_name'),
                    "telephone" => get_usermeta($post->ID, 'telephone')
                );
            }
        }
        return $posts_array;
    }
}

function customer_show_data_list_table() {

    $customer_table = new CustomerListTable();

    $customer_table->prepare_items();
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Customers</h1>
        <form method='get'>
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php
            $customer_table->search_box("Search Customers", "search_post_id");
            $customer_table->display();
            ?>
        </form>
    </div>
    <?php
}

customer_show_data_list_table();

function col_styles() {
    $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
    if( 'customer-list-table' != $page )
    return; 
    
    echo '<style type="text/css">';
    echo '.column-id { width: 8%; }';
    echo '.fixed .column-date { width: 15%; }';
    echo '</style>';
}

col_styles();