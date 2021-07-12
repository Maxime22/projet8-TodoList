<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoter extends Voter
{
    const TASK_DELETE = "task_delete";

    protected function supports(string $attribute, $task): bool
    {
        return in_array($attribute, [self::TASK_DELETE])
            && $task instanceof Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // If the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // No author => permission if admin
        if ($task->getAuthor() === null) {
            if (in_array("ROLE_ADMIN", $user->getRoles())) {
                return true;
            } else {
                return false;
            }
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::TASK_DELETE:
                return $this->canDelete($task, $user);
                break;
        }

        return false;
    }

    private function canDelete(Task $task, User $user)
    {
        return $user === $task->getAuthor();
    }
}
