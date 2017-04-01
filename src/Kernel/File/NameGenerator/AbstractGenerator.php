<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\File\NameGenerator;

use Picamator\SteganographyKit2\Kernel\File\Api\NameGeneratorInterface;

/**
 * Abstract strategy to generate file name
 *
 * @package Kernel\File
 */
abstract class AbstractGenerator implements NameGeneratorInterface
{
   /**
    * @inheritDoc
    */
   final public function generate(string $sourceName, string $extension): string
   {
       $sourceName = pathinfo($sourceName, PATHINFO_FILENAME);
       $name = $this->getFileName($sourceName) . '.'. $extension;

       return $name;
   }

    /**
     * Gets file name
     *
     * @param string $sourceName
     *
     * @return string
     */
    abstract protected function getFileName(string $sourceName) : string;
}
