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
     * @var Object
     */
    public $actor;

    /**
     * @var Verb
     */
    public $verb;

    /**
     * @var Object
     */
    public $object;

    /**
     * @var Result
     */
    public $result;

    /**
     * @var Object
     */
    public $authority;

    /**
     * @var \DateTime|null
     */
    public $created;

    /**
     * @var \DateTime|null
     */
    public $stored;

    /**
     * @var Context
     */
    public $context;

    /**
     * @var bool
     */
    public $hasAttachments;

    /**
     * @var Attachment[]|null
     */
    public $attachments;

    public static function fromModel(StatementModel $model)
    {
        $statement = new self();
        $statement->id = $model->getId()->getValue();
        $statement->actor = Object::fromModel($model->getActor());
        $statement->verb = Verb::fromModel($model->getVerb());
        $statement->object = Object::fromModel($model->getObject());

        if (null !== $model->getCreated()) {
            $statement->created = $model->getCreated();
        }

        if (null !== $result = $model->getResult()) {
            $statement->result = Result::fromModel($result);
        }

        if (null !== $authority = $model->getAuthority()) {
            $statement->authority = Object::fromModel($authority);
        }

        if (null !== $context = $model->getContext()) {
            $statement->context = Context::fromModel($context);
        }

        if (null !== $attachments = $model->getAttachments()) {
            $statement->hasAttachments = true;
            $statement->attachments = array();

            foreach ($attachments as $attachment) {
                $mappedAttachment = Attachment::fromModel($attachment);
                $mappedAttachment->statement = $statement;
                $statement->attachments[] = $mappedAttachment;
            }
        } else {
            $statement->hasAttachments = false;
        }

        return $statement;
    }

    public function getModel()
    {
        $result = null;
        $authority = null;
        $created = null;
        $stored = null;
        $context = null;
        $attachments = null;

        if (null !== $this->result) {
            $result = $this->result->getModel();
        }

        if (null !== $this->authority) {
            $authority = $this->authority->getModel();
        }

        if (null !== $this->created) {
            $created = $this->created;
        }

        if (null !== $this->stored) {
            $stored = $this->stored;
        }

        if (null !== $this->context) {
            $context = $this->context->getModel();
        }

        if ($this->hasAttachments) {
            $attachments = array();

            foreach ($this->attachments as $attachment) {
                $attachments[] = $attachment->getModel();
            }
        }

        return new StatementModel(
            StatementId::fromString($this->id),
            $this->actor->getModel(),
            $this->verb->getModel(),
            $this->object->getModel(),
            $result,
            $authority,
            $created,
            $stored,
            $context,
            $attachments
        );
    }
}
