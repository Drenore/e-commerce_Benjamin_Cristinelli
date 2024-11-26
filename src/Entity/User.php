<?php 

/**
 * Class User
 * 
 * Represents a user with an id, name, email, password, and registration date.
 * Provides methods to get and set user properties, including validation for email and password.
 */
class User {

    /**
     * @var int|null The user ID
     */
    private ?int $id;

    /**
     * @var string The user's name
     */
    private string $name;

    /**
     * @var string The user's email address
     */
    private string $email;

    /**
     * @var string The user's password
     */
    private string $password;

    /**
     * @var DateTime The user's registration date
     */
    private DateTime $registerDate;

    /**
     * User constructor.
     * 
     * @param string $name The user's name
     * @param string $email The user's email address
     * @param string $password The user's password
     */
    public function __construct(string $name, string $email, string $password) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    /**
     * Gets the user's ID.
     * 
     * @return int The user ID
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Sets the user's ID.
     * 
     * @param int $id The user ID
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Gets the user's name.
     * 
     * @return string The user's name
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Sets the user's name.
     * 
     * @param string $name The user's name
     * @throws InvalidArgumentException If the name is empty
     */
    public function setName(string $name): void {
        if (empty($name)) {
            throw new InvalidArgumentException("Name must not be empty.");
        }
        $this->name = $name;
    }

    /**
     * Gets the user's email address.
     * 
     * @return string The user's email address
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Sets the user's email address.
     * 
     * @param string $email The user's email address
     * @throws InvalidArgumentException If the email is invalid
     */
    public function setEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("The email address '$email' is not valid.");
        }
        $this->email = $email;
    }

    /**
     * Gets the user's password.
     * 
     * @return string The user's password
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * Sets the user's password.
     * 
     * @param string $password The user's password
     * @throws InvalidArgumentException If the password is shorter than 8 characters
     */
    public function setPassword(string $password): void {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException("Password must be at least 8 characters long.");
        }
        $this->password = $password;
    }

    /**
     * Gets the user's registration date.
     * 
     * @return DateTime The user's registration date
     */
    public function getRegisterDate(): DateTime {
        return $this->registerDate;
    }

    /**
     * Sets the user's registration date.
     * 
     * @param DateTime $registerDate The user's registration date
     */
    public function setRegisterDate(DateTime $registerDate): void {
        $this->registerDate = $registerDate;
    }

    /**
     * Verifies if the given password matches the user's stored password.
     * 
     * @param string $password The password to verify
     * @return bool True if the passwords match, false otherwise
     */
    public function passwordVerify(string $password): bool {
        if ($this->password != $password) {
            return false;
        }
        return true;
    }

    /**
     * Updates the user's profile with new name, email, and password.
     * 
     * @param string $name The new name
     * @param string $email The new email address
     * @param string $password The new password
     */
    public function updateUserProfile(string $name, string $email, string $password): void {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
    }
}
