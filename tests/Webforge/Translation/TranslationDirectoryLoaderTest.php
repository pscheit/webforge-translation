<?php

namespace Webforge\Translation;

use Symfony\Component\Translation\MessageCatalogue;

class TranslationDirectoryLoaderTest extends \Webforge\Code\Test\Base {

  protected $dirLoader, $loader, $dir, $deCatalogue, $enCatalogue;
  
  public function setUp() {
    $this->chainClass = 'Webforge\\Translation\\TranslationDirectoryLoader';
    parent::setUp();

    $this->loader = $this->getMockForAbstractClass('Symfony\Component\Translation\Loader\LoaderInterface');

    $this->deCatalogue = new MessageCatalogue('de', array());
    $this->enCatalogue = new MessageCatalogue('en', array());

    $this->dirLoader = new TranslationDirectoryLoader();
    $this->dirLoader->addLoader('php', $this->loader);

    $this->dir = $this->getTestDirectory('translations/');
  }

  public function testReadsWithPHPLoaderFromDirectoryForDECatalogue() {
    $this->loader->expects($this->exactly(2))->method('load')
      ->with($this->logicalOr(
        $this->equalTo($this->dir->getFile('messages.de.php')),
        $this->equalTo($this->dir->getFile('others.de.php'))
      ))
      ->will($this->returnValue(new MessageCatalogue('de')))
    ;

    $this->dirLoader->loadMessages($this->dir, $this->deCatalogue);
  }

  public function testReadsWithPHPLoaderFromDirectoryForENCatalogue() {
    $this->loader->expects($this->exactly(2))->method('load')
      ->with($this->logicalOr(
        $this->equalTo($this->dir->getFile('messages.en.php')),
        $this->equalTo($this->dir->getFile('others.en.php'))
      ))
      ->will($this->returnValue(new MessageCatalogue('en')))
    ;

    $this->dirLoader->loadMessages($this->dir, $this->enCatalogue);
  }
}
