<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $priority;

    public function getPriority() {
        return $this->priority;
    }

    public function setPriority($priority) {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parent = null;

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @ORM\Column(type="text", length=256)
     */
    private $subject;

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * @ORM\Column(type="date")
     */
    private $start_date;

    public function getStartDate() {
        return $this->start_date;
    }

    public function setStartDate($start_date) {
        $this->start_date = $start_date;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $done_ratio;

    public function getDoneRatio() {
        return $this->done_ratio;
    }
    
    public function setDoneRatio($done_ratio) {
        $this->done_ratio = $done_ratio;
        
        return $this;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_on;

    public function getCreatedOn() {
        return $this->created_on;
    }

    public function setCreatedOn($created_on) {
        $this->created_on = $created_on;

        return $this;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_on;

    public function getUpdatedOn() {
        return $this->updated_on;
    }

    public function setUpdatedOn($updated_on) {
        $this->updated_on = $updated_on;

        return $this;
    }
}
