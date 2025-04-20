<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Entity;

use app\Doctrine\ORM\Repository\ClientRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\Collection;

use app\Utils\Utils;
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;

require_once(dirname(dirname(dirname(__DIR__)))."/Utils/Utils.php");
require_once("Person.php");
require_once("Address.php");

#[Entity(repositoryClass: ClientRepository::class)]
#[Table(name: "`client`")]
class Client extends Person {
    #[Id]
    #[Column(name: "client_id", type:Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $clientId = null;

    #[Column(name: "client_reference", type:Types::STRING, nullable: true)]
    private ?string $clientReference;

    #[OneToMany(targetEntity: Order::class, mappedBy: "client", fetch: "EAGER")]
    private ?Collection $orders = null;

    public function __construct(string $firstName, string $lastName, string $phoneNumber, Address $address, ?string $reference = null) {
        parent::__construct($firstName, $lastName, $phoneNumber, $address);
        $this->setClientReference($reference);
        $this->orders = new ArrayCollection();
    }

    public function getClientId(): ?int {
        return $this->clientId;
    }

    public function getClientReference(): ?string {
        return $this->clientReference;
    }

    public function getOrders(): Collection {
        return $this->orders;
    }

    public function addOrder(Order $order): void {
        if ($order->getOrderId() == null) {
            throw new InvalidArgumentException("The order must be inserted in the database first!");
        }
        $this->orders->add($order);
    }

    public function removeOrder(Order $order): void {
        if ($order->getOrderId() == null) return;
        $this->orders->removeElement($order);
    }

    public function setClientReference(?string $reference): void {
        if ($reference == null) {
            $this->clientReference = null;
            return;
        }
        if (!Utils::validateClientReference($reference)) {
            throw new InvalidArgumentException("The reference is invalid!");
        }
        $this->clientReference = $reference;
    }
}