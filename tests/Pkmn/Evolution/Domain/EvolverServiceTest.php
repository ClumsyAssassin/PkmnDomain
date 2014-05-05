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
     * @var \Pkmn\Evolution\Domain\Requirement
     */
    private $_requirement;

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
        $this->_requirement = $this->getMock('\Pkmn\Evolution\Domain\Requirement');
        $this->_evolutionRepository = $this->getMock('\Pkmn\Evolution\Domain\Repository\EvolutionRepository');
        $this->_evolverService = new EvolverService($this->_evolutionRepository);
    }

    public function testCanEvolve_WhenMonsterHasPotentialEvolution_AndRequirementsMet_ThenCanEvolve()
    {
        $this->_mockFindEvolutions(array('evolvedMonster'));
        $this->_mockRequirement(true);
        $this->_mockFindRequirements('evolvedMonster', array($this->_requirement));
        $this->assertTrue($this->_evolverService->canEvolve($this->_monster));
    }

    public function testCanEvolve_WhenMonsterHasNoPotentialEvolutions_ThenCannotEvolve()
    {
        $this->_mockFindEvolutions(array());
        $this->assertFalse($this->_evolverService->canEvolve($this->_monster));
    }

    public function testCanEvolve_WhenDesiredEvolutionIsNotAPotentialEvolution_ThenCannotEvolve()
    {
        $this->_mockFindEvolutions(array('evolvedMonster'));
        $this->assertFalse($this->_evolverService->canEvolve($this->_monster, 'desiredEvolution'));
    }

    public function testCanEvolve_WhenDesiredEvolutionIsAPotentialEvolution_AndRequirementsMet_ThenCanEvolve()
    {
        $this->_mockFindEvolutions(array('evolvedMonster'));
        $this->_mockRequirement(true);
        $this->_mockFindRequirements('evolvedMonster', array($this->_requirement));
        $this->assertTrue($this->_evolverService->canEvolve($this->_monster, 'evolvedMonster'));
    }

    public function testCanEvolve_WhenMonsterHasPotentialEvolution_AndNoRequirementsFound_ThenThrowException()
    {
        $this->setExpectedException('\Pkmn\Evolution\Domain\Exception\NoRequirementsFound');
        $this->_mockFindEvolutions(array('evolvedMonster'));
        $this->_mockFindRequirements('evolvedMonster', array());
        $this->assertTrue($this->_evolverService->canEvolve($this->_monster));
    }

    public function testCanEvolve_WhenMonsterHasPotentialEvolution_AndRequirementsNotMet_ThenCannotEvolve()
    {
        $this->_mockFindEvolutions(array('evolvedMonster'));
        $this->_mockRequirement(false);
        $this->_mockFindRequirements('evolvedMonster', array($this->_requirement));
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

    /**
     * @param string $monsterName
     * @param array $returnValue
     */
    private function _mockFindRequirements($monsterName, $returnValue)
    {
        $this->_evolutionRepository->expects($this->once())
            ->method('findRequirements')
            ->with($monsterName)
            ->will($this->returnValue($returnValue));
    }

    /**
     * @param boolean $rtnValue
     */
    private function _mockRequirement($rtnValue)
    {
        $this->_requirement->expects($this->once())
            ->method('hasBeenMet')
            ->with($this->_monster)
            ->will($this->returnValue($rtnValue));
    }
}