<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matches
 *
 * @ORM\Table(name="matches")
 * @ORM\Entity
 */
class Matches
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="id1", type="integer", nullable=false)
     */
    private $id1;

    /**
     * @var integer
     *
     * @ORM\Column(name="id2", type="integer", nullable=false)
     */
    private $id2;

    /**
     * @var integer
     *
     * @ORM\Column(name="match_count", type="integer", nullable=true)
     */
    private $matchCount;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id1
     *
     * @param integer $id1
     * @return Matches
     */
    public function setId1($id1)
    {
        $this->id1 = $id1;

        return $this;
    }

    /**
     * Get id1
     *
     * @return integer 
     */
    public function getId1()
    {
        return $this->id1;
    }

    /**
     * Set id2
     *
     * @param integer $id2
     * @return Matches
     */
    public function setId2($id2)
    {
        $this->id2 = $id2;

        return $this;
    }

    /**
     * Get id2
     *
     * @return integer 
     */
    public function getId2()
    {
        return $this->id2;
    }

    /**
     * Set matchCount
     *
     * @param integer $matchCount
     * @return Matches
     */
    public function setMatchCount($matchCount)
    {
        $this->matchCount = $matchCount;

        return $this;
    }

    /**
     * Get matchCount
     *
     * @return integer 
     */
    public function getMatchCount()
    {
        return $this->matchCount;
    }
}
