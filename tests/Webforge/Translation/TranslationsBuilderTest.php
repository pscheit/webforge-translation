<?php

namespace Webforge\Translation;

class TranslationsBuilderTest extends \Webforge\Code\Test\Base {
  
  public function setUp() {
    $this->chainClass = 'Webforge\\Translation\\TranslationsBuilder';
    parent::setUp();
  }

  public function testBuildsAnInternationalizedArrayForTheTranslator() {

    $translations = TranslationsBuilder::create('mydomain')
      ->locale('de')
        ->trans('ui.save', 'speichern')
        ->trans('ui.reload', 'neu laden')

      ->locale('en')
        ->trans('ui.save', 'save')
        ->trans('ui.reload', 'reload now')

      ->locale('fr')
        ->trans('ui.save', 'enregistrer')
        ->trans('ui.reload', 'actualiser')

      ->build()
    ;

    $this->assertEquals(
      Array(
        'de'=>array(
          'ui.save'=>'speichern',
          'ui.reload'=>'neu laden'
        ),
        'en'=>array(
          'ui.save'=>'save',
          'ui.reload'=>'reload now'
        ),
        'fr'=>array(
          'ui.save'=>'enregistrer',
          'ui.reload'=>'actualiser'
        )
      ),
      $translations
    );
  }

  public function testBuildsAnInternationalizedArrayForTheTranslatorOtherSyntax() {
    $translations = TranslationsBuilder::create('mydomain')
      ->locales('de', 'en', 'fr')
        ->trans('ui.save', 'speichern', 'save', 'enregistrer')
        ->trans('ui.reload', 'neu laden', 'reload now', 'actualiser')

      ->build()
    ;

    $this->assertEquals(
      Array(
        'de'=>array(
          'ui.save'=>'speichern',
          'ui.reload'=>'neu laden'
        ),
        'en'=>array(
          'ui.save'=>'save',
          'ui.reload'=>'reload now'
        ),
        'fr'=>array(
          'ui.save'=>'enregistrer',
          'ui.reload'=>'actualiser'
        )
      ),
      $translations
    );
  }

  public function testTransMustBeSet() {
    $this->setExpectedException('LogicException');

    TranslationsBuilder::create()->trans('xx', 'yyy');
  }
}
