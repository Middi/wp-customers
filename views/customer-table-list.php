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
            case 'id':
            case 'customer':
            case 'email':
                return $item[$column_name];
            default:
                return print_r($item,true); 
        }
    }



    function column_customer($item){
        
        //Build row actions
        $actions = array(
            []
        );
        
        //Return the title contents
        return sprintf('<a href="?page=%1$s&action=%2$s&customer=%3$s">%4$s',
            $_REQUEST['page'],
            'edit',
    /*$2%s*/ $item['id'],
    /*$1%s*/ $item['customer'],
             $this->row_actions($actions)
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
            "id" => "ID",
            "customer" => "Customer",
            "email" => "Email",
        );

        return $columns;
    }




    function get_sortable_columns() {

        return array(
            "customer" => array("customer", true),
            "email" => array("email", false)
        );
    }


    function get_bulk_actions()
    {
        $actions = array(
            'cancel'    => 'Cancel Events',
            'delete'    => 'Delete',
        );

        return $actions;
    }

    function process_bulk_action() {
        if( 'delete'===$this->current_action() ) {
            foreach($_POST['customer'] as $customer) {
                wp_delete_user($customer);
            }
            $this->items = $this->wp_list_table_data($orderby, $order, $search_term);
        }

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
    }

    function wp_list_table_data($orderby = '', $order = '', $search_term = '') {


        global $wpdb;

        $role = 'customer';

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
                ),
            ) );

            $all_posts = $users->get_results() ? $users->get_results() : [];
            
        } else {

            if ($orderby == "customer" && $order == "desc") {
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'DESC' ) );

            } elseif ($orderby == "customer" && $order == "asc")  {
               
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'ASC' ) );

            }
            elseif ($orderby == "email" && $order == "asc")  {
               
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'ASC' ) );

            }
            elseif ($orderby == "email" && $order == "desc")  {
               
                $all_posts = get_users( array( 'role' => 'customer', 'order' => 'DESC' ) );

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
                );
            }
        }

        return $posts_array;
    }




}

function customer_show_data_list_table() {

    $customer_table = new CustomerListTable();

    $customer_table->prepare_items();
    echo '<div class="wrap">';
    echo '<h3>This is List</h3>';
    echo "<form method='post'>";
    ?>
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
    <?php
    $customer_table->search_box("Search Post(s)", "search_post_id");
    $customer_table->display();
    echo "</form>";
    echo "</div>";
}

customer_show_data_list_table();
