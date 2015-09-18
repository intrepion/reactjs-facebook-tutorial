<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * AppRole
 *
 * @ORM\Table(name="app_role")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AppRoleRepository")
 */
class AppRole implements RoleInterface
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
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="AppUser", mappedBy="appRole")
     **/
    private $appUser;

    public function __construct() {
        $this->appUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return AppRole
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
     * Set role
     *
     * @param string $role
     * @return AppRole
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return AppRole
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
     * Add appUser
     *
     * @param \AppBundle\Entity\AppUser $appUser
     * @return AppRole
     */
    public function addAppUser(\AppBundle\Entity\AppUser $appUser)
    {
        $this->appUser[] = $appUser;

        return $this;
    }

    /**
     * Remove appUser
     *
     * @param \AppBundle\Entity\AppUser $appUser
     */
    public function removeAppUser(\AppBundle\Entity\AppUser $appUser)
    {
        $this->appUser->removeElement($appUser);
    }

    /**
     * Get appUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppUser()
    {
        return $this->appUser;
    }
}
