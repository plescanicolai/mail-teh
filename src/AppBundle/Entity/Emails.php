<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emails
 *
 * @ORM\Table(name="emails")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmailsRepository")
 */
class Emails
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
     * @ORM\Column(name="form_add", type="string", length=50, nullable=true)
     */
    private $formAdd;

    /**
     * @var string
     *
     * @ORM\Column(name="to_add", type="string", length=50)
     */
    private $toAdd;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;


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
     * Set formAdd
     *
     * @param string $formAdd
     *
     * @return Emails
     */
    public function setFormAdd($formAdd)
    {
        $this->formAdd = $formAdd;

        return $this;
    }

    /**
     * Get formAdd
     *
     * @return string
     */
    public function getFormAdd()
    {
        return $this->formAdd;
    }

    /**
     * Set toAdd
     *
     * @param string $toAdd
     *
     * @return Emails
     */
    public function setToAdd($toAdd)
    {
        $this->toAdd = $toAdd;

        return $this;
    }

    /**
     * Get toAdd
     *
     * @return string
     */
    public function getToAdd()
    {
        return $this->toAdd;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Emails
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Emails
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}

