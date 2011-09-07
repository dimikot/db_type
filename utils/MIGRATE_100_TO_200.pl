#!/usr/bin/perl -w
use File::Find;

my $path = $ARGV[0] or die("Usage:\n  $0 <project_root_path>");
File::Find::find(\&convert, $path);


sub convert {
	return if $File::Find::dir =~ /\.svn|CVS|\.git/;
	return if !/\.(php|inc|phtml)$/s;

	open(local *F, $File::Find::name); binmode(F);
	local $/;
	my $orig = $_ = <F>;
	close(F);

	do_convert();

	if ($orig ne $_) {
		print "$File::Find::name\n";
		open(local *F, ">", $File::Find::name); binmode(F);
		print F $_;
		close(F);
	}
}


sub do_convert {
	# primitives

	s/DB_Pgsql_Type_Constant/DB_Type_Constant/sg;
	s/DB_Pgsql_Type_Test_Type_ConstantTest/DB_Type_Test_ConstantTest/sg;

	s/DB_Pgsql_Type_Date/DB_Type_Date/sg;
	s/DB_Pgsql_Type_Test_Type_DateTest/DB_Type_Test_DateTest/sg;

	s/DB_Pgsql_Type_Int/DB_Type_Int/sg;
	s/DB_Pgsql_Type_Test_Type_IntTest/DB_Type_Test_IntTest/sg;

	s/DB_Pgsql_Type_Numeric/DB_Type_Numeric/sg;
	s/DB_Pgsql_Type_Test_Type_NumericTest/DB_Type_Test_NumericTest/sg;

	s/DB_Pgsql_Type_String/DB_Type_String/sg;
	s/DB_Pgsql_Type_Test_Type_StringTest/DB_Type_Test_StringTest/sg;

	s/DB_Pgsql_Type_Time/DB_Type_Time/sg;
	s/DB_Pgsql_Type_Test_Type_TimeTest/DB_Type_Test_TimeTest/sg;

	s/DB_Pgsql_Type_Timestamp/DB_Type_Timestamp/sg;
	s/DB_Pgsql_Type_Test_Type_TimestampTest/DB_Type_Test_TimestampTest/sg;



	# wrappers

	s/DB_Pgsql_Type_EmptyNull/DB_Type_Wrapper_EmptyToNull/sg;
	s/DB_Pgsql_Type_Test_Type_EmptyNullTest/DB_Type_Test_Wrapper_EmptyToNullTest/sg;

	s/DB_Pgsql_Type_Length/DB_Type_Wrapper_Length/sg;
	s/DB_Pgsql_Type_Test_Type_LengthTest/DB_Type_Test_Rwapper_LengthTest/sg;

	s/DB_Pgsql_Type_Object/DB_Type_Wrapper_Object/sg;

	s/DB_Pgsql_Type_ReadOnly/DB_Type_Wrapper_ReadOnly/sg;

	s/DB_Pgsql_Type_Trim/DB_Type_Wrapper_Trim/sg;
	s/DB_Pgsql_Type_Test_Type_TrimTest/DB_Type_Test_Rwapper_TrimTest/sg;



	# pgsql

	s/DB_Pgsql_Type_Array/DB_Type_Pgsql_Array/sg;
	s/DB_Pgsql_Type_Test_Type_ArrayTest/DB_Type_Pgsql_Test_ArrayTest/sg;

	s/DB_Pgsql_Type_Boolean/DB_Type_Pgsql_Boolean/sg;
	s/DB_Pgsql_Type_Test_Type_BooleanTest/DB_Type_Pgsql_Test_BooleanTest/sg;

	s/DB_Pgsql_Type_HstoreRow/DB_Type_Pgsql_HstoreRow/sg;
	s/DB_Pgsql_Type_Test_Type_HstoreRowTest/DB_Type_Pgsql_Test_HstoreRowTest/sg;

	s/DB_Pgsql_Type_Hstore/DB_Type_Pgsql_Hstore/sg;
	s/DB_Pgsql_Type_Test_Type_HstoreTest/DB_Type_Pgsql_Test_HstoreTest/sg;

	s/DB_Pgsql_Type_Row/DB_Type_Pgsql_Row/sg;
	s/DB_Pgsql_Type_Test_Type_RowTest/DB_Type_Pgsql_Test_RowTest/sg;



	# abstract

	s/DB_Pgsql_Type_Abstract_Base/DB_Type_Abstract_Base/sg;

	s/DB_Pgsql_Type_Abstract_Container/DB_Type_Abstract_Container/sg;

	s/DB_Pgsql_Type_Abstract_Primitive/DB_Type_Abstract_Primitive/sg;

	s/DB_Pgsql_Type_Abstract_Wrapper/DB_Type_Abstract_Wrapper/sg;


	# exceptions

	s/DB_Pgsql_Type_Exception/DB_Type_Exception/sg;
	s/DB_Pgsql_Type_Test_Type_Exception_CommonTest/DB_Type_Test_Exception_CommonTest/sg;


	# utils

	s/DB_Pgsql_Type_Test_Util_TypeTestCase/DB_Type_Test_Util_TypeTestCase/sg;
}
