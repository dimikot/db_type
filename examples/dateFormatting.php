<?php

include '../utils/autoload.php';


$date_format = 'd.m.Y'; // Russian date format

$dateParser = new DB_Type_Date(null, $date_format);

$localized_date = '27.09.2011';

// save localized date to DB
$output = $dateParser->output($localized_date);
echo $output, "\n\n";
// 2011-09-27

// get localized date from DB
$input = $dateParser->input($output);
echo $input, "\n\n";
// 27.09.2011

// save date in custom format "on the fly"
$output = $dateParser->output(array('m/d/Y', '11/27/2012'));
echo $output, "\n\n";
// 2012-11-27
