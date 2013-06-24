<?php

namespace Capisso;

class URL extends \Eloquent
{
    protected $table = 'urls';
    protected $fillable = array('alias', 'url');
    protected $visible = array('alias', 'url');

    public static function alias($length = 3)
    {
        $pool = implode('', array_merge(range('a', 'z'), range('A', 'Z')));
        $alias = substr(str_shuffle(str_repeat($pool, 3)), 0, $length);

        if (self::where('alias', '=', $alias)->first() != false) {
            $alias = self::alias($length);
        }

        return $alias;
    }
}