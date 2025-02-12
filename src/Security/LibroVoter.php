<?php

namespace App\Security;

use App\Entity\Libro;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class LibroVoter extends Voter
{
    const LIST = 'LIBRO_LIST';
    const EDIT = 'LIBRO_EDIT';
    const CREATE = 'LIBRO_CREATE';
    const DELETE = 'LIBRO_DELETE';

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [
            self::LIST,
            self::CREATE,
            self::DELETE,
            self::EDIT
        ], true)) {
            return false;
        }

        if (!$subject instanceof Libro){
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        if (!$subject instanceof Libro){
            return false;
        }

        switch ($attribute) {
            case self::DELETE:
                return $subject->getSocio() === null;
        }
    }
}