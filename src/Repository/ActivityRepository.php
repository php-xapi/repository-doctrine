<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace XApi\Repository\Doctrine\Repository;

use Xabbuh\XApi\Common\Exception\NotFoundException;
use Xabbuh\XApi\Model\IRI;
use XApi\Repository\Api\ActivityRepositoryInterface;
use XApi\Repository\Doctrine\Mapping\Object as MappedObject;
use XApi\Repository\Doctrine\Storage\ObjectStorage;

/**
 * Doctrine based {@link Activity} repository.
 *
 * @author Jérôme Parmentier <jerome.parmentier@acensi.fr>
 */
final class ActivityRepository implements ActivityRepositoryInterface
{
    private $storage;

    public function __construct(ObjectStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * {@inheritdoc}
     */
    public function findActivityById(IRI $activityId)
    {
        $criteria = array(
            'type' => MappedObject::TYPE_ACTIVITY,
            'activityId' => $activityId->getValue(),
        );

        $activity = $this->storage->findObject($criteria);

        if (null === $activity) {
            throw new NotFoundException('No activity could be found matching the given criteria.');
        }

        return $activity->getModel();
    }
}
