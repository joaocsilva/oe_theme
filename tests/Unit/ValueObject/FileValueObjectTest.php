<?php

declare(strict_types = 1);

namespace Drupal\Tests\oe_theme\Unit\Patterns;

use Drupal\Core\Language\LanguageInterface;
use Drupal\oe_theme\ValueObject\FileValueObject;
use Drupal\Tests\UnitTestCase;
use Drupal\file\Entity\File;

/**
 * Test file value object.
 */
class FileValueObjectTest extends UnitTestCase {

  /**
   * Test constructing a file value object from an array.
   */
  public function testFromArray() {
    $data = [
      'size' => '123',
      'mime' => 'pdf',
      'name' => 'Test.pdf',
      'url' => 'http://example.com/test.pdf',
    ];

    /** @var \Drupal\oe_theme\ValueObject\FileValueObject $file */
    $file = FileValueObject::fromArray($data);

    $this->assertEquals('123', $file->size());
    $this->assertEquals('pdf', $file->mime());
    $this->assertEquals('http://example.com/test.pdf', $file->url());
    $this->assertEquals('Test.pdf', $file->name());
    $this->assertEquals('Test.pdf', $file->title());
    $this->assertEquals('pdf', $file->extension());
    $this->assertEquals('', $file->language_code());

    /** @var \Drupal\oe_theme\ValueObject\FileValueObject $file */
    $file = FileValueObject::fromArray($data)->withLanguageCode('fr');
    $this->assertEquals('fr', $file->language_code());
  }

  /**
   * Test constructing a file value object from a File entity object.
   */
  public function testFromFileEntity() {
    $language = $this->getMockBuilder(LanguageInterface::class)
      ->disableOriginalConstructor()
      ->allowMockingUnknownTypes()
      ->getMock();
    $language->expects($this->once())
      ->method('getId')
      ->willReturn('fr');

    $file_entity = $this->getMockBuilder(File::class)
      ->disableOriginalConstructor()
      ->allowMockingUnknownTypes()
      ->getMock();
    $file_entity->expects($this->once())
      ->method('getFileUri')
      ->willReturn('http://example.com/test.pdf');
    $file_entity->expects($this->once())
      ->method('getMimeType')
      ->willReturn('pdf');
    $file_entity->expects($this->once())
      ->method('getSize')
      ->willReturn('123');
    $file_entity->expects($this->once())
      ->method('getFilename')
      ->willReturn('Test.pdf');
    $file_entity->expects($this->once())
      ->method('language')
      ->willReturn($language);

    $file = FileValueObject::fromFileEntity($file_entity);

    $this->assertEquals('123', $file->size());
    $this->assertEquals('pdf', $file->mime());
    $this->assertEquals('http://example.com/test.pdf', $file->url());
    $this->assertEquals('Test.pdf', $file->name());
    $this->assertEquals('pdf', $file->extension());
    $this->assertEquals('fr', $file->language_code());
  }

}
