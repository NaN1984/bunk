<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerDeposit
 *
 * @ORM\Table(name="customer_deposit", indexes={@ORM\Index(name="customer_account_id", columns={"customer_account_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerDepositRepository")
 */
class CustomerDeposit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="percent", type="float", precision=11, scale=2, nullable=false)
     */
    private $percent;

    /**
     * @var float
     *
     * @ORM\Column(name="initial_amount", type="decimal", precision=11, scale=3, nullable=false)
     */
    private $initialAmount;

    /**
     * @var CustomerAccount
     *
     * @ORM\ManyToOne(targetEntity="CustomerAccount")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_account_id", referencedColumnName="id")
     * })
     */
    private $customerAccount;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getPercent(): float
    {
        return $this->percent;
    }

    /**
     * @param float $percent
     */
    public function setPercent(float $percent): void
    {
        $this->percent = $percent;
    }

    /**
     * @return CustomerAccount
     */
    public function getCustomerAccount(): CustomerAccount
    {
        return $this->customerAccount;
    }

    /**
     * @param CustomerAccount $customerAccount
     */
    public function setCustomerAccount(CustomerAccount $customerAccount): void
    {
        $this->customerAccount = $customerAccount;
    }

    /**
     * @return float
     */
    public function getInitialAmount(): float
    {
        return $this->initialAmount;
    }

    /**
     * @param float $initialAmount
     */
    public function setInitialAmount(float $initialAmount): void
    {
        $this->initialAmount = $initialAmount;
    }
}
