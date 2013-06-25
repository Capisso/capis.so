<?php

namespace Capisso;

class URL extends \Eloquent
{
    protected $table = 'urls';
    protected $fillable = array('alias', 'url', 'user_id');
    protected $visible = array('alias', 'url');

    public static function alias($length = 3)
    {
        $alias = \Str::quickRandom($length);

        if (self::where('alias', '=', $alias)->first() != false) {
            $alias = self::alias($length);
        }

        return $alias;
    }
}