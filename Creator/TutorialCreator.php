<?php

namespace Problematic\TutorialBundle\Creator;

use Problematic\TutorialBundle\Model\TutorialInterface;
use Problematic\TutorialBundle\Model\TutorialManagerInterface;
use Problematic\TutorialBundle\Blamer\TutorialBlamerInterface;

class TutorialCreator implements TutorialCreatorInterface
{

    protected $tutorialManager;
    protected $blamer;

    public function __construct(TutorialManagerInterface $tutorialManager, TutorialBlamerInterface $blamer)
    {
        $this->tutorialManager = $tutorialManager;
        $this->blamer = $blamer;
    }

    public function create(TutorialInterface $tutorial)
    {
        $this->blamer->blame($tutorial);
        $this->tutorialManager->addTutorial($tutorial);

        return true;
    }

}
