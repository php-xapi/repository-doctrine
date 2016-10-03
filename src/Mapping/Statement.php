<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace XApi\Repository\Doctrine\Mapping;

use Xabbuh\XApi\Model\Actor;
use Xabbuh\XApi\Model\Result;
use Xabbuh\XApi\Model\Statement as StatementModel;
use Xabbuh\XApi\Model\StatementId;

/**
 * A {@link Statement} mapped to a storage backend.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
class Statement
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var Actor
     */
    public $actor;

    /**
     * @var Verb
     */
    public $verb;

    /**
     * @var \Xabbuh\XApi\Model\Object
     */
    public $object;

    /**
     * @var Result
     */
    public $result;

    /**
     * @var Actor
     */
    public $authority;

    /**
     * @var \DateTime
     */
    public $created;

    /**
     * @var \DateTime
     */
    public $stored;

    public function getModel()
    {
        return new StatementModel(StatementId::fromString($this->id), $this->actor, $this->verb->getModel(), $this->object, $this->result, $this->authority, $this->created, $this->stored);
    }

    public static function fromModel(StatementModel $statement)
    {
        $mappedStatement = new self();
        $mappedStatement->id = $statement->getId()->getValue();
        $mappedStatement->actor = $statement->getActor();
        $mappedStatement->verb = Verb::fromModel($statement->getVerb());
        $mappedStatement->object = $statement->getObject();
        $mappedStatement->result = $statement->getResult();
        $mappedStatement->authority = $statement->getAuthority();
        $mappedStatement->created = $statement->getCreated();
        $mappedStatement->stored = $statement->getStored();

        return $mappedStatement;
    }
}
