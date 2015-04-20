<?php

namespace Accounting\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AccountingUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
