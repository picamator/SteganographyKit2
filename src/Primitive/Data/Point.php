<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Primitive\Data;

use Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface;
use Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface;

/**
 * Point value object
 *
 * @codeCoverageIgnore
 */
class Point implements PointInterface
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @param OptionsResolverInterface $optionsResolver
     * @param array $options
     */
    public function __construct(OptionsResolverInterface $optionsResolver, array $options)
    {
        $optionsResolver
            ->setDefined('x')
            ->setRequired('x')
            ->setAllowedType('x', 'int')
            ->setDefined('y')
            ->setRequired('y')
            ->setAllowedType('y', 'int')
            ->resolve($options);

        $this->x = $optionsResolver->getValue('x');
        $this->y = $optionsResolver->getValue('y');
    }

    /**
     * @inheritDoc
     */
    public function getX() : int
    {
        return $this->x;
    }

    /**
     * @inheritDoc
     */
    public function getY() : int
    {
       return $this->y;
    }
}
