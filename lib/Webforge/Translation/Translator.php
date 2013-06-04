<?php

namespace Webforge\Translation;

interface Translator {

  public function trans($id, Array $parameters = array(), $domain = NULL, $locale = NULL);

  public function setLocale($locale);

  public function setFallbackLocales(Array $locales) {

}
