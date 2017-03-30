<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace XApi\Repository\Doctrine\Tests\Unit\Repository;

use PHPUnit\Framework\TestCase;
use Xabbuh\XApi\DataFixtures\ActivityFixtures;
use Xabbuh\XApi\Model\IRI;
use XApi\Repository\Doctrine\Mapping\Object as MappedObject;
use XApi\Repository\Doctrine\Repository\ActivityRepository;
use XApi\Repository\Doctrine\Storage\ObjectStorage;

/**
 * @author Jérôme Parmentier <jerome.parmentier@acensi.fr>
 */
class ActivityRepositoryTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ObjectStorage
     */
    private $mappedStatementRepository;

    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    protected function setUp()
    {
        $this->mappedStatementRepository = $this->createObjectStorageMock();
        $this->activityRepository = new ActivityRepository($this->mappedStatementRepository);
    }

    public function testFindActivityById()
    {
        $activityId = IRI::fromString('http://tincanapi.com/conformancetest/activityid');

        $this
            ->mappedStatementRepository
            ->expects($this->once())
            ->method('findObject')
            ->with(array(
                'type' => 'activity',
                'activityId' => $activityId->getValue(),
            ))
            ->will($this->returnValue(MappedObject::fromModel(ActivityFixtures::getIdActivity())));

        $this->activityRepository->findActivityById($activityId);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ObjectStorage
     */
    protected function createObjectStorageMock()
    {
        return $this
            ->getMockBuilder('\XApi\Repository\Doctrine\Storage\ObjectStorage')
            ->getMock();
    }
}
