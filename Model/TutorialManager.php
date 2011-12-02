<?php

namespace Problematic\TutorialBundle\Model;

abstract class TutorialManager implements TutorialManagerInterface
{

    public function createTutorial()
    {
        $class = $this->getClass();
        $tutorial = new $class();

        return $tutorial;
    }

}
