<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 *     itemOperations={
 *          "get",
 *          "put",
 *          "delete",
 *          "get_change_logs"={
 *              "path"="/job_postings/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/job_postings/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\JobPostingRepository")
 *
 *  * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
 *
 * @ApiFilter(BooleanFilter::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class, properties={"hiringOrganization": "exact"})
 */
class JobPosting
{
    /**
     * @var UuidInterface
     *
     * @example e2984465-190a-4562-829e-a8cca81aa35d
     *
     * @Assert\Uuid
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var string The name of this Job Posting
     *
     * @example my JobPosting
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max = 255
     * )
     * @Assert\NotNull
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string The description of this JobPosting
     *
     * @example This is the best JobPosting ever
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max = 7500
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string The title of this Job Posting
     *
     * @example my JobPosting
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max = 255
     * )
     * @Assert\NotNull
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var string The type of employment **full-time**, **part-time**, **temporary**, **seasonal**, **internship**
     *
     * @example full-time
     *
     * @Gedmo\Versioned
     * @Assert\Choice({"full-time","part-time","temporary","internship","seasonal"})
     * @Assert\NotNull
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $employmentType;

    /**
     * @var array The education requirements of this JobPosting
     *
     * @example MBO-4 opleiding
     *
     * @Gedmo\Versioned
     * @Groups({"read","write"})
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $educationRequirements = [];

    /**
     * @var string The summary requirements of this JobPosting
     *
     * @example A small summary with information about this jobposting
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max = 255
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;

    /**
     * @var int Salary of the jobposting.
     *
     * @example 1900
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $baseSalary;

    /**
     * @var string The salary currency(coded using ISO 4217 ) of this jobPosting
     *
     * @example EUR
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max = 255
     * )
     * @Groups({"read","write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $salaryCurrency;

    /**
     * @var string A description of the job location (e.g TELECOMMUTE for telecommute jobs).
     *
     * @example TELECOMMUTE
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max = 255
     * )
     * @Groups({"read", "write"})
     * @ORM\Column(type="text", length=255)
     */
    private $jobLocationType;

    /**
     * @var string The organization that hires the person
     *
     * @example https://cc.zaakonline.nl/organizations/1
     *
     * @Gedmo\Versioned
     * @Assert\Url
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hiringOrganization;

    /**
     * @var \DateTime The start date of the contract
     *
     * @example 01-01-2020
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="datetime")
     */
    private $jobStartDate;

    /**
     * @var \DateTime The end date of the application procces
     *
     * @example 01-01-2020
     *
     * @Groups({"read", "write"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validThrough;

    /**
     * @var int The standard amount of hours per week for this JobPosting
     *
     * @example 40
     *
     * @Assert\NotNull
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     */
    private $standardHours;

    /**
     * @var Datetime The moment this resource was created
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var Datetime The moment this resource last Modified
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    /**
     * @var Application the application this JobPosting relates to
     *
     * @Groups({"read", "write"})
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="jobPosting")
     * @ORM\JoinColumn(nullable=true)
     */
    private $applications;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getEducationRequirements(): ?array
    {
        return $this->educationRequirements;
    }

    public function setEducationRequirements(?array $educationRequirements): self
    {
        $this->educationRequirements = $educationRequirements;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getBaseSalary(): ?int
    {
        return $this->baseSalary;
    }

    public function setBaseSalary(int $baseSalary): self
    {
        $this->baseSalary = $baseSalary;

        return $this;
    }

    public function getSalaryCurrency(): ?string
    {
        return $this->salaryCurrency;
    }

    public function setSalaryCurrency(?string $salaryCurrency): self
    {
        $this->salaryCurrency = $salaryCurrency;

        return $this;
    }

    public function getJobLocationType(): ?string
    {
        return $this->jobLocationType;
    }

    public function setJobLocationType(?string $jobLocationType): self
    {
        $this->jobLocationType = $jobLocationType;

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

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): self
    {
        $this->application = $application;

        return $this;
    }
}
