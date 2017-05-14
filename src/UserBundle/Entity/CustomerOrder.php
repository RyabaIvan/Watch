<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerOrder
 *
 * @ORM\Table(name="customer_order")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\CustomerOrderRepository")
 */
class CustomerOrder
{

    const STATUS_OPEN = 1;
    const STATUS_DONE = 2;
    const STATUS_REJECT = 3;
    const STATUS_RESOLVE = 4;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;


    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Customer", inversedBy="orders")
     * @ORM\JoinColumn(name="id_customer", referencedColumnName="id")
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="order_name", type="string", length=255, nullable=true)
     */
    private $orderName;

    /**
     * @return string
     */
    public function getOrderName()
    {
        return $this->orderName;
    }

    /**
     * @param string $orderName
     */
    public function setOrderName($orderName)
    {
        $this->orderName = $orderName;
    }



    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\OrderProduct", mappedBy="order", cascade={"all"})
     */
    private $products;

    /**
     * Add product
     *
     * @param \UserBundle\Entity\OrderProduct $product
     *
     * @return CustomerOrder
     */
    public function addProduct(\UserBundle\Entity\OrderProduct $product)
    {
        $product->setOrder($this);
        $this->products[] = $product;
        return $this;
    }
    /**
     * Remove product
     *
     * @param \UserBundle\Entity\OrderProduct $product
     */
    public function removeProduct(\UserBundle\Entity\OrderProduct $product)
    {
        $this->products->removeElement($product);
    }
    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }


    public function __construct()
    {
        $this->setDate(new \DateTime("now"));
        $this->setStatus(self::STATUS_OPEN);
        $this->products = new ArrayCollection();

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CustomerOrder
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getTotalPrice()
    {
        $total = 0;
        /** @var OrderProduct $product */
        foreach ($this->products as $product) {
            $total = $total + ( $product->getPrice() * $product->getCount());
        }
        return $total;
    }


    public function getTotalCount()
    {
        $total = 0;
        /** @var OrderProduct $product */
        foreach ($this->products as $product) {
            $total = $total + ( $product->getCount() );
        }
        return $total;
    }



    /**
     * Set status
     *
     * @param integer $status
     *
     * @return CustomerOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Set customer
     *
     * @param \UserBundle\Entity\Customer $customer
     *
     * @return CustomerOrder
     */
    public function setCustomer(\UserBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \UserBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
}
