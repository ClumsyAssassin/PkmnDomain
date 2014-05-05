<?php

namespace Pkmn\Evolution\Domain\Service;

use Pkmn\Monster\Domain\Monster;

interface Evolver
{
    /**
     * @param Monster $monster Name of the monster to evolve
     * @param string|null $monsterNameToEvolveInto (optional) The name of the monster to evolve into
     * @return boolean
     */
    public function canEvolve(Monster $monster, $monsterNameToEvolveInto = null);
} 