<?php
/*
  Plugin Name: Dish
  Plugin URI: http://i-webservices.com
  Description: Dimond Product List.
  Version: 0.1
  Author: Arjit Gautam
  Author URI: http://Arjitgautam.in
 */

//$blog_location = $_SERVER['DOCUMENT_ROOT'] ;
$blog_location = $_SERVER['DOCUMENT_ROOT']."/wordpress/foodyTv2/";
if (!file_exists($blog_location . '/wp-config.php')) {
    if (strpos($_SERVER['PHP_SELF'], 'wp-admin') !== false)
        $path = '';
    else
        $path = 'wp-admin/';
    require_once( $blog_location . '/wp-includes/classes.php');
    require_once( $blog_location . '/wp-includes/user.php');
    require_once( $blog_location . '/wp-includes/functions.php');
    require_once( $blog_location . '/wp-includes/plugin.php');
    wp_die("error message", "WordPress › Error");
}

require_once( $blog_location . '/wp-config.php');
global $wpdb;

add_action('admin_menu', 'dish_list');

function dish_list() {
    add_menu_page("Dish", "Dish", 'administrator', "dish", "dishlist",null ,99);
}

function dishlist() {
    global $wpdb;
    $tab = $wpdb->prefix."menu_details";
    if (isset($_GET['action']) && $_GET['action'] == 'changestatus') {
        $wpdb->update($tab, array('status' => $_GET['statusid']), array('id' => $_GET['pro_id']), array('%d'), array('%d'));
        ?>
        <script>
            window.location = '<?php echo bloginfo('url') ?>' + '/wp-admin/admin.php?page=dish';
        </script>
        <?php
    }
    $tab = $wpdb->prefix."menu_details";
     $query = "SELECT `wmd`.*,`wms`.`status` FROM $tab as wmd, `ft_menu_status` as wms WHERE `wms`.`id`=`wmd`.`status` order by id desc";
    $getgata = $wpdb->get_results($query);
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" media='all' />
    <style>
        table.dataTable tbody th, table.dataTable tbody td{vertical-align:middle}
    </style>
    <style>
        .dia-add{padding-bottom: 35px;width: 99%;}
        .dataTables_filter{margin-right:12px;}
    </style>
    <div class="headtrt"><h3>Dish</h3></div>
    <div class="col-md-12">
        <table class="package table table-striped" id="ownerlist1">
            <thead>
                <tr>
                    <!--<th>Dish Id</th>-->
                    <th>Sr.No.</th>
                    <th>Dish Name</th>
                    <th>Image</th>
                    <th>User Id</th>
                    <th>Language</th>
                    <th>Action</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($getgata) > 0) {
                    $i=1;
                    foreach ($getgata as $dish) {
                        ?>
                        <tr>
                            <!--<td><?php // echo $dish->id ?></td>-->
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $dish->name ?></td>
                            <td>
                                <img src="<?php echo $dish->attachment ?>" style="max-height: 50px;width: auto">
                            </td>
                            <td><?php echo $dish->entry_by ?></td>
                            <td><?php echo $dish->language ?></td>
                            <td>
                                <?php if ($dish->status !== 'Approved') { ?>
                                    <a href="<?php bloginfo('url') ?>/wp-admin/admin.php?page=dish&action=changestatus&statusid=2&pro_id=<?php echo $dish->id ?>" class="btn btn-success">Approve</a>
                                <?php } if ($dish->status !== 'Rejected') { ?>
                                    <a href="<?php bloginfo('url') ?>/wp-admin/admin.php?page=dish&action=changestatus&statusid=3&pro_id=<?php echo $dish->id ?>" class="btn btn-danger">Reject</a>
                                <?php } ?>
                            </td>
                            <td><?php echo $dish->status ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            <tbody>
        </table>
    </div>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('#ownerlist1').DataTable();
        });
    </script>
    <?php
}
?>
