<?php

namespace Webforge\Translation;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\ArrayLoader;

class ArrayTranslator {

  /**
   * @var Symfony\Component\Translation\Translator
   */
  protected $translator;

  public function __construct($locale, Array $i18nTranslations, Array $fallbackLocales = NULL) {
    $this->translator = new Translator($locale, new MessageSelector());
    $this->setFallbackLocales($fallbackLocales ?: array('en'));
    
    $this->translator->addLoader('array', new ArrayLoader());

    foreach ($i18nTranslations as $locale => $translations) {
      $this->translator->addResource('array', $translations, $locale);
    }
  }

  /**
   * @param string en or en_EN is okay
   */
  public function setLocale($locale) {
    $this->translator->setLocale($locale);
    return $this;
  }

  /**
   * @param string an array of locales that are used if no translation is avaible
   */
  public function setFallbackLocales(Array $locales) {
    $this->translator->setFallbackLocales($locales);
    return $this;
  }

  public function trans($id, Array $parameters = array(), $domain = NULL, $locale = NULL) {
    return $this->translator->trans($id, $parameters, $domain, $locale);
  }
}
