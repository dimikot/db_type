DB_Type: conversion of complex PostgreSQL types (ARRAY, ROW, HSTORE) to PHP and vice versa
Version: 2.x
(C) Dmitry Koterov, http://en.dklab.ru/lib/DB_Type/
License: LGPL

ABSTRACT
--------

DB_Type is a simple framework to convert complex database types (e.g.
PostgreSQL arrays, hstores, rows) into their PHP equivalents and back.
You may work with complex typed values (e.g. PostgreSQL's 2-dimensional 
array of a composite type) as simple as it is a PHP 2d array.

Suported types:

* SQL'92 standard tyles (string, numeric, date, timestamp etc.)
* PostgreSQL array with elements of any type (including multi-dimensional).
* PostgreSQL composite type and ROWTYPE (including multi-dimensional).
* PostgreSQL hstore (including stringified complex elements).


WHAT IS THIS LIBRARY FOR?
-------------------------

Many databases (e.g. PostgreSQL) supports complex types as a column value.
E.g. you may define a column which holds a 2d-array of strings:

  CREATE TABLE something(
    id INTEGER,
    matrix TEXT[][]
  );
  INSERT INTO something(id, matrix) VALUES(
    1, ARRAY[ARRAY['one','two'], ARRAY['three "3"','four']]
  );

If you try to fetch such value in PHP:

  $rs = $pdo->query("SELECT matrix FROM something WHERE id=1");
  echo $rs->fetchColumn();
  
you will get a "stringified" representation of such value:

  {{one,two},{"three \"3\"",four}}
  
DB_Type allows you to convert such "stringified" values into their PHP
representations and vice versa. It takes care about escaping of special
characters (quotes, empty strings, NULLs etc.) which methods are different
for different complex types.


SYNOPSIS
--------

// Create an "array of strings" parser.
$parser = new DB_Type_Pgsql_Array(new DB_Type_String());
// Will return array("one", "two")
$array = $parser->input('{one,two}');


// Create an "array of array of strings" parser.
$parser = new DB_Type_Pgsql_Array(
  new DB_Type_Pgsql_Array(
    new DB_Type_String()
  )
);
// Will return array(array("one", "two"), array('three "3"', "four"))
$array = $parser->input('{{one,two},{"three \"3\"",four}}');
// Convert value back to stringified format to pass to PostgreSQL:
echo $parser->output($array);


-- Assume we have a row type:
CREATE TYPE inventory_item AS (
    name            text,
    supplier_id     integer,
    price           numeric
);
CREATE TABLE on_hand (
    item      inventory_item,
    count     integer
);
INSERT INTO on_hand VALUES (ROW('fuzzy dice', 42, 1.99), 1000);
// Create this row parser.
$parser = new DB_Type_Pgsql_Row(array(
  'name'        => new DB_Type_String(),
  'supplier_id' => new DB_Type_Int(),
  'price'       => new DB_Type_Numeric(),
));
// Will return array("name" => 'fuzzy dice', 'supplier_id' => 42, 'price' => 1.99)
$row = $parser->input('("fuzzy dice",42,1.99)');
// Build the stringified representation back:
echo $parser->output($row);


// Create a parser for "array of rows of (string, int, numerid)".
$parser = new DB_Type_Pgsql_Array(
  new DB_Type_Pgsql_Row(array(
    'name'        => new DB_Type_String(),
    'supplier_id' => new DB_Type_Int(),
    'price'       => new DB_Type_Numeric(),
  )
);


// Create a hstore parser.
$parser = new DB_Type_Pgsql_Hstore(new DB_Type_String());
// Will return array("aaa" => 'bq', 'b' => null, '' => 1)
$hash = $parser->input('aaa=>bq, b=>NULL, ""=>1');
// You may also create "hstore of arrays" or even "hstore of
// arrays of composite types"


// Timestamp parser.
$parser = new DB_Pgsql_Type_Timestamp();
// Will return 1204450462.
echo $parser->input("2008-03-02 12:34:22");
// Will build the timestamp back.
echo $parser->output(1204450462);


// Other simple types:
// - DB_Type_Date
// - DB_Type_Time
// - DB_Type_String
// - DB_Type_Numeric
// - DB_Type_Int
// - DB_Type_Pgsql_Boolean ("t" and "f" PostgreSQL's values)


TYPE MODIFIERS (WRAPPERS)
-------------------------

// Create a parser/builder "array of strings in which all strings
// are space-trimmed on insertion automatically"
$parser = new DB_Type_Pgsql_Array(
  new DB_Type_Wrapper_Trim(new DB_Type_String())
);


// Create a parser/builder "array of strings in which all strings are
// space-trimmed, and empty strings are converted to NULLs".
$parser = new DB_Type_Pgsql_Array(
  new DB_Type_Wrapper_EmptyNull
    new DB_Type_Wrapper_Trim(
      new DB_Type_String()
    )
  )
);


// Create a date with month-truncating on insertion.
$parser = new DB_Type_Date(DB_Type_Date::TRUNC_MONTH);
// Create a time with minutes-truncating on insertion.
$parser = new DB_Type_Time(DB_Type_Time::TRUNC_MINUTE);
// Create a timestamp with hour-truncating on insertion.
$parser = new DB_Type_Timestamp(DB_Type_Timestamp::TRUNC_HOUR);


// Create a parser/builder which always inserts a constant.
$parser = new DB_Type_Constant("value");
// Will print "value"
echp $parser->output('123');


VALIDATORS AND LIMITERS
-----------------------

// A parser/builder "array of strings within 10 to 20 characters".
try {
  $parser = new DB_Type_Pgsql_Array(
    new DB_Type_String(10, 20)
  );
} catch (DB_Type_Exception_Common $e) {
  ...
}


// The same as above, but with separated validator wrapper.
$parser = new DB_Type_Pgsql_Array(
  new DB_Type_Wrapper_Length(new DB_Type_String(), 10, 20)
);


// Also validation exceptions are thrown when you try to
// convert a wrongly-formated string to complex types or
// wrong type values to strings.


HOW TO CONVERT FROM 1.X VERSION?
--------------------------------

The 2.x version of this library has namespace DB_Type, not
DB_Pgsql_Type as 1.x version.

If you use the previous version of this library, DB_Pgsql_Type,
please use utils/MIGRATE_100_TO_200.pl script to search for
all DB_Pgsql_* class names and replace them to DB_Type_* names.
