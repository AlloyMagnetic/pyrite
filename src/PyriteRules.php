<?php

namespace Drupal\pyrite;

/**
 * Class PyriteRules.
 */
class PyriteRules {

  /**
   * Constructs a new PyriteRules object.
   */
  public function __construct() {

  }

  public static function nameMatch($values) {
    $match_value = false;
    foreach ($values as $value) {
      if ($match_value) {
        if ($value == $match_value) {
          return [$value, $match_value];
        }
      }
      else {
        $match_value = $value;
      }
    }
    return false;
  }
  
  public static function prohibitedWords($values) {
    $prohibited = ['arse', 'ballsack', 'bastard', 'bastards', 'bitch', 'bitches', 'bitcoin', 'bitcoins', 'blockchain', 'blockchains', 'blowjob', 'blowjobs', 'blow job', 'blow jobs', 'boner', 'boners', 'boob', 'boobs', 'buttplug', 'clitoris', 'clit', 'cock', 'coon', 'cunt', 'dick', 'dildo', 'dyke', 'fellate', 'fellatio', 'fuck', 'Goddamn', 'God damn', 'hentai', 'jerk', 'jizz', 'labia', 'lesbian', 'muff', 'nigger', 'nigga', 'penis', 'piss', 'poop', 'porn', 'pube', 'pussy', 'queer', 'scrotum', 'shit', 'slut', 'smegma', 'spunk', 'tits', 'tosser', 'turd', 'twat', 'vagina', 'wank', 'whore', 'online dating', 'internet dating', 'guest post', 'teens', 'teenagers', 'testosterone', 'payday loan', 'payday loans', 'personal loan', 'personal loans', 'seo metrics', 'search engine', 'search engines', 'anime', 'viagra', 'cialis', 'drugs', 'killer', 'unsubscribe', 'lead generation', 'SEO', 'mortgage', 'click here', 'loans', 'loan'];
    foreach ($values as $value) {
      foreach ($prohibited as $word) {
        if (stripos($value, " $word") !== false) {
          return $word;
        }
      }
    }
    return false;
  }
  
  public static function russianEmail($values) {
    foreach ($values as $value) {
      $value = trim($value);
      $check_value = substr($value, -3);
      if ($check_value == '.ru') {
        return $value;
      }
    }
    return false;
  }
  
  public static function phoneZero($values) {
    foreach ($values as $value) {
      $value = trim($value);
      $value = preg_replace('/[^0-9]+/', '', $value);
      $check_value = substr($value, 0, 1);
      if ($check_value == '0') {
        return $value;
      }
    }
    return false;
  }

  public static function multipleUrls($values) {
    foreach ($values as $value) {
      $match = preg_match_all('@((https?://)?([-\\w]+\\.[-\\w\\.]+)+\\w(:\\d+)?(/([-\\w/_\\.]*(\\?\\S+)?)?)*)@', $value);
      if ($match > 1) {
        return $value;
      }
    }
    return false;
  }
  
  public static function bitly($values) {
    foreach ($values as $value) {
      if (strpos($value, 'bit.ly')) {
        return $value;
      }
      if (strpos($value, 'tinyurl.com')) {
        return $value;
      }
    }
    return false;
  }
  
  public static function localDomain($values) {
    foreach ($values as $value) {
      if (strpos($value, \Drupal::request()->getHost())) {
        return $value;
      }
    }
    return false;
  }

  public static function cyrillic($values) {
    foreach ($values as $value) {
      $match = preg_match('/[А-Яа-яЁё]/u', $value, $matches);
      if ($match) {
        return $matches[0];
      }
    }
  }

  public static function chinese($values) {
    foreach ($values as $value) {
      $match = preg_match('/\p{Han}+/u', $value, $matches);
    }
    if ($match) {
      return $matches[0];
    }
  }

  public static function invalidCapitals($values) {
    foreach ($values as $value) {
      $value = trim($value);
      $match = preg_match_all('/[a-z][A-Z]{2}/m', $value);
      if ($match >= 1) {
        return $value;
      }
    }
    return false;
  }

}

