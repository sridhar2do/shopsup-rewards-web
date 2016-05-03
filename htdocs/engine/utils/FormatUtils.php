<?php

namespace engine\utils;

class FormatUtils {
	
	public static function changeToJsonProperty($str) { 
		return preg_replace('/\s+/', '_', strtolower($str));		
	}

	public static function purifyHtml($content) {
		return $content;
	}

	public static function getForOutput($text) {
		return self::getSentence($text, true);
	}

	public static function getForStorage($text) {
		return strtolower ( trim ( $text ) );
	}

	public static function getSentence($text, $stripTags = true) {
		if($stripTags) {
			$text = strip_tags($text);
		}

		$sentences = preg_split('/([.?!]+)/', $text, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$newSentence = '';
		foreach ($sentences as $key => $sentence) {
			$newSentence .= ($key & 1) == 0?
				ucfirst(strtolower(trim($sentence))) :
				$sentence.' ';
		}
		return trim($newSentence);
	}
	
}