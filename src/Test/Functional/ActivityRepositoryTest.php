<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace XApi\Repository\Doctrine\Test\Functional;

use Doctrine\Common\Persistence\ObjectManager;
use Xabbuh\XApi\Model\IRI;
use XApi\Repository\Api\Test\Functional\ActivityRepositoryTest as BaseActivityRepositoryTest;
use XApi\Repository\Doctrine\Repository\ActivityRepository;
use XApi\Repository\Doctrine\Repository\Mapping\ObjectRepository as MappedObjectRepository;
use XApi\Repository\Doctrine\Test\ActivityRepository as FreshActivityRepository;

/**
 * @author Jérôme Parmentier <jerome.parmentier@acensi.fr>
 */
abstract class ActivityRepositoryTest extends BaseActivityRepositoryTest
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var MappedObjectRepository
     */
    protected $repository;

    protected function setUp()
    {
        $this->objectManager = $this->createObjectManager();
        $this->repository = $this->createRepository();

        parent::setUp();
    }

    protected function createActivityRepository()
    {
        return new FreshActivityRepository(new ActivityRepository($this->repository), $this->objectManager);
    }

    protected function cleanDatabase()
    {
        $this->objectManager->remove($this->repository->findObject(
            array(
                'type' => 'activity',
                'activityId' => IRI::fromString('http://tincanapi.com/conformancetest/activityid')->getValue(),
            )
        ));

        $this->objectManager->flush();
    }

    /**
     * @return ObjectManager
     */
    abstract protected function createObjectManager();

    /**
     * @return string
     */
    abstract protected function getActivityClassName();

    private function createRepository()
    {
        return $this->objectManager->getRepository($this->getActivityClassName());
    }
}
