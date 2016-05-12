<?php

namespace px\BackendBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class pxBackendBundle extends Bundle
{
      public function getParent()
    {
        return 'EasyAdminBundle';
    }
}
