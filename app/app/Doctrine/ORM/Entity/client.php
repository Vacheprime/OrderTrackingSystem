<?php

declare(strict_types = 1);

namespace app\Doctrine\ORM\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;

use app\Utils\Utils;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use InvalidArgumentException;

require_once(dirname(__DIR__)."/core/utils/utils.php");
require_once("person.php");
require_once("address.php");

#[Entity]
#[Table(name: "`client`")]
class Client extends Person {

    #[Id]
    #[Column(name: "client_id", type:Types::INTEGER), GeneratedValue("AUTO")]
    private ?int $clientId = null;

    #[Column(name: "client_reference", type:Types::STRING)]
    private ?string $clientReference;

    public function __construct(string $firstName, string $lastName, string $phoneNumber, Address $address, ?string $reference = null) {
        parent::__construct($firstName, $lastName, $phoneNumber, $address);
        $this->setClientReference($reference);
    }

    public function getClientId(): ?int {
        return $this->clientId;
    }

    public function getClientReference(): string {
        return $this->clientReference;
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