<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Catalog as Catalog;

/**
 * Model
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ModelRepository")
 */
class Model
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
     * @ORM\ManyToOne(targetEntity="Gamma", inversedBy="models")
     * @ORM\JoinColumn(name="gamma_id", referencedColumnName="id")
     **/
    private $gamma;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Group", mappedBy="model")
     */
    private $groups;

    function __construct() {
        $this->groups = new ArrayCollection();
    }

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
     * @return Model
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
     * @return Model
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
     * @return Model
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
     * @param Gamma $gamma
     * @return Model
     */
    public function setGamma(Gamma $gamma)
    {
        $this->gamma = $gamma;

        return $this;
    }

    /**
     * Get gamma
     *
     * @return string 
     */
    public function getGamma()
    {
        return $this->gamma;
    }
	
    /**
     * Set url
     *
     * @param string $url
     * @return Model
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
