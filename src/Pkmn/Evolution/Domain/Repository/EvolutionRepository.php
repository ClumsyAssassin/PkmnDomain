<?php

namespace Pkmn\Evolution\Domain\Repository;

interface EvolutionRepository
{
    /**
     * @param string $monsterName
     * @return array
     */
    public function findEvolutions($monsterName);

    /**
     * @param string $monsterName
     * @return array
     */
    public function findRequirements($monsterName);
} 