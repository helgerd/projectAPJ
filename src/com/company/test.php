<?php
global $DB_HOST, $DB_DB, $DB_USER, $DB_PASS, $DB_PORT;
$DB_HOST	= 'localhost';
$DB_DB		= 'database';
$DB_USER	= 'username';
$DB_PASS	= 'password';
$DB_PORT	= 3306;

function db_connect()
{
	global $DB_HOST, $DB_DB, $DB_USER, $DB_PASS;

	if(!function_exists('mysql_pconnect'))
		die('MySQL, a critical component for this site, is not accessible through PHP. Contact your system administrator or web host for more details.');

	$_SESSION['db'] = @mysql_pconnect($DB_HOST, $DB_USER, $DB_PASS);

	if(!$_SESSION['db'])
		die('Unable to establish a connection to the database. Contact your system administrator.');

	@mysql_select_db($DB_DB, $_SESSION['db']);
}

function db_backup()
{
	$filename = $_SERVER['HTTP_HOST'] . '_' . date('YmdHi') . '.sql.gz';
	$file = '/tmp/'.$filename;

	passthru("mysqldump --user=$DB_USER --password=$DB_PASS --host=$DB_HOST $DB_DB | gzip &gt; $file");

	$file_part = explode('/', $file);

	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Length: ' . (string)(filesize($file)));
	header('Content-Disposition: attachment; filename=' . $file_part[(count($file_part) - 1)]);

	readfile($file);
}

function db_escape($var)
{
	return @mysql_escape_string($var);
}

function db_write($q)
{
	$rs = db_query($q);
	return $rs ? 1 : 0;
}

function db_query($q)
{
	if(!isset($_SESSION['db']) || !$_SESSION['db'])
		db_connect();

	if(!@is_resource($_SESSION['db']))
		db_error('Not connected to a database. Cannot execute query.');

	if(isset($_SESSION['queries']))
		$_SESSION['queries'][] = $q;

	if(!$return = @mysql_query($q, $_SESSION['db']))
		db_error('Could not execute the following query&lt;br /&gt;' . "\n" . '&lt;pre id="query"&gt;' . $q . '&lt;/pre&gt;' . mysql_error($_SESSION['db']));

	return $return;
}

function db_fetch_all($q, $fetch = DB_ASSOC)
{
	$rs = db_query($q);

	switch($fetch)
	{
		case DB_ROW:
			$function = 'mysql_fetch_row';
			break;
		case DB_ARRAY:
			$function = 'mysql_fetch_array';
			break;
		case DB_ASSOC:
		default:
			$function = 'mysql_fetch_assoc';
			break;
	}

	$return = array();

	while($row = @$function($rs))
		$return[] = $row;

	return $return;
}

function db_fetch_one($q)
{
	$rs = db_query($q);
	$row = @mysql_fetch_assoc($rs);

	return count($row) ? $row : 0;
}

function db_count($q)
{
	$rs = db_query($q);
	$row = @mysql_fetch_row($rs);

	return count($row) ? $row[0] : 0;
}

function db_error($err)
{
	// included a file that would read $err inside of the site's content
	exit;
}
?>;