<?php

namespace Pkmn\Evolution\Domain\Service;

use Pkmn\Monster\Domain\Monster;

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
        $this->_monster->setName('monster');

        $this->_evolutionRepository = $this->getMock('\Pkmn\Evolution\Domain\Repository\EvolutionRepository');
        $this->_evolverService = new EvolverService($this->_evolutionRepository);
    }

    public function testCanEvolve()
    {
        $this->_mockFindEvolutions(array('evolvedMonster'));
        $this->assertTrue($this->_evolverService->canEvolve($this->_monster));
    }

    public function testCanEvolve_WhenMonsterHasNoPotentialEvolutions_ThenCannotEvolve()
    {
        $this->_mockFindEvolutions(array());
        $this->assertFalse($this->_evolverService->canEvolve($this->_monster));
    }

    /**
     * @param array $returnValue
     */
    private function _mockFindEvolutions($returnValue)
    {
        $this->_evolutionRepository->expects($this->once())
            ->method('findEvolutions')
            ->with($this->_monster->getName())
            ->will($this->returnValue($returnValue));
    }
}