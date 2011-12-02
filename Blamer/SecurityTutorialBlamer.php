<?php

namespace Problematic\TutorialBundle\Blamer;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Problematic\TutorialBundle\Model\TutorialInterface;

class SecurityTutorialBlamer implements TutorialBlamerInterface
{

    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function blame(TutorialInterface $tutorial)
    {
        if (null === $this->securityContext->getToken()) {
            throw new \RuntimeException('You must configure a firewall for this route');
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $tutorial->setAuthor($this->securityContext->getToken()->getUser());
        }
    }

}
