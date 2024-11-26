<?php

/**
 * Class User
 * 
 * Abstract class representing a user with common properties such as ID, name, email, and password.
 * Provides methods for validating and managing user data.
 */
abstract class User {

    /**
     * @var int|null The user ID
     */
    protected ?int $id;

    /**
     * @var string The user's name
     */
    protected string $name;

    /**
     * @var string The user's email address
     */
    protected string $email;

    /**
     * @var string The user's password
     */
    protected string $password;

    /**
     * @var DateTime The user's registration date
     */
    protected DateTime $registerDate;

   /**
     * Constructor for the User class.
     *
     * @param string $name The user's name
     * @param string $email The user's email address
     * @param string $password The user's password
     */
    public function __construct(string $name, string $email, string $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->registerDate = new DateTime(); // Automatically set the registration date to the current date
    }

    /**
     * Abstract method to get the user ID.
     * 
     * @return int The user ID
     */
    abstract public function getId(): int;

    /**
     * Abstract method to set the user ID.
     * 
     * @param int $id The user ID
     */
    abstract public function setId(int $id): void;

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
        return $this->password === $password;
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
?>
