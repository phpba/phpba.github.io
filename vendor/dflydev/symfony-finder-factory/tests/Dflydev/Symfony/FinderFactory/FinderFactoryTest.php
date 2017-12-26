<?php

/*
 * This file is part of the dflydev/symfony-finder-factory.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Symfony\FinderFactory;

/**
 * Test Finder Factory
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class FinderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test createFinder() method
     */
    public function testCreateFinder()
    {
        $finderFactory = new FinderFactory;

        $this->assertInstanceOf('Symfony\Component\Finder\Finder', $finderFactory->createFinder());
    }
}
