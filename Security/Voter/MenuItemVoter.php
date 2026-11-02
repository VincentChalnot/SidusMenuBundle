<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Security\Voter;

use Sidus\MenuBundle\Model\MenuItem;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

readonly class MenuItemVoter implements VoterInterface
{
    public function __construct(
        private AccessDecisionManagerInterface $accessDecisionManager,
    ) {
    }

    /**
     * $attributes is ignored
     */
    public function vote(TokenInterface $token, $subject, array $attributes): int
    {
        if (!$subject instanceof MenuItem) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        foreach ($subject->getRoles() as $role) {
            if (!$this->accessDecisionManager->decide($token, [$role])) {
                return VoterInterface::ACCESS_DENIED;
            }
        }

        $security = $subject->getSecurity();
        if ($security
            && !$this->accessDecisionManager->decide($token, [$security->getRole()], $security->getObject())) {
            return VoterInterface::ACCESS_DENIED;
        }

        return VoterInterface::ACCESS_GRANTED;
    }
}
