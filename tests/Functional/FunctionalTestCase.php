<?php

namespace Barryvanveen\CCA\Tests\Functional;

abstract class FunctionalTestCase extends \PHPUnit\Framework\TestCase implements FunctionalTestCaseInterface
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
