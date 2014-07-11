<?php
class DB_Type_Pgsql_Test_ByteaTest extends DB_Type_Test_Util_TypeTestCase
{
    // In theory we have to run this test for 4 configurations:
    // - hex, standard_conforming_strings=off
    // - hex, standard_conforming_strings=on
    // - escape, standard_conforming_strings=off
    // - escape, standard_conforming_strings=on
    // In practice it requires a live PostgreSQL for tests, it is too complex.
    protected function _getPairsOutput()
    {
        return array(
            array(
                new DB_Type_Pgsql_Bytea(true),
                'abc',
                '\x616263',
                "BYTEA",
            ),
            array(
                new DB_Type_Pgsql_Bytea(true),
                chr(0) . chr(1),
                '\x0001',
                "BYTEA",
            ),
            array(
                new DB_Type_Pgsql_Bytea(),
                chr(0) . chr(1) . 'abc\'xx\\yy',
                pg_escape_bytea('a') == 'a'
                    ? '\000\001abc\'xx\\\\yy'
                    : '\x00016162632778785c7979',
                "BYTEA",
            ),
            array(
                new DB_Type_Pgsql_Bytea(),
                $this->_getCharSeq(0, 255),
                pg_escape_bytea('a') == 'a'
                    ? '\000\001\002\003\004\005\006\007\010\011\012\013\014\015\016\017\020\021\022\023\024\025\026\027\030\031\032\033\034\035\036\037 !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\\\]^_`abcdefghijklmnopqrstuvwxyz{|}~\177\200\201\202\203\204\205\206\207\210\211\212\213\214\215\216\217\220\221\222\223\224\225\226\227\230\231\232\233\234\235\236\237\240\241\242\243\244\245\246\247\250\251\252\253\254\255\256\257\260\261\262\263\264\265\266\267\270\271\272\273\274\275\276\277\300\301\302\303\304\305\306\307\310\311\312\313\314\315\316\317\320\321\322\323\324\325\326\327\330\331\332\333\334\335\336\337\340\341\342\343\344\345\346\347\350\351\352\353\354\355\356\357\360\361\362\363\364\365\366\367\370\371\372\373\374\375\376\377'
                    : '\x000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f202122232425262728292a2b2c2d2e2f303132333435363738393a3b3c3d3e3f404142434445464748494a4b4c4d4e4f505152535455565758595a5b5c5d5e5f606162636465666768696a6b6c6d6e6f707172737475767778797a7b7c7d7e7f808182838485868788898a8b8c8d8e8f909192939495969798999a9b9c9d9e9fa0a1a2a3a4a5a6a7a8a9aaabacadaeafb0b1b2b3b4b5b6b7b8b9babbbcbdbebfc0c1c2c3c4c5c6c7c8c9cacbcccdcecfd0d1d2d3d4d5d6d7d8d9dadbdcdddedfe0e1e2e3e4e5e6e7e8e9eaebecedeeeff0f1f2f3f4f5f6f7f8f9fafbfcfdfeff',
                "BYTEA",
            )
        );
    }
        
    protected function _getPairsInput()
    {
        return $this->_getPairsOutput();
    }

    private function _getCharSeq($from, $to)
    {
        $s = '';
        for ($i = $from; $i <= $to; $i++) {
            $s .= chr($i);
        }
        return $s;
    }
}
