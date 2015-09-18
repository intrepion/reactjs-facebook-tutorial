<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use AppBundle\Entity\AppUser;
use Symfony\Component\Security\Core\User\UserInterface;
use GoIntegro\Hateoas\Security\VoterFilterInterface;
// ORM.
use Doctrine\ORM\QueryBuilder;

class MessageVoter extends AbstractVoter implements VoterFilterInterface
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function getSupportedAttributes()
    {
        return array(self::VIEW, self::EDIT);
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\Entity\Message');
    }

    protected function isGranted($attribute, $message, $appUser = null)
    {
        // make sure there is a user object (i.e. that the user is logged in)
        if (!$appUser instanceof UserInterface) {
            return false;
        }

        // double-check that the User object is the expected entity.
        // It always will be, unless there is some misconfiguration of the
        // security system.
        if (!$appUser instanceof AppUser) {
            throw new \LogicException('The user is somehow not our User class!');
        }

        switch($attribute) {
            case self::VIEW:
                // the data object could have for example a method isPrivate()
                // which checks the Boolean attribute $private
                if (!$message->isPrivate()) {
                    return true;
                }

                break;
            case self::EDIT:
                // this assumes that the data object has a getOwner() method
                // to get the entity of the user who owns this data object
                if ($appUser->getId() === $message->getOwner()->getId()) {
                    return true;
                }

                break;
        }

        return false;
    }

    public function filter(QueryBuilder $qb, array $filters, $alias = 'e')
    {
    }
}
