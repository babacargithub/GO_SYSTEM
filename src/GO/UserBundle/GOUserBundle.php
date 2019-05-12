<?php

namespace GO\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GOUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
