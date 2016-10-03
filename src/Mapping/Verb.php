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

use Xabbuh\XApi\Model\Verb as VerbModel;

/**
 * A {@link Verb} mapped to a storage backend.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
class Verb
{
    public $identifier;
    public $id;
    public $display;

    public function getModel()
    {
        return new VerbModel($this->id, $this->display);
    }

    public function equals(Verb $verb)
    {
        if ($this->identifier !== $verb->identifier) {
            return false;
        }

        if ($this->id !== $verb->id) {
            return false;
        }

        if ($this->display !== $verb->display) {
            return false;
        }

        return true;
    }

    public static function fromModel(VerbModel $verb)
    {
        $mappedVerb = new self();
        $mappedVerb->id = $verb->getId();
        $mappedVerb->display = $verb->getDisplay();

        return $mappedVerb;
    }
}
