<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerDepositOperation
 *
 * @ORM\Table(name="customer_deposit_operation", indexes={@ORM\Index(name="customer_deposit_id", columns={"customer_deposit_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerDepositOperationRepository")
 */
class CustomerDepositOperation
{
    const TYPE_ACCRUAL = 1;
    const TYPE_EXPENDITURE = 2;

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
     * @ORM\Column(name="account_amount", type="decimal", precision=11, scale=3, nullable=false)
     */
    private $accountAmount;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", precision=11, scale=3, nullable=false)
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="smallint", nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="date", nullable=false)
     */
    private $dateCreate;

    /**
     * @var CustomerDeposit
     *
     * @ORM\ManyToOne(targetEntity="CustomerDeposit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_deposit_id", referencedColumnName="id")
     * })
     */
    private $customerDeposit;

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
    }

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
    public function getAccountAmount(): float
    {
        return $this->accountAmount;
    }

    /**
     * @param float $accountAmount
     */
    public function setAccountAmount(float $accountAmount): void
    {
        $this->accountAmount = $accountAmount;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreate(): \DateTime
    {
        return $this->dateCreate;
    }

    /**
     * @param \DateTime $dateCreate
     */
    public function setDateCreate(\DateTime $dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return CustomerDeposit
     */
    public function getCustomerDeposit(): CustomerDeposit
    {
        return $this->customerDeposit;
    }

    /**
     * @param CustomerDeposit $customerDeposit
     */
    public function setCustomerDeposit(CustomerDeposit $customerDeposit): void
    {
        $this->customerDeposit = $customerDeposit;
    }
}
