<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use  Symfony\Component\Security\Core\User\EquatableInterface;
use  App\Repository\UserRepository;
use App\Entity\Pine;
use Doctrine\ORM\Mapping as ORM;
/**
 * User is the user implementation used by the in-memory user provider.
 *
 * This should not be used for anything else.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated since Symfony 5.3, use {@link InMemoryUser} instead
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{   #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
   private ?int $id = null;
    #[ORM\Column]
    private $username;
	 #[ORM\Column]
    private $password;
	    
	 #[ORM\Column]
	 private $enabled;
	  #[ORM\Column]
    private $accountNonExpired;
	 #[ORM\Column]
    private $credentialsNonExpired;
	 #[ORM\Column]
    private $accountNonLocked;
	 #[ORM\Column]
    private array $roles = [];
	 #[ORM\Column]
    private $extraFields;

  #[ORM\Column(length: 255)]
  private ?string $firstName = null;

  #[ORM\Column(length: 255)]
  private ?string $lastName = null;

  #[ORM\Column(length: 255)]
  private ?string $email = null;

  #[ORM\OneToMany(targetEntity: Pine::class, mappedBy: 'user', orphanRemoval: true)]
  private Collection $pines;

  #[ORM\Column(type: 'boolean')]
  private $isVerified = false;



public function getId(): ?int
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->pines = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return $this->roles;
		$roles[] = 'ROLE_USER';
		 return array_unique($roles);
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): string
    {
        trigger_deprecation('symfony/security-core', '5.3', 'Method "%s()" is deprecated, use getUserIdentifier() instead.', __METHOD__);

        return $this->username;
    }

    /**
     * Returns the identifier for this user (e.g. its username or email address).
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }


    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired(): bool
    {
        return $this->accountNonExpired;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @see LockedException
     */
    public function isAccountNonLocked(): bool
    {
        return $this->accountNonLocked;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired(): bool
    {
        return $this->credentialsNonExpired;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @see DisabledException
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    public function getExtraFields(): array
    {
        return $this->extraFields;
    }

    /**
     * {@inheritdoc}
     */
    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof self) {
            return false;
        }

        if ($this->getPassword() !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        $currentRoles = array_map('strval', (array) $this->getRoles());
        $newRoles = array_map('strval', (array) $user->getRoles());
        $rolesChanged = \count($currentRoles) !== \count($newRoles) || \count($currentRoles) !== \count(array_intersect($currentRoles, $newRoles));
        if ($rolesChanged) {
            return false;
        }

        if ($this->getUserIdentifier() !== $user->getUserIdentifier()) {
            return false;
        }

        if (self::class === static::class) {
            if ($this->isAccountNonExpired() !== $user->isAccountNonExpired()) {
                return false;
            }

            if ($this->isAccountNonLocked() !== $user->isAccountNonLocked()) {
                return false;
            }

            if ($this->isCredentialsNonExpired() !== $user->isCredentialsNonExpired()) {
                return false;
            }
        }

        if ($this->isEnabled() !== $user->isEnabled()) {
            return false;
        }

        return true;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Pine>
     */
    public function getPines(): Collection
    {
        return $this->pines;
    }

    public function addPine(Pine $pine): static
    {
        if (!$this->pines->contains($pine)) {
            $this->pines->add($pine);
            $pine->setUser($this);
        }

        return $this;
    }

    public function removePine(Pine $pine): static
    {
        if ($this->pines->removeElement($pine)) {
            // set the owning side to null (unless already changed)
            if ($pine->getUser() === $this) {
                $pine->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
