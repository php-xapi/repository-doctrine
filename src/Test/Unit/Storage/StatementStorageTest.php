<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace XApi\Repository\Doctrine\Test\Unit\Storage;

use PHPUnit\Framework\TestCase;
use Xabbuh\XApi\DataFixtures\StatementFixtures;
use XApi\Repository\Doctrine\Mapping\Statement;
use XApi\Repository\Doctrine\Storage\StatementStorage;

/**
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
abstract class StatementStorageTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $unitOfWork;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $classMetadata;

    /**
     * @var StatementStorage
     */
    private $storage;

    protected function setUp()
    {
        $this->objectManager = $this->createObjectManagerMock();
        $this->unitOfWork = $this->createUnitOfWorkMock();
        $this->classMetadata = $this->createClassMetadataMock();
        $this->storage = $this->createStatementStorage($this->objectManager, $this->unitOfWork, $this->classMetadata);
    }

    public function testStatementDocumentIsPersisted()
    {
        $this
            ->objectManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf('\XApi\Repository\Doctrine\Mapping\Statement'))
        ;

        $mappedStatement = Statement::fromModel(StatementFixtures::getMinimalStatement());
        $this->storage->storeStatement($mappedStatement, true);
    }

    public function testFlushIsCalledByDefault()
    {
        $this
            ->objectManager
            ->expects($this->once())
            ->method('flush')
        ;

        $mappedStatement = Statement::fromModel(StatementFixtures::getMinimalStatement());
        $this->storage->storeStatement($mappedStatement);
    }

    public function testCallToFlushCanBeSuppressed()
    {
        $this
            ->objectManager
            ->expects($this->never())
            ->method('flush')
        ;

        $mappedStatement = Statement::fromModel(StatementFixtures::getMinimalStatement());
        $this->storage->storeStatement($mappedStatement, false);
    }

    abstract protected function getObjectManagerClass();

    protected function createObjectManagerMock()
    {
        return $this
            ->getMockBuilder($this->getObjectManagerClass())
            ->disableOriginalConstructor()
            ->getMock();
    }

    abstract protected function getUnitOfWorkClass();

    protected function createUnitOfWorkMock()
    {
        return $this
            ->getMockBuilder($this->getUnitOfWorkClass())
            ->disableOriginalConstructor()
            ->getMock();
    }

    abstract protected function getClassMetadataClass();

    protected function createClassMetadataMock()
    {
        return $this
            ->getMockBuilder($this->getClassMetadataClass())
            ->disableOriginalConstructor()
            ->getMock();
    }

    abstract protected function createStatementStorage($objectManager, $unitOfWork, $classMetadata);
}
