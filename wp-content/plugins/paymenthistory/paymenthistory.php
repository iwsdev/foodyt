<?php
/*
  Plugin Name: Payment History
  Plugin URI: http://i-webservices.com
  Description: Payment History.
  Version: 0.1
  Author: Satish Anand
  Author URI: http://satishanand.in
 */

//$blog_location = $_SERVER['DOCUMENT_ROOT'];
$blog_location = $_SERVER['DOCUMENT_ROOT']."/wordpress/foodyT/";
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

add_action('admin_menu', 'paymenthistory_list');

function paymenthistory_list() {
    add_menu_page("Payment History", "Payment History", 'administrator', "paymenthistory", "paymenthistorylist", null, 99);
}

function paymenthistorylist() {
    global $wpdb;
    $menu_details = $wpdb->prefix."menu_details";

    if (isset($_GET['action']) && $_GET['action'] == 'changestatus') {
        $wpdb->update($menu_details, array('status' => $_GET['statusid']), array('id' => $_GET['pro_id']), array('%d'), array('%d'));
        ?>
        <script>
            window.location = '<?php echo bloginfo('url') ?>' + '/wp-admin/admin.php?page=dish';
        </script>
        <?php
    }
   $payment = $wpdb->prefix."payment";

    $query = "SELECT * FROM $payment where payment_status='active' ORDER BY id DESC";
    $getgata = $wpdb->get_results($query);
   // echo '<pre>';
   // print_r($getgata);exit;
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
    <div class="headtrt"><h3>Payment History</h3></div>
    <div class="col-md-12">
        <table class="package table table-striped" id="ownerlist1">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Restaurant Name</th>
                    <th>User Email</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($getgata) > 0) {
                    $i = 1;
                    foreach ($getgata as $payment) {
                        $id = $payment->restaurant_id;
                        $resName = get_the_title($id);
                        $email = get_post_meta($id,'email',true);
                        ?>
                        <tr>
                            <td class="alert alert-info"><?php echo $i++ ?></td>
                            <td class="alert alert-info"><?php echo $resName ?></td>
                            <td class="alert alert-info"><?php echo $email ?></td>
                            <td class="alert alert-info"><?php echo $payment->total_amount_with_vat ?></td>
                            <td class="alert alert-info"><?php echo date('d M, Y', strtotime($payment->created_date)); ?></td>
                            <td class="alert alert-info"><a href="<?php echo site_url()?>/facturacion-detail/?id=<?php echo $payment->id?>&uid=<?php echo $payment->user_id?>"><img src="<?php echo get_template_directory_uri()?>/assets/images/pdf_icon.png" width="35" height="30" /></a></td>
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
