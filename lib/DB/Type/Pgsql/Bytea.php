<?php
class DB_Type_Pgsql_Bytea extends DB_Type_Abstract_Primitive
{
    private $_useOctFormat;

    public function __construct($useOctFormat = null)
    {
        if ($useOctFormat === null) {
            // Escaping format: aa -> aa, <0><1> -> \000\001 OR \\000\\001
            // Hex format: aa -> \x6161, <0><1> -> \x0001 OR \\x0001
            $this->_useOctFormat = pg_escape_bytea('a') == 'a';
        } else {
            $this->_useOctFormat = $useOctFormat;
        }
    }

    public function output($value)
    {
        if ($value === null) {
            return null;
        }
        if ($this->_useOctFormat) {
            // Note that pg_escape_bytea($value) === pg_escape_string($this->output($value)),
            // so, to calculate output(), we have to unescape pg_escape_bytea() result.
            // See http://www.postgresql.org/docs/9.0/static/datatype-binary.html
            // The result of output() must be:
            //   * chr(92) - backslash -> \\ (doubled)
            //   * 0 to 31 and 127 to  255 - \123 (slash + octal code)
            //   * others (including apostrophe) - remained as is
            // If this result is fed to pg_escape_string(), we'll get pg_escape_bytea().
            $slash = chr(92);
            $escaped = pg_escape_bytea($value);
            if (pg_escape_bytea($slash) == $slash . $slash . $slash . $slash) {
                // Seems standard_conforming_strings = false, slashes and apostrophes are
                // doubled (so pg_escape_bytea(SLASH) returns FOUR SLASHes in this mode!).
                // So we unescape double slashes.
                $escaped = str_replace($slash . $slash, $slash, $escaped);
            }
            // Apostrophes are always doubled, see PostgreSQL's PQescapeByteaInternal().
            return str_replace("''", "'", $escaped);
        } else {
            return '\x' . current(unpack("H*", $value));
        }
    }

    public function input($native)
    {
        if ($native === null) {
            return null;
        }
        return pg_unescape_bytea($native);
    }
    
    public function getNativeType()
    {
        return 'BYTEA';
    }
}
