<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2\Kernel\Facade;

use Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Kernel\File\Api\DependencyProviderInterface;
use Picamator\SteganographyKit2\Kernel\File\Builder\InfoFactory;
use Picamator\SteganographyKit2\Kernel\File\Builder\InfoPaletteFactory;
use Picamator\SteganographyKit2\Kernel\File\Builder\WritablePathFactory;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\PrefixTime;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\SourceIdentical;
use Picamator\SteganographyKit2\Kernel\File\Resource\ResourceFactory;
use Picamator\SteganographyKit2\Kernel\Image\Converter\BinaryToImage;
use Picamator\SteganographyKit2\Kernel\Image\Converter\ImageToBinary;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegFile;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegString;
use Picamator\SteganographyKit2\Kernel\Image\Export\PngFile;
use Picamator\SteganographyKit2\Kernel\Image\Export\PngString;
use Picamator\SteganographyKit2\Kernel\Image\ImageFactory;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialIteratorFactory as ImageSerialIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialNullIteratorFactory as ImageSerialNullIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ChannelFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Pixel\Data\NullColor;
use Picamator\SteganographyKit2\Kernel\Pixel\Iterator\SerialIteratorFactory as PixelSerialIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\PixelFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\RepositoryFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\PointFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;
use Picamator\SteganographyKit2\Kernel\Text\Builder\AsciiFactory;
use Picamator\SteganographyKit2\Kernel\Text\Filter\Base64decodeFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\Base64encodeFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\BinaryToTextFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\TextToBinaryFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\ZipCompressFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\ZipDecompressFilter;
use Picamator\SteganographyKit2\Kernel\Text\FilterManager;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;
use Pimple;

/**
 * Dependency provider based on Pimple
 *
 * Class type
 * ----------
 * Extendable service.
 *
 * Responsibility
 * --------------
 * Fill dependency container with predefined objects.
 *
 * State
 * -----
 * * Pimple container
 *
 * Immutability
 * ------------
 * Object is immutable.
 *
 * Dependency injection
 * --------------------
 * Extend only
 *
 * @see https://github.com/silexphp/Pimple/tree/1.1
 *
 * @package Kernel\Facade
 */
abstract class AbstractDependencyProvider implements DependencyProviderInterface
{
    // util
    const UTIL_OBJECT_MANAGER = 'UTIL_OBJECT_MANAGER';

    // primitive
    const PRIMITIVE_BYTE_FACTORY = 'PRIMITIVE_BYTE_FACTORY';
    const PRIMITIVE_POINT_FACTORY = 'PRIMITIVE_POINT_FACTORY';
    const PRIMITIVE_SIZE_FACTORY = 'PRIMITIVE_SIZE_FACTORY';
    const PRIMITIVE_NULL_BYTE = 'PRIMITIVE_NULL_BYTE';

    // file
    const FILE_INFO_FACTORY = 'FILE_INFO_FACTORY';
    const FILE_INFO_PALETTE_FACTORY = 'FILE_INFO_PALETTE_FACTORY';
    const FILE_WRITABLE_PATH_FACTORY = 'FILE_WRITABLE_PATH_FACTORY';
    const FILE_EXPORT_PATH = 'FILE_EXPORT_PATH';
    const FILE_NAME_GENERATOR_PREFIX_TIME = 'FILE_NAME_GENERATOR_PREFIX_TIME';
    const FILE_NAME_GENERATOR_SOURCE_IDENTICAL = 'FILE_NAME_GENERATOR_SOURCE_IDENTICAL';
    const FILE_NAME_GENERATOR = self::FILE_NAME_GENERATOR_PREFIX_TIME; // prefix time
    const FILE_RESOURCE_PALETTE_FACTORY = 'FILE_RESOURCE_PALETTE_FACTORY';
    const FILE_RESOURCE_PNG_FACTORY = 'FILE_RESOURCE_PNG_FACTORY';
    const FILE_RESOURCE_JPEG_FACTORY = 'FILE_RESOURCE_JPEG_FACTORY';

    // pixel
    const PIXEL_CHANNEL_FACTORY = 'PIXEL_CHANNEL_FACTORY';
    const PIXEL_COLOR_FACTORY = 'PIXEL_COLOR_FACTORY';
    const PIXEL_COLOR_INDEX = 'PIXEL_COLOR_INDEX';
    const PIXEL_NULL_COLOR = 'PIXEL_NULL_COLOR';
    const PIXEL_CHANNEL = 'PIXEL_CHANNEL'; // rgb
    const PIXEL_ITERATOR_FACTORY = 'PIXEL_ITERATOR_FACTORY';
    const PIXEL_FACTORY = 'PIXEL_FACTORY'; // serial iterator
    const PIXEL_REPOSITORY_FACTORY = 'PIXEL_REPOSITORY_FACTORY';

    // image
    const IMAGE_ITERATOR_FACTORY = 'IMAGE_ITERATOR_SERIAL_FACTORY'; // serial iterator
    const IMAGE_ITERATOR_NULL_FACTORY = 'IMAGE_ITERATOR_NULL_FACTORY';
    const IMAGE_PALETTE_FACTORY = 'IMAGE_PALETTE_FACTORY';
    const IMAGE_PNG_FACTORY = 'IMAGE_PNG_FACTORY';
    const IMAGE_JPEG_FACTORY = 'IMAGE_JPEG_FACTORY';
    const IMAGE_CONVERTER_BINARY_TO_JPEG = 'IMAGE_CONVERTER_BINARY_TO_JPEG';
    const IMAGE_CONVERTER_BINARY_TO_PNG = 'IMAGE_CONVERTER_BINARY_TO_PNG';
    const IMAGE_CONVERTER_IMAGE_TO_BINARY = 'IMAGE_CONVERTER_IMAGE_TO_BINARY';
    const IMAGE_EXPORT_JPEG_FILE = 'IMAGE_EXPORT_JPEG_FILE';
    const IMAGE_EXPORT_JPEG_STRING = 'IMAGE_EXPORT_JPEG_STRING';
    const IMAGE_EXPORT_PNG_FILE = 'IMAGE_EXPORT_PNG_FILE';
    const IMAGE_EXPORT_PNG_STRING = 'IMAGE_EXPORT_PNG_STRING';

    // text
    const TEXT_ASCII_FACTORY = 'TEXT_ASCII_FACTORY';
    const TEXT_FILTER_BASE_64_DECODE = 'TEXT_FILTER_BASE_64_DECODE';
    const TEXT_FILTER_BASE_64_ENCODE = 'TEXT_FILTER_BASE_64_ENCODE';
    const TEXT_FILTER_BINARY_TO_TEXT = 'TEXT_FILTER_BINARY_TO_TEXT';
    const TEXT_FILTER_TEXT_TO_BINARY = 'TEXT_FILTER_TEXT_TO_BINARY';
    const TEXT_FILTER_ZIP_COMPRESS = 'TEXT_FILTER_ZIP_COMPRESS';
    const TEXT_FILTER_ZIP_DECOMPRESS = 'TEXT_FILTER_ZIP_DECOMPRESS';
    const TEXT_FILTER_MANAGER_ENCODE = 'TEXT_FILTER_MANAGER_ENCODE';
    const TEXT_FILTER_MANAGER_DECODE = 'TEXT_FILTER_MANAGER_DECODE';

    /**
     * @var Pimple
     */
    private $container;

    public function __construct()
    {
        $this->container = new Pimple();

        $this->registryDefaultDependency();
        $this->registryDependency();
    }

    /**
     * @inheritDoc
     */
    public function getProvidedDependency(string $name)
    {
        try {

            return $this->container[$name];

        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException(
                sprintf('Fail retrieve data "%s" from container', $name), 0, $e
            );
        }
    }

    /**
     * @return Pimple
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * Registry default dependency
     *
     * @return void
     */
    private function registryDefaultDependency()
    {
        // util
        $this->container[static::UTIL_OBJECT_MANAGER] = $this->container->share(function () {
            return new ObjectManager();
        });

        // primitive
        $this->container[static::PRIMITIVE_BYTE_FACTORY] = $this->container->share(function ($c) {
            return new ByteFactory($c[static::UTIL_OBJECT_MANAGER]);
        });

        $this->container[static::PRIMITIVE_POINT_FACTORY] = $this->container->share(function ($c) {
            return new PointFactory($c[static::UTIL_OBJECT_MANAGER]);
        });

        $this->container[static::PRIMITIVE_SIZE_FACTORY] = $this->container->share(function ($c) {
            return new SizeFactory($c[static::UTIL_OBJECT_MANAGER]);
        });

        $this->container[static::PRIMITIVE_NULL_BYTE] = $this->container->share(function () {
            return new NullByte();
        });

        // file
        $this->container[static::FILE_INFO_FACTORY] = $this->container->share(function ($c) {
            return new InfoFactory($c[static::UTIL_OBJECT_MANAGER], $c[static::PRIMITIVE_SIZE_FACTORY]);
        });

        $this->container[static::FILE_INFO_PALETTE_FACTORY] = $this->container->share(function ($c) {
            return new InfoPaletteFactory($c[static::UTIL_OBJECT_MANAGER]);
        });

        $this->container[static::FILE_WRITABLE_PATH_FACTORY] = $this->container->share(function ($c) {
            return new WritablePathFactory($c[static::UTIL_OBJECT_MANAGER]);
        });

        $this->container[static::FILE_EXPORT_PATH] = $this->container->share(function ($c) {
            return $c[static::FILE_WRITABLE_PATH_FACTORY]->create($this->getExportPath());
        });

        $this->container[static::FILE_NAME_GENERATOR_PREFIX_TIME] = $this->container->share(function () {
            return new PrefixTime();
        });

        $this->container[static::FILE_NAME_GENERATOR_SOURCE_IDENTICAL] = $this->container->share(function () {
            return new SourceIdentical();
        });

        $this->container[static::FILE_RESOURCE_PALETTE_FACTORY] = $this->container->share(function ($c) {
            return new ResourceFactory($c[static::UTIL_OBJECT_MANAGER]);
        });

        $this->container[static::FILE_RESOURCE_JPEG_FACTORY] = $this->container->share(function ($c) {
            return new ResourceFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                'Picamator\SteganographyKit2\Kernel\File\Resource\JpegResource'
            );
        });

        $this->container[static::FILE_RESOURCE_PNG_FACTORY] = $this->container->share(function ($c) {
            return new ResourceFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                'Picamator\SteganographyKit2\Kernel\File\Resource\PngResource'
            );
        });

        // pixel
        $this->container[static::PIXEL_CHANNEL_FACTORY] = $this->container->share(function ($c) {
            return new ChannelFactory($c[static::UTIL_OBJECT_MANAGER]);
        });

        $this->container[static::PIXEL_COLOR_FACTORY] = $this->container->share(function ($c) {
            return new ColorFactory($c[static::UTIL_OBJECT_MANAGER], $c[static::PRIMITIVE_NULL_BYTE]);
        });

        $this->container[static::PIXEL_COLOR_INDEX] = $this->container->share(function ($c) {
            return new ColorIndex($c[static::PRIMITIVE_BYTE_FACTORY], $c[static::PIXEL_COLOR_FACTORY]);
        });

        $this->container[static::PIXEL_NULL_COLOR] = $this->container->share(function ($c) {
            return new NullColor();
        });

        $this->container[static::PIXEL_CHANNEL] = $this->container->share(function ($c) {
            return $c[static::PIXEL_CHANNEL_FACTORY]->create();
        });

        $this->container[static::PIXEL_ITERATOR_FACTORY] = $this->container->share(function ($c) {
            return new PixelSerialIteratorFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                $c[static::PIXEL_CHANNEL]
            );
        });

        $this->container[static::PIXEL_FACTORY] = $this->container->share(function ($c) {
            return new PixelFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                $c[static::PIXEL_NULL_COLOR],
                $c[static::PIXEL_ITERATOR_FACTORY]
            );
        });

        $this->container[static::PIXEL_REPOSITORY_FACTORY] = $this->container->share(function ($c) {
            return new RepositoryFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                $c[static::PIXEL_COLOR_INDEX],
                $c[static::PIXEL_COLOR_FACTORY],
                $c[static::PIXEL_FACTORY]
            );
        });

        // image
        $this->container[static::IMAGE_ITERATOR_FACTORY] = $this->container->share(function ($c) {
            return new ImageSerialIteratorFactory($c[static::UTIL_OBJECT_MANAGER], $c[static::PRIMITIVE_POINT_FACTORY]);
        });

        $this->container[static::IMAGE_ITERATOR_NULL_FACTORY] = $this->container->share(function ($c) {
            return new ImageSerialNullIteratorFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                $c[static::PRIMITIVE_POINT_FACTORY],
                $c[static::PIXEL_FACTORY]
            );
        });

        $this->container[static::IMAGE_PALETTE_FACTORY] = $this->container->share(function ($c) {
            return new ImageFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                $c[static::FILE_RESOURCE_PALETTE_FACTORY],
                $c[static::PIXEL_REPOSITORY_FACTORY],
                $c[static::IMAGE_ITERATOR_NULL_FACTORY]
            );
        });

        $this->container[static::IMAGE_PNG_FACTORY] = $this->container->share(function ($c) {
            return new ImageFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                $c[static::FILE_RESOURCE_PNG_FACTORY],
                $c[static::PIXEL_REPOSITORY_FACTORY],
                $c[static::IMAGE_ITERATOR_FACTORY]
            );
        });

        $this->container[static::IMAGE_JPEG_FACTORY] = $this->container->share(function ($c) {
            return new ImageFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                $c[static::FILE_RESOURCE_JPEG_FACTORY],
                $c[static::PIXEL_REPOSITORY_FACTORY],
                $c[static::IMAGE_ITERATOR_FACTORY]
            );
        });

        $this->container[static::IMAGE_CONVERTER_BINARY_TO_JPEG] = $this->container->share(function ($c) {
            return new BinaryToImage(
                $c[static::PIXEL_CHANNEL],
                $c[static::PRIMITIVE_BYTE_FACTORY],
                $c[static::PIXEL_COLOR_FACTORY],
                $c[static::FILE_INFO_FACTORY],
                $c[static::IMAGE_JPEG_FACTORY]
            );
        });

        $this->container[static::IMAGE_CONVERTER_IMAGE_TO_BINARY] = $this->container->share(function ($c) {
            return new ImageToBinary($c[static::PIXEL_CHANNEL]);
        });

        $this->container[static::IMAGE_EXPORT_JPEG_FILE] = $this->container->share(function ($c) {
            return new JpegFile($c[static::FILE_EXPORT_PATH], $c[static::FILE_NAME_GENERATOR]);
        });

        $this->container[static::IMAGE_EXPORT_JPEG_STRING] = $this->container->share(function () {
            return new JpegString();
        });

        $this->container[static::IMAGE_EXPORT_PNG_FILE] = $this->container->share(function ($c) {
            return new PngFile($c[static::FILE_EXPORT_PATH], $c[static::FILE_NAME_GENERATOR]);
        });

        $this->container[static::IMAGE_EXPORT_PNG_STRING] = $this->container->share(function () {
            return new PngString();
        });

        // text
        $this->container[static::TEXT_ASCII_FACTORY] = $this->container->share(function ($c) {
            return new AsciiFactory(
                $c[static::UTIL_OBJECT_MANAGER],
                $c[static::PRIMITIVE_BYTE_FACTORY]
            );
        });

        $this->container[static::TEXT_FILTER_BASE_64_DECODE] = $this->container->share(function () {
            return new Base64decodeFilter();
        });

        $this->container[static::TEXT_FILTER_BASE_64_ENCODE] = $this->container->share(function () {
            return new Base64encodeFilter();
        });

        $this->container[static::TEXT_FILTER_BINARY_TO_TEXT] = $this->container->share(function () {
            return new BinaryToTextFilter();
        });

        $this->container[static::TEXT_FILTER_TEXT_TO_BINARY] = $this->container->share(function ($c) {
            return new TextToBinaryFilter($c[static::TEXT_ASCII_FACTORY]);
        });

        $this->container[static::TEXT_FILTER_ZIP_COMPRESS] = $this->container->share(function () {
            return new ZipCompressFilter();
        });

        $this->container[static::TEXT_FILTER_ZIP_DECOMPRESS] = $this->container->share(function () {
            return new ZipDecompressFilter();
        });

        $this->container[static::TEXT_FILTER_MANAGER_ENCODE] = $this->container->share(function () {
            return new FilterManager();
        });

        $this->container[static::TEXT_FILTER_MANAGER_DECODE] = $this->container->share(function () {
            return new FilterManager();
        });
    }

    /**
     * Gets export path
     *
     * @return string
     */
    protected function getExportPath()
    {
        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'steganography-kit2' ;
    }

    /**
     * @return void
     */
    abstract protected function registryDependency();
}
