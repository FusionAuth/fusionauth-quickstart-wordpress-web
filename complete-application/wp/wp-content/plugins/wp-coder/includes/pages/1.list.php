<?php
/*
 * Page Name: List
 */

use WPCoder\Dashboard\ListTable;
use WPCoder\WOW_Plugin;

defined( 'ABSPATH' ) || exit;

$list_table = new ListTable();
$list_table->prepare_items();
?>

<form method="post" class="wowp-list">
	<?php
	$list_table->search_box( esc_attr__( 'Search', 'wpcoder' ), WOW_Plugin::PREFIX );
	$list_table->display();
	?>
    <input type="hidden" name="page" value="<?php echo sanitize_text_field( $_REQUEST['page'] ); ?>"/>
</form>
<?php
