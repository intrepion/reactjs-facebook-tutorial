<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * AppUser
 *
 * @ORM\Table(name="app_user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AppUserRepository")
 */
class AppUser implements AdvancedUserInterface
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
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accountExpired", type="boolean", nullable=true)
     */
    private $accountExpired;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accountLocked", type="boolean", nullable=true)
     */
    private $accountLocked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="credentialsExpired", type="boolean", nullable=true)
     */
    private $credentialsExpired;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\ManyToMany(targetEntity="AppRole", inversedBy="appUser")
     * @ORM\JoinTable(name="app_user__app_role",
     *      joinColumns={@ORM\JoinColumn(name="app_user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="app_role_id", referencedColumnName="id")}
     *      )
     **/
    private $appRole;

    public function __construct() {
        $this->appRole = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return AppUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return AppUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return AppUser
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set accountExpired
     *
     * @param boolean $accountExpired
     * @return AppUser
     */
    public function setAccountExpired($accountExpired)
    {
        $this->accountExpired = $accountExpired;

        return $this;
    }

    /**
     * Get accountExpired
     *
     * @return boolean
     */
    public function getAccountExpired()
    {
        return $this->accountExpired;
    }

    /**
     * Set accountLocked
     *
     * @param boolean $accountLocked
     * @return AppUser
     */
    public function setAccountLocked($accountLocked)
    {
        $this->accountLocked = $accountLocked;

        return $this;
    }

    /**
     * Get accountLocked
     *
     * @return boolean
     */
    public function getAccountLocked()
    {
        return $this->accountLocked;
    }

    /**
     * Set credentialsExpired
     *
     * @param boolean $credentialsExpired
     * @return AppUser
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    /**
     * Get credentialsExpired
     *
     * @return boolean
     */
    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return AppUser
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    public function getRoles()
    {
        return array_map(function (AppRole $appRole) {
            return $appRole->getRole();
        }, $this->appRole->toArray());
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        if (is_null($this->accountExpired)) {
            return true;
        }

        return !$this->accountExpired;
    }

    public function isAccountNonLocked()
    {
        if (is_null($this->accountLocked)) {
            return true;
        }

        return !$this->accountLocked;
    }

    public function isCredentialsNonExpired()
    {
        if (is_null($this->credentialsExpired)) {
            return true;
        }

        return !$this->credentialsExpired;
    }

    public function isEnabled()
    {
        if (is_null($this->enabled)) {
            return false;
        }

        return $this->enabled;
    }

    /**
     * Add appRole
     *
     * @param \AppBundle\Entity\AppRole $appRole
     * @return AppUser
     */
    public function addAppRole(\AppBundle\Entity\AppRole $appRole)
    {
        $this->appRole[] = $appRole;

        return $this;
    }

    /**
     * Remove appRole
     *
     * @param \AppBundle\Entity\AppRole $appRole
     */
    public function removeAppRole(\AppBundle\Entity\AppRole $appRole)
    {
        $this->appRole->removeElement($appRole);
    }

    /**
     * Get appRole
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppRole()
    {
        return $this->appRole;
    }
}
