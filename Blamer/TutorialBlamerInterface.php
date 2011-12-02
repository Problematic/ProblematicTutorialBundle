<?php

namespace Problematic\TutorialBundle\Blamer;

use Problematic\TutorialBundle\Model\TutorialInterface;

interface TutorialBlamerInterface
{

    function blame(TutorialInterface $tutorial);

}
