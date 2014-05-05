<?php

namespace Pkmn\Monster\Domain;

class Monster
{
    /**
     * @var string The name of the monster's species
     */
    private $_name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }
} 