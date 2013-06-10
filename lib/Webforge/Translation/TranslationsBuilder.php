<?php

namespace Webforge\Translation;

class TranslationsBuilder {

  protected $domain;

  protected $translations = array();

  /**
   * @var string the current locale
   */
  protected $locale;

  /**
   * @var string the current order of locales for trans()
   */
  protected $locales;

  public static function create($domain = NULL) {
    return new static($domain);
  }

  public function __construct($domain = NULL) {
    $this->domain = $domain;
  }

  /**
   * Sets the single locale for the next trans()
   * 
   * @param string $locale
   * @chainable
   */
  public function locale($locale) {
    $this->locales = NULL;
    $this->locale = $locale;
    return $this;
  }

  /**
   *  Sets a order of two or more locales for the next trans
   * 
   * ->locales('de', 'en')
   *   ->trans('hello', 'Hallo Welt', 'Hello World')
   */
  public function locales($locale1, $locale2, $localeN) {
    $this->locale = NULL;
    $this->locales = func_get_args();
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
    if (isset($this->locales)) {
      $args = func_get_args();
      array_shift($args);
      foreach ($this->locales as $locale) {
        $this->translations[$locale][$key] = array_shift($args);
      }

    } elseif(isset($this->locale)) {
      $this->translations[$this->locale][$key] = $translation;
    
    } else {
      throw new \LogicException('Use locale() or locales(). After that use trans().');
    }

    return $this;
  }

  /**
   * @return array $translations every key is the locale every keys in dim 2 are translations keys
   */
  public function build() {
    return $this->translations;
  }
}
