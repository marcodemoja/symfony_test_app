<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profilo
 *
 * @ORM\Table(name="profilo", uniqueConstraints={@ORM\UniqueConstraint(name="nome_cognome", columns={"nome", "cognome"})})
 * @ORM\Entity
 */
class Profilo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id1", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id1;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=100, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="cognome", type="string", length=100, nullable=false)
     */
    private $cognome;

    /**
     * @var string
     *
     * @ORM\Column(name="descrizione", type="text", nullable=false)
     */
    private $descrizione;



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
     * Set nome
     *
     * @param string $nome
     * @return Profilo
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set cognome
     *
     * @param string $cognome
     * @return Profilo
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;

        return $this;
    }

    /**
     * Get cognome
     *
     * @return string 
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * Set descrizione
     *
     * @param string $descrizione
     * @return Profilo
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    /**
     * Get descrizione
     *
     * @return string 
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }
}
