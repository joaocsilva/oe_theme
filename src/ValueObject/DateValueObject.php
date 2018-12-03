<?php

declare(strict_types = 1);

namespace Drupal\oe_theme\ValueObject;

use Drupal\Component\Datetime\DateTimePlus;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Handle information about a date.
 */
class DateValueObject extends ValueObjectBase implements DateValueObjectInterface {

  /**
   * DateValueObject constructor.
   *
   * @param string $day
   *   The date day.
   * @param string $month
   *   The date month.
   * @param string $year
   *   The date year.
   * @param string $variant
   *   The pattern variant.
   */
  private function __construct(string $day, string $month, string $year, string $variant = 'default') {
    $this->storage = compact([
      'day',
      'month',
      'year',
      'variant',
    ]);

    $date = new DateTimePlus(implode('-', [$year, $month, $day]));

    $this->storage['week_day'] = $date->format('l');
    $this->storage['monthname'] = $date->format('F');
  }

  /**
   * {@inheritdoc}
   */
  public static function fromTimestamp(string $timestamp): ValueObjectInterface {
    $parameters = explode(
      '-',
      DrupalDateTime::createFromTimestamp($timestamp)->format('d-m-Y')
    );

    return new static(...$parameters);
  }

  /**
   * {@inheritdoc}
   */
  public static function fromDateTimePlus(DateTimePlus $dateTimePlus): ValueObjectInterface {
    $parameters = explode(
      '-',
      $dateTimePlus->format('d-m-Y')
    );

    return new static(...$parameters);
  }

  /**
   * {@inheritdoc}
   */
  public static function fromArray(array $parameters = []): ValueObjectInterface {
    $parameters += ['variant' => 'default'];

    return new static(...array_values($parameters));
  }

  /**
   * {@inheritdoc}
   */
  public function withVariant(string $variant): DateValueObjectInterface {
    $clone = clone $this;
    $clone->storage['variant'] = $variant;

    return $clone;
  }

  /**
   * {@inheritdoc}
   */
  public function toArray(): array {
    return $this->storage;
  }

}
