<?php

namespace Pkmn\Evolution\Domain\Service;

use Pkmn\Evolution\Domain\Exception\NoRequirementsFound;
use Pkmn\Evolution\Domain\Repository\EvolutionRepository;
use Pkmn\Monster\Domain\Monster;

class EvolverService implements Evolver
{
    /**
     * @var EvolutionRepository
     */
    private $_evolutionRepository;

    public function __construct(EvolutionRepository $evolutionRepository)
    {
        $this->_evolutionRepository = $evolutionRepository;
    }

    /**
     * @param Monster $monster Name of the monster to evolve
     * @param string|null $monsterNameToEvolveInto (optional) The name of the monster to evolve into
     * @throws \Pkmn\Evolution\Domain\Exception\NoRequirementsFound
     * @return boolean
     */
    public function canEvolve(Monster $monster, $monsterNameToEvolveInto = null)
    {
        $evolutions = $this->_evolutionRepository->findEvolutions($monster->getName());

        if (empty($evolutions)) {
            return false;
        }

        if (is_string($monsterNameToEvolveInto) && !empty($monsterNameToEvolveInto)) {
            if (!in_array($monsterNameToEvolveInto, $evolutions)) {
                return false;
            }
            return $this->_monsterMetRequirementsForEvolution($monster, $monsterNameToEvolveInto);

        }

        foreach ($evolutions as $evolution) {
            if ($this->_monsterMetRequirementsForEvolution($monster, $evolution)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Monster $monster
     * @param $monsterNameToEvolveInto
     * @return bool
     * @throws \Pkmn\Evolution\Domain\Exception\NoRequirementsFound
     */
    private function _monsterMetRequirementsForEvolution(Monster $monster, $monsterNameToEvolveInto)
    {
        $requirements = $this->_evolutionRepository->findRequirements($monsterNameToEvolveInto);
        if (empty($requirements)) {
            throw new NoRequirementsFound("No requirements found for monster '$monsterNameToEvolveInto'");
        }
        $requirementsMet = true;
        /**
         * @var \Pkmn\Evolution\Domain\Requirement $requirement
         */
        foreach ($requirements as $requirement) {
            if (!$requirement->hasBeenMet($monster)) {
                $requirementsMet = false;
                break;
            }
        }
        return $requirementsMet;
    }
} 