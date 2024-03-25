<?php

namespace Grav\Plugin\Gravified;

use Grav\Common\Grav;
use Grav\Common\Page\Collection;

class Utils {
  /**
   * @param string $str
   * @param false $lower
   * @return string
   */
  public static function slugify(string $str, $lower = false): string {
    if (function_exists('transliterator_transliterate')) {
      $str = transliterator_transliterate('Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove;', $str);
    } else {
      $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
    }

    if ($lower) {
      $str = mb_strtolower($str);
    }

    $str = preg_replace('/[-\s]+/', '-', $str);
    $str = preg_replace('/[^a-z0-9-]/i', '', $str);
    return trim($str, '-');
  }
}
