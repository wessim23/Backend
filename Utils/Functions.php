<?php

namespace px\BackendBundle\Utils;

class Functions
{
    public static $jour = array(7 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday');
    public static $mois = array(0 => '', 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
    public static $mois_short = array(0 => '', 1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
    public static $type_formation = array(0 => 'Please choose', 1 => 'First training in eco-driving', 2 => 'Regular training in eco-driving', 3 => 'System performance management to eco-driving');
    public static $special_characters = array("'", '"');
    public static $replace_characters = array("''", '""');

    public static function getSQLText($string)
    {
        return str_replace(self::$special_characters, self::$replace_characters, $string);
    }
    public static function getTextLower($string)
    {
        return mb_strtolower($string, 'UTF-8');
    }
    public static function getDefaultString($string)
    {
        if ($string != null && trim($string) != '') {
            return $string;
        } else {
            return '-';
        }
    }

    public static function getDefaultInteger($integer)
    {
        if ($integer != null && $integer != 0) {
            return $integer;
        } else {
            return '-';
        }
    }

    public static function getDefaultLink($string, $url)
    {
        if ($string != null && trim($string) != '' && $url != null && trim($url) != '') {
            return '<a class="extracttion-link-vert" href="'.$url.'">'.$string.'</a>';
        } else {
            return '-';
        }
    }

    public static function getDefaultIntegerByZero($integer)
    {
        if ($integer != null && $integer != 0) {
            return $integer;
        } else {
            return 0;
        }
    }

    public static function getDefaultdate($date, $format = 'Y-m-d')
    {
        if ($date != null && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
            return date($format, strtotime($date));
        } else {
            return '-';
        }
    }
    public static function convertDateToDateSQLAll($date)
    {
        try {
            if ($date != null && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
                $tab = explode(' ', $date);
                $tab_date = preg_split("/[\/-]+/", $tab[0]);

                $ch = '';
                for ($i = 0; $i < count($tab_date); ++$i) {
                    $ch = $tab_date[$i].($ch != '' ? '%-%' : '').$ch;
                }

                return $ch.(count($tab) > 1 ? (' '.$tab[1]) : '');
            } else {
                return $date;
            }
        } catch (\Exception $e) {
            //var_dump(($date));//die;
            return $date;
        }
    }
    public static function convertDateToDateSQL($date)
    {
        try {
            if ($date != null && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
                $tab = explode(' ', $date);
                $tab_date = preg_split("/[\/-]+/", $tab[0]);

                $ch = '';
                for ($i = 0; $i < count($tab_date); ++$i) {
                    $ch = $tab_date[$i].($ch != '' ? '-' : '').$ch;
                }

                return $ch.(count($tab) > 1 ? (' '.$tab[1]) : '');
            } else {
                return $date;
            }
        } catch (\Exception $e) {
            //var_dump(($date));//die;
            return $date;
        }
    }
    public static function getDefaultDateTime($date, $format = 'Y-m-d')
    {
        if ($date != null && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
            return $date->format($format);
        } else {
            return '-';
        }
    }

    public static function truncate($text, $length = 200, $ending = '...', $exact = false, $considerHtml = true)
    {
        if ($considerHtml) {
            // if the plain text is shorter than the maximum length, return the whole text
          if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
              return $text;
          }
          // splits all html-tags to scanable lines
          preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';
            foreach ($lines as $line_matchings) {
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
           if (!empty($line_matchings[1])) {
               // if it's an "empty element" with or without xhtml-conform closing slash
            if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                // do nothing
            // if tag is a closing tag
            } elseif (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                // delete tag from $open_tags list
             $pos = array_search($tag_matchings[1], $open_tags);
                if ($pos !== false) {
                    unset($open_tags[$pos]);
                }
            // if tag is an opening tag
            } elseif (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                // add tag to the beginning of $open_tags list
             array_unshift($open_tags, strtolower($tag_matchings[1]));
            }
            // add html-tag to $truncate'd text
            $truncate .= $line_matchings[1];
           }
           // calculate the length of the plain text part of the line; handle entities as one character
           $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
                if ($total_length + $content_length > $length) {
                    // the number of characters which are left
            $left = $length - $total_length;
                    $entities_length = 0;
            // search for html entities
            if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                // calculate the real length of all entities in the legal range
             foreach ($entities[0] as $entity) {
                 if ($entity[1] + 1 - $entities_length <= $left) {
                     --$left;
                     $entities_length += strlen($entity[0]);
                 } else {
                     // no more characters left
               break;
                 }
             }
            }
                    $truncate .= substr($line_matchings[2], 0, $left + $entities_length);
            // maximum lenght is reached, so get off the loop
            break;
                } else {
                    $truncate .= $line_matchings[2];
                    $total_length += $content_length;
                }
           // if the maximum length is reached, get off the loop
           if ($total_length >= $length) {
               break;
           }
            }
        } else {
            if (strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = substr($text, 0, $length - strlen($ending));
            }
        }
     // if the words shouldn't be cut in the middle...
     if (!$exact) {
         // ...search the last occurance of a space...
      $spacepos = strrpos($truncate, ' ');
         if (isset($spacepos)) {
             // ...and cut the text in this position
       $truncate = substr($truncate, 0, $spacepos);
         }
     }
     // add the defined ending to the text
     $truncate .= $ending;
        if ($considerHtml) {
            // close all unclosed html-tags
      foreach ($open_tags as $tag) {
          $truncate .= '</'.$tag.'>';
      }
        }

        return $truncate;
    }

    public static function getColonneExcelOld($caractere, $add_nb)
    {
        //$ch = chr( floor(( ord($caractere) + $add_nb ) / 27) );

        $ch = '';
        $caractere = strtoupper($caractere);
        $x = ord($caractere) - 65 + 1 + $add_nb;
        $y = floor($x / 26);
        $r = $x % 26;

        if ($y > 0 && $r != 0) {
            $ch .= chr(65 + $y - 1);
            $ch .= chr(65 + $r - 1);
        } elseif ($y == 0 && $r != 0) {
            $ch .= chr(65 + $r - 1);
        } elseif ($y > 0 && $r == 0) {
            if ($y > 1) {
                $ch .= chr(65 + ($y - 1) - 1);
            }
            $ch .= chr(65 + 26 - 1);
        }
        //echo $y.'/'.$r.'= '.$ch.'<br>';
        return $ch;
    }

    public static function getColonneExcel($caractere, $add_nb)
    {
        //echo $caractere."/";
        //$ch = chr( floor(( ord($caractere) + $add_nb ) / 27) );
        $caractere = strtoupper($caractere);
        $asci = 0;
        for ($i = 0; $i < strlen($caractere); ++$i) {
            $asci += ((ord($caractere[$i]) - 65) + 1) * ($i == (strlen($caractere) - 1) ? 1 : 26);
        }
        $ch = '';

        $x = $asci + $add_nb;//echo $x;
        $y = floor($x / 26);
        $r = $x % 26;

        if ($y > 0 && $r != 0) {
            $ch .= chr(65 + $y - 1);
            $ch .= chr(65 + $r - 1);
        } elseif ($y == 0 && $r != 0) {
            $ch .= chr(65 + $r - 1);
        } elseif ($y > 0 && $r == 0) {
            if ($y > 1) {
                $ch .= chr(65 + ($y - 1) - 1);
            }
            $ch .= chr(65 + 26 - 1);
        }
        //echo $y.'/'.$r.'= '.$ch.'<br>';
        return $ch;
    }

  /* Méthode 1*/
  //levenshtein($str1, $str2);
  public static function similaire($str1, $str2)
  {
      $strlen1 = strlen($str1);
      $strlen2 = strlen($str2);
      $max = max($strlen1, $strlen2);
      $splitSize = 250;
      if ($max > $splitSize) {
          $lev = 0;
          for ($cont = 0;$cont < $max;$cont += $splitSize) {
              if ($strlen1 <= $cont || $strlen2 <= $cont) {
                  $lev = $lev / ($max / min($strlen1, $strlen2));
                  break;
              }
              $lev += levenshtein(substr($str1, $cont, $splitSize), substr($str2, $cont, $splitSize));
          }
      } else {
          $lev = levenshtein($str1, $str2);
      }
      $porcentage = -100 * $lev / $max + 100;
      if ($porcentage > 75) {
          similar_text($str1, $str2, $porcentage);
      }

      return $porcentage;
  }

  /* Méthode 2*/
  // Calcul du coefficient de Dice
  // Inspiration: http://en.wikibooks.org/wiki/Algorithm_Implementation/Strings/Dice%27s_coefficient
  // Licence: Libre de droit

  public static function dice($str1 = '', $str2 = '')
  {
      $str1_length = strlen($str1);
      $str2_length = strlen($str2);

        // Length of the string must not be equal to zero
        if (($str1_length == 0) or ($str2_length == 0)) {
            return 0;
        }

      $ar1 = array();
      $ar2 = array();
      $intersection = 0;

        // find the pair of characters
        for ($i = 0; $i < ($str1_length - 1); ++$i) {
            $ar1[] = substr($str1, $i, 2);
        }

      for ($i = 0; $i < ($str2_length - 1); ++$i) {
          $ar2[] = substr($str2, $i, 2);
      }

        // find the intersection between the two sets
        foreach ($ar1 as $pair1) {
            foreach ($ar2 as $pair2) {
                if ($pair1 == $pair2) {
                    $intersection++;
                }
            }
        }

      $count_set = count($ar1) + count($ar2);
      $dice = (2 * $intersection) / $count_set;

      return $dice;
  }
  /* Méthode 3 */
  /*
      version 1.2
      Copyright (c) 2005-2010  Ivo Ugrina <ivo@iugrina.com>
      A PHP library implementing Jaro and Jaro-Winkler
      distance, measuring similarity between strings.
      Theoretical stuff can be found in:
      Winkler, W. E. (1999). "The state of record linkage and current
      research problems". Statistics of Income Division, Internal Revenue
      Service Publication R99/04. http://www.census.gov/srd/papers/pdf/rr99-04.pdf.
      This program is free software; you can redistribute it and/or modify
      it under the terms of the GNU General Public License as published by
      the Free Software Foundation; either version 3 of the License, or (at
      your option) any later version.
      This program is distributed in the hope that it will be useful, but
      WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
      General Public License for more details.
      You should have received a copy of the GNU General Public License
      along with this program.  If not, see <http://www.gnu.org/licenses/>.
      ===
      A big thanks goes out to Pierre Senellart <pierre@senellart.com>
      for finding a small bug in the code.
  */
  public static function getCommonCharacters($string1, $string2, $allowedDistance)
  {
      $str1_len = strlen($string1);
      $str2_len = strlen($string2);
      $temp_string2 = $string2;
      $commonCharacters = '';
      for ($i = 0; $i < $str1_len; ++$i) {
          $noMatch = true;
        // compare if char does match inside given allowedDistance
        // and if it does add it to commonCharacters
        for ($j = max(0, $i - $allowedDistance); $noMatch && $j < min($i + $allowedDistance + 1, $str2_len); ++$j) {
            if ($temp_string2[$j] == $string1[$i]) {
                $noMatch = false;
                $commonCharacters .= $string1[$i];
                $temp_string2[$j] = '';
            }
        }
      }

      return $commonCharacters;
  }
    public static function Jaro($string1, $string2)
    {
        $str1_len = strlen($string1);
        $str2_len = strlen($string2);
      // theoretical distance
      $distance = floor(min($str1_len, $str2_len) / 2.0);
      // get common characters
      $commons1 = self::getCommonCharacters($string1, $string2, $distance);
        $commons2 = self::getCommonCharacters($string2, $string1, $distance);
        if (($commons1_len = strlen($commons1)) == 0) {
            return 0;
        }
        if (($commons2_len = strlen($commons2)) == 0) {
            return 0;
        }
      // calculate transpositions
      $transpositions = 0;
        $upperBound = min($commons1_len, $commons2_len);
        for ($i = 0; $i < $upperBound; ++$i) {
            if ($commons1[$i] != $commons2[$i]) {
                $transpositions++;
            }
        }
        $transpositions /= 2.0;
      // return the Jaro distance
      return ($commons1_len / ($str1_len) + $commons2_len / ($str2_len) + ($commons1_len - $transpositions) / ($commons1_len)) / 3.0;
    }

    public static function getPrefixLength($string1, $string2, $MINPREFIXLENGTH = 4)
    {
        $n = min(array($MINPREFIXLENGTH, strlen($string1), strlen($string2)));
        for ($i = 0; $i < $n; ++$i) {
            if ($string1[$i] != $string2[$i]) {
                // return index of first occurrence of different characters 
          return $i;
            }
        }
      // first n characters are the same   
      return $n;
    }

    public static function JaroWinkler($string1, $string2, $PREFIXSCALE = 0.1)
    {
        $JaroDistance = self::Jaro($string1, $string2);
        $prefixLength = self::getPrefixLength($string1, $string2);

        return $JaroDistance + $prefixLength * $PREFIXSCALE * (1.0 - $JaroDistance);
    }

  /* Méthode 4 algorithme de SimHash */
  public static function hexbin($str_hex)
  {
      $str_bin = false;
      for ($i = 0; $i < strlen($str_hex); ++$i) {
          $str_bin .= sprintf('%04s', decbin(hexdec($str_hex[$i])));
      }

      return $str_bin;
  }

  // SimHash 
  public static function Charikar_SimHash($tokens)
  {
      $V = array_fill(0, HASHBITS, 0);
      foreach ($tokens as $key => $value) {
          for ($i = 0; $i < HASHBITS; ++$i) {
              if ($value['hash'][$i] == 1) {
                  $V[$i] = intval($V[$i]) + intval($value['weight']);
              } else {
                  $V[$i] = intval($V[$i]) - intval($value['weight']);
              }
          }
      }

      return $V;
  }

  // fingerprint SimHash au format binaire
  public static function SimHashfingerprint($V)
  {
      $fingerprint = array_fill(0, HASHBITS, 0);
      for ($i = 0; $i < HASHBITS; ++$i) {
          if ($V[$i] >= 0) {
              $fingerprint[$i] = 1;
          }
      }

      return $fingerprint;
  }
    public static function SimHashHamming($V1, $V2)
    {
        $Distancehamming = 0;
        for ($i = 0; $i < HASHBITS; ++$i) {
            if ($V1[$i] != $V2[$i]) {
                $Distancehamming += 1;
            }
        }

        return $Distancehamming;
    }

    /**
     * Makes an array of parameters become a querystring like string.
     *
     * @param array $array
     *
     * @return string
     */
    public static function stringify(array $array)
    {
        $result = array();

        foreach ($array as $key => $value) {
            $result[] = sprintf('%s=%s', $key, $value);
        }

        return implode('&', $result);
    }
    public static function convertDateToDateSQLApplication($date)
    {
        try {
            if ($date != null && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
                $tab = explode(' ', $date);
                $tab_date = preg_split("/[\/-]+/", $tab[0]);
                $ch = '';
                for ($i = 0; $i < count($tab_date); ++$i) {
                    $ch = $tab_date[$i].($ch != '' ? '-' : '').$ch;
                }

                return $ch.(count($tab) > 1 ? (' '.$tab[1]) : '');
            } else {
                return $date;
            }
        } catch (\Exception $e) {
            //var_dump(($date));//die;
            return $date;
        }
    }
}
