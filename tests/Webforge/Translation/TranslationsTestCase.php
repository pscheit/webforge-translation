<?php

namespace Webforge\Translation;

class TranslationsTestCase extends \Webforge\Code\Test\Base {

  protected $translationsDe = Array(
    'cms.hello'=>'Willkommen im CMS',
    'test.fallback-de' => 'de-fallback text'
  );

  protected $translationsEn = Array(
    'cms.hello' => 'Welcome to the CMS',
    'test.fallback-en' => 'en-fallback text'
  );
  
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
