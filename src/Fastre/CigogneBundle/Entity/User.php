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
     * @var string $phonenumber
     */
    private $phonenumber;

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
     * @var boolean $paymentPaypalAccepted
     */
    private $paymentPaypalAccepted = false;

    /**
     * @var boolean $paymentBankAccepted
     */
    private $paymentBankAccepted = true;

    /**
     * @var boolean $paymentBitcoinAccepted
     */
    private $paymentBitcoinAccepted = false;


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



    /**
     * Set paymentPaypalAccepted
     *
     * @param boolean $paymentPaypalAccepted
     * @return User
     */
    public function setPaymentPaypalAccepted($paymentPaypalAccepted)
    {
        $this->paymentPaypalAccepted = $paymentPaypalAccepted;
    
        return $this;
    }

    /**
     * Get paymentPaypalAccepted
     *
     * @return boolean 
     */
    public function getPaymentPaypalAccepted()
    {
        return $this->paymentPaypalAccepted;
    }

    /**
     * Set paymentBankAccepted
     *
     * @param boolean $paymentBankAccepted
     * @return User
     */
    public function setPaymentBankAccepted($paymentBankAccepted)
    {
        $this->paymentBankAccepted = $paymentBankAccepted;
    
        return $this;
    }

    /**
     * Get paymentBankAccepted
     *
     * @return boolean 
     */
    public function getPaymentBankAccepted()
    {
        return $this->paymentBankAccepted;
    }

    /**
     * Set paymentBitcoinAccepted
     *
     * @param boolean $paymentBitcoinAccepted
     * @return User
     */
    public function setPaymentBitcoinAccepted($paymentBitcoinAccepted)
    {
        $this->paymentBitcoinAccepted = $paymentBitcoinAccepted;
    
        return $this;
    }

    /**
     * Get paymentBitcoinAccepted
     *
     * @return boolean 
     */
    public function getPaymentBitcoinAccepted()
    {
        return $this->paymentBitcoinAccepted;
    }
}