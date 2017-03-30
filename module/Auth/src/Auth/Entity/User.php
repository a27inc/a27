<?php namespace Auth\Entity;

#use ZfcUser\Entity\User as ZfcUserEntity;
use ZfcUser\Entity\UserInterface;
use ZfcRbac\Identity\IdentityInterface;
use Rbac\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface, IdentityInterface{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $username;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="display_name", type="string", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var int|null
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $state;
    
    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="HierarchicalRole", indexBy="name", cascade={"persist"})
     * @ORM\JoinTable(name="user_role",
     *    joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *    inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", onDelete="CASCADE")})
     */
    private $roles;

    public function __construct(){
        $this->roles = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     * @return UserInterface
     */
    public function setId($id){
        $this->id = (int) $id;
        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     * @return UserInterface
     */
    public function setUsername($username){
        $this->username = $username;
        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     * @return UserInterface
     */
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName(){
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     * @return UserInterface
     */
    public function setDisplayName($displayName){
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword(){
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     * @return UserInterface
     */
    public function setPassword($password){
        $this->password = $password;
        return $this;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState(){
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     * @return UserInterface
     */
    public function setState($state){
        $this->state = $state;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles(){
        return $this->roles->toArray();
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function hasRole($roleName) {
        return $this->roles->containsKey($roleName);
    }
}