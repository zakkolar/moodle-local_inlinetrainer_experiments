<?php

class local_inlinetrainer_experiments_helpers
{
    public static function increment_item($item){
        if (!preg_match_all('/(.*?)([0-9]+)$/', $item, $matches)) {
            return $item.'1';

        } else {
            return $matches[1][0].($matches[2][0]+1);
        }
    }
}