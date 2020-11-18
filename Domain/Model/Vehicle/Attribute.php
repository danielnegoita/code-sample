<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\Aggregate;
use Common\Domain\Traits\SoftDeleteableEntity;
use Common\Domain\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Fleet\Domain\Model\Tenant\TenantId;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="Fleet\Infrastructure\Persistence\Doctrine\DoctrineAttributeRepository")
 * @ORM\Table(name="attributes",
 *      indexes={ @ORM\Index( name="attributes_idx", columns={"name"})}
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Vich\Uploadable
 */
class Attribute extends Aggregate
{
    /**
     * @ORM\Column(type="guid")
     */
    protected string $tenantId;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected ?string $description;

    /**
     * @ORM\Column(type="vehicle_attribute_type")
     */
    protected string $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $image;

    /**
     * This is NOT mapped & persisted to DB. Is needed by Vich bundle.
     *
     * @Vich\UploadableField(mapping="attribute_image", fileNameProperty="image")
     */
    protected ?File $imageFile;

    use TimestampableEntity;
    use SoftDeleteableEntity;

    private function __construct(TenantId $tenantId, AttributeUuid $uuid, string $name)
    {
        parent::__construct($uuid);

        $this->setTenantId($tenantId);
        $this->setName($name);
    }

    public static function create(
        TenantId $tenantId,
        AttributeUuid $uuid,
        string $name,
        ?string $description = null,
        ?string $type = AttributeType::OTHER,
        ?File $imageFile = null
    ): self {
        $attribute = new self($tenantId, $uuid, $name);

        $attribute->setDescription($description);
        $attribute->setType($type);
        $attribute->setImageFile($imageFile);

        return $attribute;
    }

    public function update(
        string $name,
        ?string $description = null,
        ?string $type = AttributeType::OTHER
    ): void {
        $this->setName($name);
        $this->setDescription($description);
        $this->setType($type);
    }

    public function changeImage(?File $imageFile = null): void
    {
        $this->setImageFile($imageFile);
    }

    public function tenantId(): TenantId
    {
        return TenantId::fromString($this->tenantId);
    }

    public function uuid(): AttributeUuid
    {
        return AttributeUuid::fromString($this->uuid);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function type(): ?string
    {
        return $this->type;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    private function setTenantId(TenantId $tenantId): void
    {
        $this->tenantId = $tenantId->toString();
    }

    private function setName(string $name): void
    {
        $this->name = $name;
    }

    private function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    private function setType(?string $type): void
    {
        if (null !== $type && !AttributeType::isValueExist($type)) {
            throw new \InvalidArgumentException("Invalid '{$type}' attribute type.");
        }

        $this->type = $type;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->setUpdatedAt(new \DateTimeImmutable());
        }
    }
}
