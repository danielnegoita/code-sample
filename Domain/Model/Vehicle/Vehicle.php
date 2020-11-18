<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\Aggregate;
use Common\Domain\Traits\SoftDeleteableEntity;
use Common\Domain\Traits\TimestampableEntity;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Fleet\Domain\Model\Tenant\TenantId;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Fleet\Infrastructure\Persistence\Doctrine\DoctrineVehicleRepository")
 *  * @ORM\Table(name="vehicles",
 *      indexes={ @ORM\Index( name="vehicle_idx", columns={"type", "make", "model", "registration_plate"}, options={"where": "((registration_plate IS NOT NULL))"} )}
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Vehicle extends Aggregate
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Column(type="guid")
     */
    protected string $tenantId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected string $make;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected string $model;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected ?string $registrationPlate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected ?DateTimeInterface $manufacturedAt;

    /**
     * @ORM\Column(type="vehicle_type", nullable=true)
     */
    protected ?string $type;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    protected string $status;

    /**
     * Many Cars have Many Attributes.
     *
     * @ORM\ManyToMany(targetEntity="Attribute")
     * @ORM\JoinTable(name="vehicles_attributes",
     *      joinColumns={@ORM\JoinColumn(name="vehicle_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="attribute_id", referencedColumnName="id")}
     * )
     *
     * @param Attribute[] $attribute
     */
    protected Collection $attributes;

    private function __construct(TenantId $tenantId, VehicleUuid $uuid, Make $make, Model $model)
    {
        parent::__construct($uuid);

        $this->setTenantId($tenantId);
        $this->setMake($make);
        $this->setModel($model);
        $this->setStatus(VehicleStatus::new());
        $this->attributes = new ArrayCollection();
    }

    public static function create(
        TenantId $tenantId,
        VehicleUuid $uuid,
        Make $make,
        Model $model,
        ?RegistrationPlate $registrationPlate = null,
        ?DateTimeInterface $manufacturedAt = null,
        ?Type $type = null
    ): self {
        $vehicle = new self($tenantId, $uuid, $make, $model);

        $vehicle->setRegistrationPlate($registrationPlate);
        $vehicle->setManufacturedAt($manufacturedAt);
        $vehicle->setType($type);

        return $vehicle;
    }

    public function update(
        Make $make,
        Model $model,
        ?RegistrationPlate $registrationPlate = null,
        ?DateTimeInterface $manufacturedAt = null,
        ?Type $type = null
    ): void {
        $this->setMake($make);
        $this->setModel($model);
        $this->setRegistrationPlate($registrationPlate);
        $this->setManufacturedAt($manufacturedAt);
        $this->setType($type);
    }

    public function tenantId(): TenantId
    {
        return TenantId::fromString($this->tenantId);
    }

    public function uuid(): VehicleUuid
    {
        return VehicleUuid::fromString($this->uuid);
    }

    public function make(): Make
    {
        return Make::fromString($this->make);
    }

    public function model(): Model
    {
        return Model::fromString($this->model);
    }

    public function registrationPlate(): RegistrationPlate
    {
        return RegistrationPlate::fromString($this->registrationPlate);
    }

    public function manufacturedAt(): ?DateTimeInterface
    {
        return $this->manufacturedAt;
    }

    public function type(): Type
    {
        return Type::fromString($this->type);
    }

    public function status(): VehicleStatus
    {
        return VehicleStatus::fromString($this->status);
    }

    public function isAvailable(): bool
    {
        return $this->status()->equals(VehicleStatus::available());
    }

    public function available(): void
    {
        $this->setStatus(VehicleStatus::available());
    }

    public function maintenance(): void
    {
        $this->setStatus(VehicleStatus::maintenance());
    }

    /**
     * @return ArrayCollection<Attribute> $attributes
     */
    public function attributes(): ArrayCollection
    {
        return  $this->attributes;
    }

    public function addAttribute(Attribute $attribute): void
    {
        if ($this->attributes->contains($attribute)) {
            return;
        }

        $this->attributes->add($attribute);
    }

    public function removeAttribute(Attribute $attribute): void
    {
        if (!$this->attributes->contains($attribute)) {
            return;
        }

        $this->attributes->removeElement($attribute);
    }

    private function setTenantId(TenantId $tenantId): void
    {
        $this->tenantId = $tenantId->toString();
    }

    private function setMake(Make $make): void
    {
        $this->make = $make->toString();
    }

    private function setModel(Model $model): void
    {
        $this->model = $model->toString();
    }

    private function setRegistrationPlate(?RegistrationPlate $registrationPlate): void
    {
        $this->registrationPlate = null !== $registrationPlate ? $registrationPlate->toString() : null;
    }

    private function setManufacturedAt(?DateTimeInterface $manufacturedAt): void
    {
        $this->manufacturedAt = $manufacturedAt;
    }

    public function setType(?Type $type): void
    {
        $this->type = null !== $type ? $type->toString() : null;
    }

    private function setStatus(VehicleStatus $status): void
    {
        $this->status = $status->toString();
    }
}
