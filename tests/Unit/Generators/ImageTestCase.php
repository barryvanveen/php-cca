<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Generators;

abstract class ImageTestCase extends \PHPUnit\Framework\TestCase implements ImageTestCaseInterface
{
    public function setUp()
    {
        parent::setUp();

        if (file_exists($this->getImageFilename())) {
            unlink($this->getImageFilename());
        }
    }

    public function tearDown()
    {
        if (file_exists($this->getImageFilename())) {
            unlink($this->getImageFilename());
        }

        parent::tearDown();
    }
}
