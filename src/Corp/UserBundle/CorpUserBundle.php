<?php

namespace Corp\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CorpUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
