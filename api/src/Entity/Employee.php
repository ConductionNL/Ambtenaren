<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
{
    /**
     * @var UuidInterface
     *
     * @ApiProperty(
     * 	   identifier=true,
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The UUID identifier of this object",
     *             "type"="string",
     *             "format"="uuid",
     *             "example"="e2984465-190a-4562-829e-a8cca81aa35d"
     *         }
     *     }
     * )
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
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The person that is employed",
     *             "type"="string",
     *             "format"="url",
     *             "example"="http://cc.zaakonline.nl/contact/2984465-190a-4562-829e-a8cca81aa35d"
     *         }
     *     }
     * )
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     *
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $contact;

    /**
     * @var string The organisation where this person is employed
     *
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The organisation where this person is employed",
     *             "type"="string",
     *             "format"="rsin",
     *             "example"="123456789"
     *         }
     *     }
     * )
     *
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $sourceOrganisation;

    public function getId()
    {
        return $this->id;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getSourceOrganisation(): ?string
    {
        return $this->sourceOrganisation;
    }

    public function setSourceOrganisation(string $sourceOrganisation): self
    {
        $this->sourceOrganisation = $sourceOrganisation;

        return $this;
    }
}
