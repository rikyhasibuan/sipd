<?php

namespace Pengaduan\Libraries;
use Illuminate\Support\Facades\DB;

/**
 * Class Shortcode
 *
 * Parse sticker or emoji on text.
 *
 * @package Pengaduan\Libraries
 */
class Shortcode {

    /**
     * @var string
     */
    protected $regex = "/\[:(.*?)\]/";
    
    /**
     * @var Array
     */
    public $matches = [];

    /**
     * @param String $text
     * @param String $type
     * @return String $text
     */
    function parsingText($text, $type) {
        preg_match_all($this->regex, $text, $this->matches);
        if (!empty($this->matches)) {
            $sticker = DB::table('sticker')->whereIn('shortcode', $this->matches[0])->get();
            $replace = [];
            if (!empty($sticker)) {
                foreach ($sticker as $val) {
                    if ($type == 'emoji') {
                        array_push($replace, '<img style="width:20px;" src="' . url($val->imagefile) . '">');
                    } else if ($type == 'sticker') {
                        array_push($replace, '<img style="width:64px;" src="'.url($val->imagefile).'">');
                    }
                }
                $text = str_replace($this->matches[0], $replace, $text);
                return $text;
            } else {
                return $text;
            }
        } else {
            return $text;
        }
    }
}