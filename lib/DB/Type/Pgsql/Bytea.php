<?php
class DB_Type_Pgsql_Bytea extends DB_Type_Abstract_Primitive
{
    private $_forceHexFormat = false;

    public function __construct($forceHexFormat = false)
    {
        // This flag is mostly for unit tests, you may never use it.
        $this->_forceHexFormat = $forceHexFormat;
    }

    public function output($value)
    {
        if ($value === null) {
            return null;
        }
        if ($this->_forceHexFormat) {
            return '\x' . current(unpack("H*", $value));
        } else {
            // Note that pg_escape_bytea($value) === pg_escape_string($this->output($value)),
            // so, to calculate output(), we have to unescape pg_escape_bytea() result.
            // See http://www.postgresql.org/docs/9.0/static/datatype-binary.html
            // The result of output() in Oct format must be:
            //   * chr(92) - backslash -> \\ (doubled)
            //   * 0 to 31 and 127 to  255 - \123 (slash + octal code)
            //   * others (including apostrophe) - remained as is
            // In Hex format:
            //   * \x012345...
            // If this result is fed to pg_escape_string(), we'll get pg_escape_bytea().
            $s = chr(92); // backslash
            $escaped = pg_escape_bytea($value);
            if (in_array(pg_escape_bytea($s), array("{$s}{$s}{$s}{$s}", "{$s}{$s}x" . dechex(ord($s))))) {
                // Seems standard_conforming_strings = false, slashes and apostrophes are
                // doubled (so pg_escape_bytea(SLASH) returns FOUR SLASHes in this mode!).
                // So we unescape double slashes.
                $escaped = str_replace("{$s}{$s}", $s, $escaped);
            }
            // Apostrophes are always doubled, see PostgreSQL's PQescapeByteaInternal().
            return str_replace("''", "'", $escaped);
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
