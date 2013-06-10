<?php

namespace Webforge\Translation;

class ArrayTranslatorTest extends TranslationsTestCase {

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

  public function testTranslatorCanBeAddedAPhpFileResource() {
    $this->translator->addResource(
      'php', $this->getFile('translations/others.en.php'), 'de', 'others'
    );

    $this->assertTestTranslation('others', 'en');
  }

  public function testCanGetResourceDirectoryAdded_WhereResourcesAreLoadedFromFiles_WithDomains() {
    $this->translator->addResourceDirectory(
      $this->getTestDirectory('translations/')
    );

    $this->assertTestTranslation('messages', 'de');
    $this->assertTestTranslation('messages', 'en');
    $this->assertTestTranslation('others', 'de');
    $this->assertTestTranslation('others', 'en');
  }

  protected function assertTestTranslation($domain, $locale) {
    $this->assertEquals(
      'content: '.'test.'.$domain.'-'.$locale,
      $this->translator->trans('test.'.$domain.'-'.$locale, array(), $domain),
      'the key: "test.'.$domain.'-'.$locale.'" is not loaded correctly'
    );
  }
}
