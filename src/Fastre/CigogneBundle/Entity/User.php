<?php

namespace Fastre\CigogneBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fastre\CigogneBundle\Entity\User
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $phonenumber
     */
    private $phonenumber;

    /**
     * @var array $paymentAccepted
     */
    private $paymentAccepted;

    /**
     * @var string $paymentPaypalAccount
     */
    private $paymentPaypalAccount;

    /**
     * @var string $paymentBankAccountNumber
     */
    private $paymentBankAccountNumber;

    /**
     * @var string $paymentBitcoinAddress
     */
    private $paymentBitcoinAddress;


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
     * Set phonenumber
     *
     * @param string $phonenumber
     * @return User
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    
        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return string 
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Set paymentAccepted
     *
     * @param array $paymentAccepted
     * @return User
     */
    public function setPaymentAccepted($paymentAccepted)
    {
        $this->paymentAccepted = $paymentAccepted;
    
        return $this;
    }

    /**
     * Get paymentAccepted
     *
     * @return array 
     */
    public function getPaymentAccepted()
    {
        return $this->paymentAccepted;
    }

    /**
     * Set paymentPaypalAccount
     *
     * @param string $paymentPaypalAccount
     * @return User
     */
    public function setPaymentPaypalAccount($paymentPaypalAccount)
    {
        $this->paymentPaypalAccount = $paymentPaypalAccount;
    
        return $this;
    }

    /**
     * Get paymentPaypalAccount
     *
     * @return string 
     */
    public function getPaymentPaypalAccount()
    {
        return $this->paymentPaypalAccount;
    }

    /**
     * Set paymentBankAccountNumber
     *
     * @param string $paymentBankAccountNumber
     * @return User
     */
    public function setPaymentBankAccountNumber($paymentBankAccountNumber)
    {
        $this->paymentBankAccountNumber = $paymentBankAccountNumber;
    
        return $this;
    }

    /**
     * Get paymentBankAccountNumber
     *
     * @return string 
     */
    public function getPaymentBankAccountNumber()
    {
        return $this->paymentBankAccountNumber;
    }

    /**
     * Set paymentBitcoinAddress
     *
     * @param string $paymentBitcoinAddress
     * @return User
     */
    public function setPaymentBitcoinAddress($paymentBitcoinAddress)
    {
        $this->paymentBitcoinAddress = $paymentBitcoinAddress;
    
        return $this;
    }

    /**
     * Get paymentBitcoinAddress
     *
     * @return string 
     */
    public function getPaymentBitcoinAddress()
    {
        return $this->paymentBitcoinAddress;
    }
}