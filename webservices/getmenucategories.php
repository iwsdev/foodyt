<?php
include_once 'api.php';
global $wpdb;
$menu_categories_table = $wpdb->prefix."menu_categories";
$query = "SELECT * FROM $menu_categories_table WHERE menu_name like '%" . $_POST["keyword"] . "%' ORDER BY menu_name LIMIT 0,6";
$menu_categories = $wpdb->get_results($query);
if (!empty($menu_categories)) {
    ?>
    <ul id="country-list">
        <?php
        foreach ($menu_categories as $menu_category) {
            ?>
            <li onClick="selectCategoryMenu('<?php echo $menu_category->menu_name; ?>',<?php echo $menu_category->id; ?>);"><?php echo $menu_category->menu_name; ?></li>
        <?php } ?>
    </ul>
<?php } ?>