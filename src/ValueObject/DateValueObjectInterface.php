<?php

declare(strict_types = 1);

namespace Drupal\oe_theme\ValueObject;

use Drupal\Component\Datetime\DateTimePlus;

/**
 * Interface DateValueObjectInterface.
 */
interface DateValueObjectInterface extends ValueObjectInterface {

  /**
   * Create an object from a timestamp.
   *
   * @param string $timestamp
   *   The timestamp.
   *
   * @return \Drupal\oe_theme\ValueObject\ValueObjectInterface
   *   Return a new ValueObjectInterface.
   */
  public static function fromTimestamp(string $timestamp): ValueObjectInterface;

  /**
   * Create an object from a DateTimePlus object.
   *
   * @param \Drupal\Component\Datetime\DateTimePlus $dateTimePlus
   *   The DateTimePlus object.
   *
   * @return \Drupal\oe_theme\ValueObject\ValueObjectInterface
   *   Return a new ValueObjectInterface.
   */
  public static function fromDateTimePlus(DateTimePlus $dateTimePlus): ValueObjectInterface;

  /**
   * Create an object from an array.
   *
   * @param array $values
   *   The array.
   *
   * @return DateValueObjectInterface
   *   Return a new DateValueObjectInterface.
   */
  public static function fromArray(array $values = []): ValueObjectInterface;

  /**
   * Create a new object having a variant.
   *
   * @param string $variant
   *   The variant.
   *
   * @return \Drupal\oe_theme\ValueObject\DateValueObjectInterface
   *   Return a new DateValueObjectInterface.
   */
  public function withVariant(string $variant): DateValueObjectInterface;

  /**
   * {@inheritdoc}
   */
  public function toArray() : array;

}
