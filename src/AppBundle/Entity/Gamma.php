<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Catalog as Catalog;

/**
 * Gamma
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\GammaRepository")
 */
class Gamma
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text")
     */
    private $url;
	
	/**
     * @ORM\ManyToOne(targetEntity="Catalog", inversedBy="gammas")
     * @ORM\JoinColumn(name="catalog_id", referencedColumnName="id")
     **/
    private $catalog;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

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
     * Set id
     * @param integer $id
     * @return Gamma 
     */
    public function setId($id)
    {
		$this->id = $id;
        return $this;
    }
    /**
     * Set name
     *
     * @param string $name
     * @return Gamma
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Gamma
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set atalog
     *
     * @param Catalog $catalog
     * @return Gamma
     */
    public function setCatalog(Catalog $catalog)
    {
        $this->catalog = $catalog;

        return $this;
    }

    /**
     * Get atalog
     *
     * @return string 
     */
    public function getCatalog()
    {
        return $this->catalog;
    }
	
    /**
     * Set url
     *
     * @param string $url
     * @return Gamma
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
