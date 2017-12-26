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
 * Interface for creating new instances of Finder
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface FinderFactoryInterface
{
    /**
     * Create Finder instance
     *
     * @return Finder
     */
    public function createFinder();
}
