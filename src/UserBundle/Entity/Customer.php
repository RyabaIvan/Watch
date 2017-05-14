<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\CustomerRepository")
 */
class Customer implements UserInterface, \Serializable
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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    /**
     * @ORM\Column(name="date_created_at", type="datetime")
     */
    private $dateCreatedAt;
    private $plainPassword;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\CustomerOrder", mappedBy="customer", cascade={"all"})
     */
    private $orders;



    public function __construct()
    {
        $this->isActive = true;
        $this->setDateCreatedAt(new \DateTime());
        $this->orders = new ArrayCollection();
    }
    /**
     * @return \DateTime
     */
    public function getDateCreatedAt()
    {
        return $this->dateCreatedAt;
    }
    /**
     * @param \DateTime $dateCreatedAt
     */
    public function setDateCreatedAt(\DateTime $dateCreatedAt)
    {
        $this->dateCreatedAt = $dateCreatedAt;
    }

    public function activate()
    {
        $this->isActive = true;
    }

    public function deactivate()
    {
        $this->isActive = false;
    }
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
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }
    public function serialize()
    {
        $data = serialize([
            $this->getId(),
            $this->getUsername(),
            $this->getPassword()
        ]);
        return $data;
    }
    public function unserialize($serialized)
    {
        list($this->id, $this->email, $this->password) = unserialize($serialized);
    }
    public function getRoles()
    {
        return ['ROLE_CUSTOMER'];
    }
    public function getSalt()
    {
        return "";
    }
    public function getUsername()
    {
        return $this->getEmail();
    }
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set password
     *
     * @param string $password
     *
     * @return Customer
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Customer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }
    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
//    /**
//     * Add order
//     *
//     * @param \MyShop\DefaultBundle\Entity\CustomerOrder $order
//     *
//     * @return Customer
//     */
//    public function addOrder(\MyShop\DefaultBundle\Entity\CustomerOrder $order)
//    {
//        $order->setCustomer($this);
//        $this->orders[] = $order;
//        return $this;
//    }
//    /**
//     * Remove order
//     *
//     * @param \MyShop\DefaultBundle\Entity\CustomerOrder $order
//     */
//    public function removeOrder(\MyShop\DefaultBundle\Entity\CustomerOrder $order)
//    {
//        $this->orders->removeElement($order);
//    }
//    /**
//     * Get orders
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getOrders()
//    {
//        return $this->orders;
//    }
    public function __toString()
    {
        return $this->email;
    }

    /**
     * Add order
     *
     * @param \UserBundle\Entity\CustomerOrder $order
     *
     * @return Customer
     */
    public function addOrder(\UserBundle\Entity\CustomerOrder $order)
    {
        $this->orders[] = $order;
        $order->setCustomer($this);
        return $this;
    }

    /**
     * Remove order
     *
     * @param \UserBundle\Entity\CustomerOrder $order
     */
    public function removeOrder(\UserBundle\Entity\CustomerOrder $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
