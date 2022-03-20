<?php

declare(strict_types=1);

namespace App\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class VerifyCode
{
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private string $code;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private \DateTimeImmutable $expiresAt;

    public function __construct(string $code, \DateTimeImmutable $expiresAt)
    {
        $this->code = $code;
        $this->expiresAt = $expiresAt;
    }

    /**
     * @param \DateTimeImmutable $now
     * @return bool
     */
    public function isValid(\DateTimeImmutable $now): bool
    {
        return $this->expiresAt >= $now;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

}