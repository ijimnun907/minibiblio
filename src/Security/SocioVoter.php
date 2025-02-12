<?php

namespace App\Security;

use App\Entity\Socio;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class SocioVoter extends Voter
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    const LIST = 'SOCIO_LIST';
    const EDIT = 'SOCIO_EDIT';
    const CREATE = 'SOCIO_CREATE';
    const DELETE = 'SOCIO_DELETE';

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

        if (!$subject instanceof Socio){
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        assert($subject instanceof Socio);

        switch ($attribute){
            case self::EDIT:
                return ($this->security->isGranted('ROLE_BIBLIOTECARIO') && $subject->isEsEstudiante()) || ($this->security->isGranted('ROLE_ADMIN'));
        }
    }
}