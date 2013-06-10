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
}
