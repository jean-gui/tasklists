<?php


namespace App\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use function get_class;

final class OAuthUserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    private array $authorizedUsers;

    public function __construct(
        #[Autowire('%authorized_users%')]
        array $authorizedUsers
    ) {
        $this->authorizedUsers = $authorizedUsers;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if (in_array($identifier, $this->authorizedUsers)) {
            return new OAuthUser($identifier);
        }

        $exception = new UserNotFoundException(sprintf("User '%s' not found.", $identifier));
        $exception->setUserIdentifier($identifier);

        throw $exception;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response): UserInterface
    {
        return $this->loadUserByIdentifier($response->getEmail());
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Unsupported user class "%s"', get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass($class): bool
    {
        return 'HWI\\Bundle\\OAuthBundle\\Security\\Core\\User\\OAuthUser' === $class;
    }
}
