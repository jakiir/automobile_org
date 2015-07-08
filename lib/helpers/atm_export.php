<?php
if (!class_exists( 'atm_export' )){ 
		class atm_export{
/**
* Constructor
*/
public function __construct()
{
	global $wpdb;
if(isset($_GET['download_report']))
{
$csv = $this->generate_csv();

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"report.csv\";" );
header("Content-Transfer-Encoding: binary");

echo $csv;
exit;
}

// Create end-points
add_filter('query_vars', array($this, 'query_vars'));
add_action('parse_request', array($this, 'parse_request'));
}


/**
* Allow for custom query variables
*/
public function query_vars($query_vars)
{
$query_vars[] = 'download_report';
return $query_vars;
}

/**
* Parse the request
*/
public function parse_request(&$wp)
{
if(array_key_exists('download_report', $wp->query_vars))
{
$this->download_report();
exit;
}
}

/**
* Download report
*/
public function download_report()
{
echo '<div class="wrap">';
echo '<div id="icon-tools" class="icon32">
</div>';
echo '<h2>Download Report</h2>';
//$url = site_url();

echo '<p>Export the Subscribers';
}

/**
* Converting data to CSV
*/
public function generate_csv()
{
	global $wpdb;
$csv_output = '';
$table = 'users';

$table_name = $wpdb->prefix . 'users';
$i = 0;
/*foreach ( $wpdb->get_col( "DESC " . $table_name, 0 ) as $column_name ) {

  //error_log( $column_name );
  $csv_output = $csv_output . $column_name.",";
$i++;
}*/
$colnames = array(
	'user_login' => 'Username',
	'display_name' => 'Name',
	'user_email' => 'Email'
);
foreach($colnames as $colname) {
	$csv_output = $csv_output . $colname.",";
	$i++;
}

$csv_output .= "\n";

$users = $wpdb->get_results("SELECT * FROM ".$wpdb->$table."");
foreach ( $users as $arc_row ) {
	for ($j=0;$j<1;$j++) {
	$csv_output .= $arc_row->user_login.",";
	$csv_output .= $arc_row->display_name.",";
	$csv_output .= $arc_row->user_email.",";
	}
	$csv_output .= "\n";
}

/*while ($rowr = mysql_fetch_row($values)) {
for ($j=0;$j<$i;$j++) {
$csv_output .= $rowr[$j].",";
}
$csv_output .= "\n";
}*/


return $csv_output;
}
}
}