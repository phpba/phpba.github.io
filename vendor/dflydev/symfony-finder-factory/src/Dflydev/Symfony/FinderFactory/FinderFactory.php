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

use Symfony\Component\Finder\Finder;

/**
 * A simple implementation of FinderFactoryInterface.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class FinderFactory implements FinderFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createFinder()
    {
        return new Finder;
    }
}
