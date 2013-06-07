<?php

namespace Webforge\Translation;

class ResourceTranslatorTest extends TranslationsTestCase {

  public function setUp() {
    $this->chainClass = 'Webforge\\Translation\\ResourceTranslator';
    parent::setUp();

    $this->translator = new ResourceTranslator(
      'de_DE',
      array(
        'de'=>$this->translationsDe,
        'en'=>$this->translationsEn
      )
    );

  /**
   * @dataProvider provideTranslationsDe
   */
  public function testTranslatortranslatesAKeyDE($key, $expectedText) {
    $this->assertEquals(
      $expectedText,
      $this->translator->trans($key)
    );
  }

  /**
   * @dataProvider provideTranslationsEn
   */
  public function testTranslatortranslatesAKeyEN($key, $expectedText) {
    $this->translator->setLocale('en');
    $this->assertEquals(
      $expectedText,
      $this->translator->trans($key)
    );
  }

  public function testTranslatesWithFallback() {
    $this->assertEquals(
      'en-fallback text',
      $this->translator->trans('test.fallback-en')
    );
  }

  public function testTranslatesIntoChangedFallbackLocalesAndLocale() {
    $this->translator->setFallbackLocales(array('de'));
    $this->translator->setLocale('en_EN');

    $this->assertEquals(
      'de-fallback text',
      $this->translator->trans('test.fallback-de')
    );
  }

  public function testCanGetAnotherResourceAdded() {

  }
}
