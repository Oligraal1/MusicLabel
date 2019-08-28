<?php

namespace App\Voters;

use App\Entity\User;
use App\Entity\Actualite;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
/** @Route("/uservoter") */
class UserVoter extends Voter
{
    const VIEWACTU = 'viewActu';
    Const EDITACTU = 'editActu';
    Const DELETEACTU = 'deleteActu';
    const CREATEACTU = 'createActu';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function supports($attribute, $subject) {
       // if the attribute isn't one we support, return false
       if (!in_array($attribute, [self::VIEWACTU, self::EDITACTU, self::DELETEACTU, self::CREATEACTU])) {
        return false;
    }

    // only vote on Actualite objects inside this voter
    if (!$subject instanceof Actualite) {
        return false;
    }

    return true; 
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }
        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
        return true;
}
        // you know $subject is a Actualite object, thanks to supports
        /** @var Actualite $actu */
        $actu = $subject;

        switch ($attribute) {
            case self::VIEWACTU:
                return $this->canView($actu,$user);
            case self::EDITACTU:
                return $this->canEdit($actu, $user);
            case self::DELETEACTU:
                return $this->canDelete($actu, $user);
            case self::CREATEACTU:
                return $this->canCreate($actu, $user);    
        }

        throw new \LogicException('This code should not be reached!');
    }
    private function canView(Actualite $actu, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($actu, $user)) {
            return true;
        }
    }

    private function canDelete(Actualite $actu, User $user)
    {
        // if they can edit, they can delete
        if ($this->canEdit($actu, $user)) {
            return true;
        }
       
    }
    private function canCreate(Actualite $actu, User $user)
    {
        // if they can edit, they can create
        if ($this->canEdit($actu, $user)) {
            return true;
        }
    }

    private function canEdit(Actualite $actu, User $user)
    {
        // this assumes that the data object has a getIdUser() method
        // to get the entity of the user who owns this data object
        return $user === $actu->getIdUser();
    }

}