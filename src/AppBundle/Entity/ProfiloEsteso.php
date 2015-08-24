<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfiloEsteso
 *
 * @ORM\Table(name="profilo_esteso")
 * @ORM\Entity
 */
class ProfiloEsteso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id2", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id2;

    /**
     * @var string
     *
     * @ORM\Column(name="descrizione_estesa", type="text", nullable=false)
     */
    private $descrizioneEstesa;



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
     * Set descrizioneEstesa
     *
     * @param string $descrizioneEstesa
     * @return ProfiloEsteso
     */
    public function setDescrizioneEstesa($descrizioneEstesa)
    {
        $this->descrizioneEstesa = $descrizioneEstesa;

        return $this;
    }

    /**
     * Get descrizioneEstesa
     *
     * @return string 
     */
    public function getDescrizioneEstesa()
    {
        return $this->descrizioneEstesa;
    }
}
