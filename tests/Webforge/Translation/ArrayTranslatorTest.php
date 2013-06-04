<?php

namespace Webforge\Translation;

class ArrayTranslatorTest extends \Webforge\Code\Test\Base {

  protected $translationsDe = Array(
    'cms.hello'=>'Willkommen im CMS',
    'test.fallback-de' => 'de-fallback text'
  );

  protected $translationsEn = Array(
    'cms.hello' => 'Welcome to the CMS',
    'test.fallback-en' => 'en-fallback text'
  );
  
  public function setUp() {
    $this->chainClass = 'Webforge\\Translation\\ArrayTranslator';
    parent::setUp();

    $this->translator = new ArrayTranslator(
      'de_DE',
      array(
        'de'=>$this->translationsDe,
        'en'=>$this->translationsEn
      )
    );
  }

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

  public static function provideTranslationsDe() {
    $tests = array();
  
    $test = function() use (&$tests) {
      $tests[] = func_get_args();
    };
  
    $test('cms.hello', 'Willkommen im CMS');

  
    return $tests;
  }

  public static function provideTranslationsEn() {
    $tests = array();
  
    $test = function() use (&$tests) {
      $tests[] = func_get_args();
    };
  
    $test('cms.hello', 'Welcome to the CMS');
    $test('test.fallback-en', 'en-fallback text');
  
    return $tests;
  }
}
