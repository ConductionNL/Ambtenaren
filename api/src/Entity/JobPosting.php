<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\JobPostingRepository")
 */
class JobPosting
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $employmentType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hiringOrganization;

    /**
     * @ORM\Column(type="date")
     */
    private $jobStartDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validThrough;

    /**
     * @ORM\Column(type="integer")
     */
    private $standardHours;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateModified;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Employee", inversedBy="jobPosting", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getEmploymentType(): ?string
    {
        return $this->employmentType;
    }

    public function setEmploymentType(string $employmentType): self
    {
        $this->employmentType = $employmentType;

        return $this;
    }

    public function getHiringOrganization(): ?string
    {
        return $this->hiringOrganization;
    }

    public function setHiringOrganization(?string $hiringOrganization): self
    {
        $this->hiringOrganization = $hiringOrganization;

        return $this;
    }

    public function getJobStartDate(): ?\DateTimeInterface
    {
        return $this->jobStartDate;
    }

    public function setJobStartDate(\DateTimeInterface $jobStartDate): self
    {
        $this->jobStartDate = $jobStartDate;

        return $this;
    }

    public function getValidThrough(): ?\DateTimeInterface
    {
        return $this->validThrough;
    }

    public function setValidThrough(?\DateTimeInterface $validThrough): self
    {
        $this->validThrough = $validThrough;

        return $this;
    }

    public function getStandardHours(): ?int
    {
        return $this->standardHours;
    }

    public function setStandardHours(int $standardHours): self
    {
        $this->standardHours = $standardHours;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }
}
