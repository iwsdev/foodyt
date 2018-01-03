<?php
include_once 'api.php';
global $wpdb;
$menu_categorie_table = $wpdb->prefix."menu_categories";

$query = "SELECT * FROM $menu_categorie_table WHERE menu_name='" . $_POST["category"] . "' AND `entry_by`=" . $_POST['user_id'] . " ORDER BY menu_name LIMIT 0,6";
$menu_categories = $wpdb->get_results($query);
if (count($menu_categories) == 0)
    $wpdb->insert(
            $menu_categorie_table, array(
        'menu_name' => $_POST['category'],
        'entry_by' => $_POST['user_id']
            ), array(
        '%s',
        '%f',
        '%d'
            )
    );
