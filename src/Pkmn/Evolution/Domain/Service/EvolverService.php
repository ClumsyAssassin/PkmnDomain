<?php

namespace Pkmn\Evolution\Domain\Service;

use Pkmn\Evolution\Domain\Repository\EvolutionRepository;
use Pkmn\Monster\Domain\Monster;

class EvolverService implements Evolver
{
    public function __construct(EvolutionRepository $evolutionRepository)
    {
        $this->_evolutionRepository = $evolutionRepository;
    }

    /**
     * @param Monster $monster Name of the monster to evolve
     * @param string|null $monsterNameToEvolveInto (optional) The name of the monster to evolve into
     * @return boolean
     */
    public function canEvolve(Monster $monster, $monsterNameToEvolveInto = null)
    {
        $evolutions = $this->_evolutionRepository->findEvolutions($monster->getName());

        if(empty($evolutions)) {
            return false;
        }

        return true;
    }
} 