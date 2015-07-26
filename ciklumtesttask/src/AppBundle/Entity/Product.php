<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Exceptions\ImageLimitExceededException;
use JMS\Serializer\Annotation\Exclude;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
   /**
    * @var string  
    * @ORM\Column(length=256)
    */
   protected $title;

   /**
    * @var string   
    * @ORM\Column(length=1024)
    */
   protected $description;
   
   
   /**
    * @var integer
    * @ORM\Column(type="integer")
    */
   protected $quantity;

   /**
    * @var float
    * @ORM\Column(type="decimal", scale=2, precision=9)
    */
   protected $price;

   
   /**
    * @Exclude
    * @var Category
    * @ORM\ManyToOne(targetEntity="Category")
    */
    protected $category;

   /**
    * @var Currency
    * @ORM\ManyToOne(targetEntity="Currency")
    */
    protected $currency;
    
    /**
    * @Exclude
    * @var \Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Image>
    * @ORM\OneToMany(targetEntity="Image", mappedBy="product")
    */
    protected $images;

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
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set currency
     *
     * @param \AppBundle\Entity\Currency $currency
     * @return Product
     */
    public function setCurrency(\AppBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \AppBundle\Entity\Currency 
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add images
     *
     * @param \AppBundle\Entity\Image $image
     * @return Product
     */
    public function addImage(\AppBundle\Entity\Image $image)
    {
        
         if(count($this->images) >= 5 && !$this->images->contains($image)) {
            throw new ImageLimitExceededException(
              'At most 5 image are allowed per product, tried to add another!'
            );
          }
          $this->images->add($image);
          $image->setProduct($this);
          return $this; 
    }

    /**
     * Remove images
     *
     * @param \AppBundle\Entity\Image $images
     */
    public function removeImage(\AppBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}