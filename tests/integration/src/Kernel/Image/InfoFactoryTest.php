<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\InfoFactory;
use Picamator\SteganographyKit2\Kernel\Image\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;

class InfoFactoryTest extends BaseTest
{
    /**
     * @var InfoFactory
     */
    private $infoFactory;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var SizeFactory
     */
    private $sizeFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManager = new ObjectManager();

        $this->sizeFactory = new SizeFactory($this->objectManager);

        $this->infoFactory = new InfoFactory($this->objectManager, $this->sizeFactory);
    }

    /**
     * @dataProvider providerCreate
     *
     * @param string $path
     */
    public function testCreate(string $path)
    {
        $path = $this->getPath($path);
        $info = $this->infoFactory->create($path);

        $this->assertNotEmpty($info->getSize()->getWidth());
        $this->assertNotEmpty($info->getSize()->getHeight());
    }

    public function providerCreate()
    {
        return [
            ['secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg']
        ];
    }
}
