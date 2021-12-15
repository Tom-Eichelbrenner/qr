<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use App\Entity\User;
use App\Exception\FormRegisteredException;
use App\Exception\FormUncompletedException;
use App\Exception\UserWithdrawedException;

class UserVoter extends Voter
{
    public const FILL_FORM = "fill_form";

    public const CONFIRMATION = "confirmation";

    public const WITHDRAW = "withdraw";

    protected function supports(string $attribute, $subject)
    {
        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /**
         * @var User $user
         */
        $user = $token->getUser();

        switch ($attribute) {
            case self::FILL_FORM:
                if ($user->getIsFormCompleted() === true) {
                    throw new FormRegisteredException($user);
                    return false;
                } elseif ($user->getParticipation() === false) {
                    throw new UserWithdrawedException($user);
                    return false;
                }
                break;
            case self::CONFIRMATION:
                if ($user->getParticipation() === false) {
                    throw new UserWithdrawedException($user);
                    return false;
                } elseif (! $user->getIsFormCompleted()) {
                    throw new FormUncompletedException($user);
                }
                break;
            case self::WITHDRAW:
                if ($user->getParticipation() === true && $user->getIsFormCompleted() === true) {
                    throw new FormRegisteredException($user);
                    return false;
                } elseif ($user->getParticipation() === true && ! $user->getIsFormCompleted()) {
                    throw new FormUncompletedException($user);
                    return false;
                }

                break;
        }


        return true;
    }
}
