<?php
// This file holds our core configuration like the home URL and pagination variables.
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
$core = array();

// home page url
$server_protocol = strtolower(explode('/', $_SERVER['SERVER_PROTOCOL'])[0]);
$core['url'] = "{$server_protocol}://{$_SERVER['HTTP_HOST']}/";

// page given in URL parameter, default page is one
$core['page'] = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$core['start_from'] = ($records_per_page * $core['page']) - $records_per_page;