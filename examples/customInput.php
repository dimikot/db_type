<?php

include '../utils/autoload.php';

// User defined class for range field in DB
class myIntRange extends DB_Type_Pgsql_Row
{
	public function __construct()
	{
		parent::__construct(
			array(
				'int_from' => new \DB_Type_Int(),
				'int_to'   => new \DB_Type_Int(),
			)
		);
	}

	public function input($native, $for = '')
	{
		if ($for == 'view') return $this->input_view($native);

		return parent::input($native, $for);
	}

	protected function make_view($value)
	{
		if (!is_array($value)) return $value;

		if ($value['int_from'] && $value['int_to']) return $value['int_from'] . ' - ' . $value['int_to'];
		elseif ($value['int_from']) return 'from' . ' ' . $value['int_from'];
		elseif ($value['int_to']) return 'to' . ' ' . $value['int_to'];
		else return '';
	}

	protected function input_view($native)
	{
		$value = parent::input($native);

		return $this->make_view($value);
	}
}

// Wrap myIntRange for safe save data in DB
$myRange = new DB_Type_Wrapper_Range(new myIntRange(), 'int_from', 'int_to');

// $myRow represent simple table in DB
$myRow = new DB_Type_Pgsql_Row(array(
	'name' => new DB_Type_String(20),
	'range' => $myRange
));

// simulate $_POST data
$_myPOST = array(
	'name' => 'Mike',
	'range' => array(
		'int_from' => '5', // html field name="range[int_from]"
		'int_to' => '10' // html field name="range[int_to]"
	)
);


// ================== OUTPUT ==================
$output = $myRow->output($_myPOST);
echo $output;
// ("Mike","(""5"",""10"")")


// ================== DEFAULT INPUT ==================
echo "\n\n";
$input = $myRow->input($output);
var_dump($input);
/**
 * array(2) {
 *   ["name"]=>
 *   string(4) "Mike"
 *   ["range"]=>
 *   array(2) {
 *	 ["int_from"]=>
 *	 string(1) "5"
 *	 ["int_to"]=>
 *	 string(2) "10"
 *   }
 * }
 */


// ================== CUSTOM INPUT ==================
echo "\n\n";
$input = $myRow->input($output, 'view');
var_dump($input);
/**
 * array(2) {
 *   ["name"]=>
 *   string(4) "Mike"
 *   ["range"]=>
 *   string(6) "5 - 10"
 * }
 */
echo "Range is: ", $input['range'];
// Range is: 5 - 10


// ================== WRAPPER EXCEPTION ==================
echo "\n\n";
$_myPOST['range']['int_from'] = '15'; // int_to remains '10'
try {
	$output = $myRow->output($_myPOST);
} catch (Exception $e) {
	echo $e->getMessage();
	// DB_Type_Pgsql_Row::output() item `range` failed with message: DB_Type_Wrapper_Range::output() conversion error: given 15 > 10, expected item `int_from` <= item `int_to`
}

echo "\n\n";
