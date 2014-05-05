<?php

namespace Pkmn\Evolution\Domain;

use Pkmn\Monster\Domain\Monster;

interface Requirement
{
    /**
     * @param Monster $monster
     * @return boolean
     */
    public function hasBeenMet(Monster $monster);
} 