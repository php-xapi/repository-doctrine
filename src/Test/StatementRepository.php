<?php

namespace XApi\Repository\Doctrine\Test;

use Doctrine\Common\Persistence\ObjectManager;
use Xabbuh\XApi\Model\Actor;
use Xabbuh\XApi\Model\Statement;
use Xabbuh\XApi\Model\StatementId;
use Xabbuh\XApi\Model\StatementsFilter;
use XApi\Repository\Api\StatementRepositoryInterface;

/**
 * Statement repository clearing the object manager between read and write operations.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class StatementRepository implements StatementRepositoryInterface
{
    private $repository;
    private $objectManager;

    public function __construct(StatementRepositoryInterface $repository, ObjectManager $objectManager)
    {
        $this->repository = $repository;
        $this->objectManager = $objectManager;
    }

    public function findStatementById(StatementId $statementId, Actor $authority = null)
    {
        $statement = $this->repository->findStatementById($statementId, $authority);
        $this->objectManager->clear();

        return $statement;
    }

    public function findVoidedStatementById(StatementId $voidedStatementId, Actor $authority = null)
    {
        $statement = $this->findVoidedStatementById($voidedStatementId, $authority);
        $this->objectManager->clear();

        return $statement;
    }

    public function findStatementsBy(StatementsFilter $criteria, Actor $authority = null)
    {
        $statements = $this->findStatementsBy($criteria, $authority);
        $this->objectManager->clear();

        return $statements;
    }

    public function storeStatement(Statement $statement, $flush = true)
    {
        $this->repository->storeStatement($statement);
        $this->objectManager->clear();
    }
}
