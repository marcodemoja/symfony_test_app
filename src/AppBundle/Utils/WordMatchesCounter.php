<?php

namespace AppBundle\Utils;


class WordMatchesCounter {

    public static function countMatches($words_to_search, $text){

            $arr_words = explode(" ",$words_to_search);
            $arr_text  = explode(" ",$text);

            $result = array_intersect($arr_text,$arr_words);

            return count($result);
    }

}