<?php

namespace Wac\TechWebBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WacTechWebBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle'; 
  }
}
