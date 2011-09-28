<?php

include '../utils/autoload.php';

// ================================= Row itemsInput =================================
$parser = new DB_Type_Pgsql_Row(array(
	'row_field'	=> new DB_Type_Pgsql_Row(array(
		'row_item1' => new DB_Type_Int(),
		'row_item2' => new DB_Type_String()
	)),
	'simple_field' => new DB_Type_String(),
));

// Sql query result input
$sql_result = array(
	'row_field'	=> '("5","text")',
	'simple_field' => 'simple'
);

echo "\n\n";
$result = $parser->input($sql_result);
var_dump($result);
/*
array(2) {
	["row_field"]=>
  array(2) {
		["row_item1"]=>
    string(1) "5"
    ["row_item2"]=>
    string(4) "text"
  }
  ["simple_field"]=>
  string(6) "simple"
}
*/

// Sql query result input with additionally fields
$sql_result = array(
	'row_field'		=> '("5","text")',
	'simple_field'	 => 'simple',
	'some_other_field' => 'other'
);

echo "\n\n";
$result = $parser->input($sql_result);
var_dump($result);
/*
array(3) {
  ["row_field"]=>
  array(2) {
    ["row_item1"]=>
    string(1) "5"
    ["row_item2"]=>
    string(4) "text"
  }
  ["simple_field"]=>
  string(6) "simple"
  ["some_other_field"]=>
  string(5) "other"
}
*/


// ================================= Array itemsInput =================================

$parser       = new DB_Type_Pgsql_Array(
	new DB_Type_Pgsql_Row(
		array(
			'a' => new DB_Type_Int(),
			'b' => new DB_Type_String()
		)
	)
);

$array_result = array('("1","d")', '("3","e")');

echo "\n\n";
$input = $parser->input($array_result);
var_dump($input);
/*
array(2) {
  [0]=>
  array(2) {
    ["a"]=>
    string(1) "1"
    ["b"]=>
    string(1) "d"
  }
  [1]=>
  array(2) {
    ["a"]=>
    string(1) "3"
    ["b"]=>
    string(1) "e"
  }
}
*/


// ================================= Hstore itemsInput =================================

$parser        = new DB_Type_Pgsql_Hstore(
	new DB_Type_Pgsql_Hstore(new DB_Type_String())
);

$hstore_result = array("first"  => "a => NULL, b => value",
					   "second" => "a => value, b => NULL");

echo "\n\n";
$input = $parser->input($hstore_result);
var_dump($input);
/*
array(2) {
  ["first"]=>
  array(2) {
    ["a"]=>
    NULL
    ["b"]=>
    string(5) "value"
  }
  ["second"]=>
  array(2) {
    ["a"]=>
    string(5) "value"
    ["b"]=>
    NULL
  }
}
*/


// ================================= HstoreRow itemsInput =================================

$parser        = new DB_Type_Pgsql_HstoreRow(array(
	'int_field'   => new DB_Type_Int(),
	'array_field' => new DB_Type_Pgsql_Array(new DB_Type_Int()),
));

$hstore_result = array(
	"int_field"   => "10",
	"array_field" => "{15,20}",
	"other_field" => 'other'
);

echo "\n\n";
$input = $parser->input($hstore_result);
var_dump($input);
/*
array(3) {
  ["int_field"]=>
  string(2) "10"
  ["array_field"]=>
  array(2) {
    [0]=>
    string(2) "15"
    [1]=>
    string(2) "20"
  }
  ["other_field"]=>
  string(5) "other"
}
*/

echo "\n\n";
