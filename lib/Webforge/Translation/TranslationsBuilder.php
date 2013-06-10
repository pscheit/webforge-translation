<?php

namespace Webforge\Translation;

class TranslationsBuilder {

  protected $domain;

  protected $translations = array();

  /**
   * @var string the current locale
   */
  protected $locale;

  public static function create($domain = NULL) {
    return new static($domain);
  }

  public function __construct($domain = NULL) {
    $this->domain = $domain;
  }

  /**
   * Sets the current locale for the next trans()
   * 
   * @param string $locale
   * @chainable
   */
  public function locale($locale) {
    $this->locale = $locale;
    return $this;
  }

  /**
   * Adds a new translation for the previous setted locale()
   * 
   * @param string $key categories separated with . only a-Z0-9 and . allowed
   * @param string $translation the translation for the key
   * @chainable
   */
  public function trans($key, $translation) {
    $this->translations[$this->locale][$key] = $translation;
    return $this;
  }

  /**
   * @return array $translations every key is the locale every keys in dim 2 are translations keys
   */
  public function build() {
    return $this->translations;
  }
}
