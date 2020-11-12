<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * All properties that the entity Employee holds. An Employee is a human with goals, skills and/or interests.
 * This can be an employee, but also, for example, a student or intern.
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 *     itemOperations={
 *          "get",
 *          "put",
 *          "delete",
 *          "get_change_logs"={
 *              "path"="/employees/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/employees/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
 *
 * @ApiFilter(BooleanFilter::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class)
 */
class Employee
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
     * @var string The person that is employed
     *
     * @example https://cc.zaakonline.nl/people/e2984465-190a-4562-829e-a8cca81aa35d
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max = 255
     * )
     * @Assert\NotNull
     * @Assert\Url
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $person;

    /**
     * @var string The organisation where this person is employed
     *
     * @example https://cc.zaakonline.nl/organizations/e2984465-190a-4562-829e-a8cca81aa35d
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max = 255
     * )
     * @Assert\Url
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $organization;

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
     * @Groups({"read","write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Goal", mappedBy="employee")
     * @MaxDepth(1)
     */
    private $goals;

    /**
     * @Groups({"read","write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Interest", mappedBy="employee")
     * @MaxDepth(1)
     */
    private $interests;

    /**
     * @Groups({"read","write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Competence", mappedBy="employee")
     * @MaxDepth(1)
     */
    private $competencies;

    /**
     * @Groups({"read","write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Skill", mappedBy="employee")
     * @MaxDepth(1)
     */
    private $skills;

    /**
     * @Groups({"read","write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="employee")
     * @MaxDepth(1)
     */
    private $applications;

    /**
     * @Groups({"read","write"})
     * @ORM\OneToMany(targetEntity="App\Entity\JobFunction", mappedBy="employee")
     * @MaxDepth(1)
     */
    private $jobFunctions;

    /**
     * @Groups({"read","write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Contract", mappedBy="employee")
     * @MaxDepth(1)
     */
    private $contracts;

    public function __construct()
    {
        $this->goals = new ArrayCollection();
        $this->interests = new ArrayCollection();
        $this->competencies = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->jobFunctions = new ArrayCollection();
        $this->contracts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(string $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(string $organization): self
    {
        $this->organization = $organization;

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

    public function getJobPosting(): ?JobPosting
    {
        return $this->jobPosting;
    }

    public function setJobPosting(JobPosting $jobPosting): self
    {
        $this->jobPosting = $jobPosting;

        // set the owning side of the relation if necessary
        if ($jobPosting->getEmployee() !== $this) {
            $jobPosting->setEmployee($this);
        }

        return $this;
    }

    /**
     * @return Collection|Goal[]
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): self
    {
        if (!$this->goals->contains($goal)) {
            $this->goals[] = $goal;
            $goal->setEmployee($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): self
    {
        if ($this->goals->contains($goal)) {
            $this->goals->removeElement($goal);
            // set the owning side to null (unless already changed)
            if ($goal->setEmployee() === $this) {
                $goal->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Interest[]
     */
    public function getInterests(): Collection
    {
        return $this->interests;
    }

    public function addInterest(Interest $interest): self
    {
        if (!$this->interests->contains($interest)) {
            $this->interests[] = $interest;
            $interest->setEmployee($this);
        }

        return $this;
    }

    public function removeInterest(Interest $interest): self
    {
        if ($this->interests->contains($interest)) {
            $this->interests->removeElement($interest);
            // set the owning side to null (unless already changed)
            if ($interest->setEmployee() === $this) {
                $interest->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetencies(): Collection
    {
        return $this->competencies;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competencies->contains($competence)) {
            $this->competencies[] = $competence;
            $competence->setEmployee($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competencies->contains($competence)) {
            $this->competencies->removeElement($competence);
            // set the owning side to null (unless already changed)
            if ($competence->setEmployee() === $this) {
                $competence->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setEmployee($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            // set the owning side to null (unless already changed)
            if ($skill->setEmployee() === $this) {
                $skill->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setEmployee($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->setEmployee() === $this) {
                $application->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|JobFunction[]
     */
    public function getJobFunctions(): Collection
    {
        return $this->jobFunctions;
    }

    public function addJobFunction(JobFunction $jobFunction): self
    {
        if (!$this->jobFunctions->contains($jobFunction)) {
            $this->jobFunctions[] = $jobFunction;
            $jobFunction->setEmployee($this);
        }

        return $this;
    }

    public function removeJobFunction(JobFunction $jobFunction): self
    {
        if ($this->jobFunctions->contains($jobFunction)) {
            $this->jobFunctions->removeElement($jobFunction);
            // set the owning side to null (unless already changed)
            if ($jobFunction->setEmployee() === $this) {
                $jobFunction->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contract[]
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts[] = $contract;
            $contract->setEmployee($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): self
    {
        if ($this->contracts->contains($contract)) {
            $this->contracts->removeElement($contract);
            // set the owning side to null (unless already changed)
            if ($contract->setEmployee() === $this) {
                $contract->setEmployee(null);
            }
        }

        return $this;
    }
}
