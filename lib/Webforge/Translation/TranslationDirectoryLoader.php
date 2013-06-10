<?php

namespace Webforge\Translation;

use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Finder\Finder;
use Webforge\Common\System\Dir;
use Webforge\Common\System\File;

/**
 * Loads message catalogues in format for the added loads from a dir
 * 
 * files in drectory can be organized into subdirs, but have to have the format:
 * 
 * domain.locale.loader
 * 
 * for example:
 * cms.de.php
 * 
 * loads the domain cms for locale de with the php (array) loader
 */
class TranslationDirectoryLoader {

 /**
  * Loaders used for import.
  *
  * @var array
  */
  protected $loaders = array();

 /**
  * Adds a type loader
  * 
  * @param string $format The name of the format of the loader
  * @param LoaderInterface $loader
  */
  public function addLoader($format, LoaderInterface $loader) {
    $this->loaders[$format] = $loader;
  }

 /**
  * Loads translation messages from a directory to a catalogue.
  *
  * @param string $directory the directory to look into
  * @param MessageCatalogue $catalogue the catalogue
  */
  public function loadMessages(Dir $directory, MessageCatalogue $catalogue) {
    foreach ($this->loaders as $format => $loader) {
      $finder = new Finder();
      $extension = $catalogue->getLocale().'.'.$format;
      $files = $finder->files()->name('*.'.$extension)->in((string) $directory);

      foreach ($files as $file) {
        $file = new File((string) $file);
        $domain = $file->getName(File::WITHOUT_EXTENSION);
        $catalogue->addCatalogue($loader->load((string) $file, $catalogue->getLocale(), $domain));
      }
    }
  }
}
