<?php

namespace Barryvanveen\CCA\Tests;

use Barryvanveen\CCA\Coordinate;

class CoordinateTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function it_returns_the_row()
    {
        $coordinate = new Coordinate(1, 2, 10);

        $this->assertEquals(1, $coordinate->row());
    }

    /**
     * @test
     */
    public function it_returns_the_column()
    {
        $coordinate = new Coordinate(1, 2, 10);

        $this->assertEquals(2, $coordinate->column());
    }

    /**
     * @test
     */
    public function it_returns_the_position()
    {
        $coordinate = new Coordinate(0, 0, 10);
        $this->assertEquals(0, $coordinate->position());

        $coordinate = new Coordinate(0, 1, 10);
        $this->assertEquals(1, $coordinate->position());

        $coordinate = new Coordinate(1, 0, 10);
        $this->assertEquals(10, $coordinate->position());

        $coordinate = new Coordinate(1, 1, 10);
        $this->assertEquals(11, $coordinate->position());
    }

    /**
     * @test
     */
    public function it_returns_a_string_representation()
    {
        $coordinate = new Coordinate(1, 2, 10);

        $this->assertEquals("1, 2", $coordinate->__toString());
    }
}
