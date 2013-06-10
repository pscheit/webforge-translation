<?php

namespace Webforge\Translation;

interface ResourceTranslator extends Translator {

 /**
  * Adds another Resource to translations for this translator
  *
  * @param string $format The name of the loader (@see addLoader())
  * @param mixed $resource a name mostly related to the Loader (e.g. Filename for filelaoder)
  * @param string $locale locale of the resource
  * @param string $domain domain of the resource
  */
 public function addResource($format, $resource, $locale, $domain = null);

}
