<?php
/**
 * Created by PhpStorm.
 * User: KRÓL ŻYCIA
 * Date: 25.07.2018
 * Time: 20:18
 */

namespace App\Security;


use App\Entity\Note;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class NoteVoter extends Voter
{

    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        if (!$subject instanceof Note) {
            return false;
        }

        return true;
    }


    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $note = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($note, $user);
            case self::EDIT:
                return $this->canEdit($note, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Note $note, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($note, $user)) {
            return true;
        }

        // the Note object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return !$note->isPrivate();
    }

    private function canEdit(Note $note, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $note->getUserId();
    }
}