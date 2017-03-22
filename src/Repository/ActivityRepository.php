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
use XApi\Repository\Doctrine\Repository\Mapping\ObjectRepository as MappedObjectRepository;

/**
 * Doctrine based {@link Activity} repository.
 *
 * @author Jérôme Parmentier <jerome.parmentier@acensi.fr>
 */
final class ActivityRepository implements ActivityRepositoryInterface
{
    private $repository;

    public function __construct(MappedObjectRepository $repository)
    {
        $this->repository = $repository;
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

        $activity = $this->repository->findObject($criteria);

        if (null === $activity) {
            throw new NotFoundException('No activity could be found matching the given criteria.');
        }

        return $activity->getModel();
    }
}
