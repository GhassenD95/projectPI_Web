<?php
namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserActionLogger
{
    private LoggerInterface $userActionLogger;
    private ?UserInterface $currentUser = null;
    private ?TokenStorageInterface $tokenStorage;

    public function __construct(
        LoggerInterface $userActionLogger,
        ?TokenStorageInterface $tokenStorage
    ) {
        $this->userActionLogger = $userActionLogger;
        $this->tokenStorage = $tokenStorage;
        $this->setCurrentUser();
    }

    private function setCurrentUser(): void
    {
        $token = $this->tokenStorage?->getToken();
        if ($token && $token->getUser() instanceof UserInterface) {
            $this->currentUser = $token->getUser();
        } else {
            $this->currentUser = null;
        }
    }

    private function getUserIdentifier(): string
    {
        return $this->currentUser ? $this->currentUser->getUserIdentifier() : 'Anonymous';
    }

    public function log(string $action, string $context = null, ?array $details = null): void
    {
        $message = sprintf('User Action: %s - User: %s', $action, $this->getUserIdentifier());
        if ($context) {
            $message .= sprintf(' - Context: %s', $context);
        }
        if ($details) {
            $message .= sprintf(' - Details: %s', json_encode($details));
        }
        $this->userActionLogger->info($message, ['user_action' => true, 'action_type' => $action, 'context' => $context, 'details' => $details, 'user' => $this->getUserIdentifier()]);
    }
}