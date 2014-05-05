<?php

namespace Pkmn\Evolution\Domain\Service;

class EvolverServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Pkmn\Monster\Domain\Monster
     */
    private $_monster;

    /**
     * @var EvolverService
     */
    private $_evolverService;

    /**
     * @var \Pkmn\Evolution\Domain\Repository\EvolutionRepository
     */
    private $_evolutionRepository;

    protected function setUp()
    {
        $this->_monster = $this->getMockForAbstractClass('\Pkmn\Monster\Domain\Monster');
        $this->_evolutionRepository = $this->getMock('\Pkmn\Evolution\Domain\Repository\EvolutionRepository');
        $this->_evolverService = new EvolverService($this->_evolutionRepository);
    }

    public function testCanEvolve()
    {
        $this->assertTrue($this->_evolverService->canEvolve($this->_monster));
    }
}