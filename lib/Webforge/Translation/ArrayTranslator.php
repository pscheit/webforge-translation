<?php

namespace Webforge\Translation;

use Symfony\Component\Translation\Translator as SymfonyTranslator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Webforge\Common\System\Dir;

class ArrayTranslator implements ResourceTranslator {

  /**
   * @var Symfony\Component\Translation\Translator
   */
  protected $translator;

  protected $loaderFormats = array();

  public function __construct($locale, Array $i18nTranslations, Array $fallbackLocales = NULL) {
    $this->translator = new SymfonyTranslator($locale, new MessageSelector());
    $this->setFallbackLocales($fallbackLocales ?: array('en'));
    
    $this->translator->addLoader('array', new ArrayLoader());
    
    $this->translator->addLoader('php', new PhpFileLoader());
    $this->loaderFormats[] = 'php';

    foreach ($i18nTranslations as $locale => $translations) {
      $this->translator->addResource('array', $translations, $locale);
    }
  }

  /**
   * @return string
   */
  public function trans($id, Array $parameters = array(), $domain = NULL, $locale = NULL) {
    return $this->translator->trans($id, $parameters, $domain, $locale);
  }

  /**
   * @param string en or en_EN is okay
   */
  public function setLocale($locale) {
    $this->translator->setLocale($locale);
    return $this;
  }

  /**
   * @return string
   */
  public function getLocale() {
    return $this->translator->getLocale();
  }

  /**
   * @param string an array of locales that are used if no translation is avaible
   */
  public function setFallbackLocales(Array $locales) {
    $this->translator->setFallbackLocales($locales);
    return $this;
  }

  public function addResourceDirectory(Dir $dir) {
    foreach ($dir->getFiles($this->loaderFormats) as $file) {
      list($domain, $locale, $format) = explode('.', $file->getName(), 3);

      $this->addResource($format, (string) $file, $locale, $domain);
    }
    return $this;
  }

  public function addResource($format, $resource, $locale, $domain = null) {
    $this->translator->addResource($format, (string) $resource, $locale, $domain);
    return $this;
  }
}
