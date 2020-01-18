<?php

namespace App\Storage;

interface PersistentAwareInterface
{
    public function flush(): void;
}
