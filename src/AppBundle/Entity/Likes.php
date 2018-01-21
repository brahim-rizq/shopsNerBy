<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likes
 *
 * @ORM\Table(name="likes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LikesRepository")
 */
class Likes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="isLiked", type="boolean")
     */
    private $isLiked;

    /**
     * @var string
     *
     * @ORM\Column(name="isDisliked", type="boolean")
     */
    private $isDisliked;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",cascade={"persist"},inversedBy="likes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Shops",cascade={"persist"},inversedBy="likes")
     * @ORM\JoinColumn(name="shop_id", referencedColumnName="id")
     */
    protected $shops;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isLiked
     *
     * @param boolean $isLiked
     *
     * @return Likes
     */
    public function setIsLiked($isLiked)
    {
        $this->isLiked = $isLiked;

        return $this;
    }

    /**
     * Get isLiked
     *
     * @return boolean
     */
    public function getIsLiked()
    {
        return $this->isLiked;
    }

    /**
     * Set isDisliked
     *
     * @param boolean $isDisliked
     *
     * @return Likes
     */
    public function setIsDisliked($isDisliked)
    {
        $this->isDisliked = $isDisliked;

        return $this;
    }

    /**
     * Get isDisliked
     *
     * @return boolean
     */
    public function getIsDisliked()
    {
        return $this->isDisliked;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Likes
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set shops
     *
     * @param \AppBundle\Entity\Shops $shops
     *
     * @return Likes
     */
    public function setShops(\AppBundle\Entity\Shops $shops = null)
    {
        $this->shops = $shops;

        return $this;
    }

    /**
     * Get shops
     *
     * @return \AppBundle\Entity\Shops
     */
    public function getShops()
    {
        return $this->shops;
    }
}
