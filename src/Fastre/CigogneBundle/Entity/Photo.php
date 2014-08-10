<?php

namespace Fastre\CigogneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 */
class Photo
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $type = 'jpg';

    /**
     * @var \DateTime
     */
    private $creationDate;

    /**
     * @var \Fastre\CigogneBundle\Entity\User
     */
    private $creator;
    
        /**
     * @var \DateTime
     */
    private $endAccessDate;

    /**
     * @var string
     */
    private $tempUrl;
    
    private $file;
    
    public function __construct()
    {
       $this->setId(sha1(uniqid(rand(), true)).uniqid());
       $now = new \DateTime();
       $this->setCreationDate($now);
       $this->setEndAccessDate($now);
       $this->setTempUrl(sha1(uniqid(rand(), true)).uniqid());
    }


    /**
     * Set id
     *
     * @param string $id
     * @return Photo
     */
    private function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Photo
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Photo
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set creator
     *
     * @param \Fastre\CigogneBundle\Entity\User $creator
     * @return Photo
     */
    public function setCreator(\Fastre\CigogneBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \Fastre\CigogneBundle\Entity\User 
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set endAccessDate
     *
     * @param \DateTime $endAccessDate
     * @return Photo
     */
    public function setEndAccessDate($endAccessDate)
    {
        $this->endAccessDate = $endAccessDate;

        return $this;
    }

    /**
     * Get endAccessDate
     *
     * @return \DateTime 
     */
    public function getEndAccessDate()
    {
        return $this->endAccessDate;
    }

    /**
     * Set tempUrl
     *
     * @param string $tempUrl
     * @return Photo
     */
    public function setTempUrl($tempUrl)
    {
        $this->tempUrl = $tempUrl;

        return $this;
    }

    /**
     * Get tempUrl
     *
     * @return string 
     */
    public function getTempUrl()
    {
        return $this->tempUrl;
    }
    
    public function getPhoto() {
       return $this->file;
    }
    
    public function setPhoto(\Symfony\Component\HttpFoundation\File\UploadedFile $file) {
       
       $this->file = $file;
       $this->type = $file->guessExtension();
    }
    
    public function getFileName()
    {
       return $this->getId().'.'.$this->getType();
    }
}
