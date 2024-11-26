<?php

require_once "User.php";  // Since both Admin.php and User.php are in the same folder


/**
 * Class Admin
 *
 * Represents an admin user with properties such as access level and last connection time.
 * Provides methods for managing users and accessing system logs.
 */
class Admin extends User {

    /**
     * @var int The access level of the admin user
     */
    private int $accessLevel;

    /**
     * @var DateTime The last time the admin user connected
     */
    private DateTime $lastConnection;

    /**
     * Admin constructor.
     *
     * Initializes the Admin object with user details, access level, and last connection time.
     *
     * @param string $name The admin's name
     * @param string $email The admin's email address
     * @param string $password The admin's password
     * @param int $accessLevel The access level of the admin
     * @param DateTime $lastConnection The last time the admin logged in
     */
    public function __construct(string $name, string $email, string $password, int $accessLevel, DateTime $lastConnection) {
        // Call the parent constructor with the name, email, and password parameters
        parent::__construct($name, $email, $password);

        // Initialize the additional properties for Admin
        $this->accessLevel = $accessLevel;
        $this->lastConnection = $lastConnection;
    }

    /**
     * Get the admin's ID.
     *
     * @return int The admin's ID
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Set the admin's ID.
     *
     * @param int $id The admin's ID
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Get the access level of the admin.
     *
     * @return int The access level
     */
    public function getAccessLevel(): int {
        return $this->accessLevel;
    }

    /**
     * Set the access level of the admin.
     *
     * @param int $accessLevel The new access level for the admin
     */
    public function setAccessLevel(int $accessLevel): void {
        $this->accessLevel = $accessLevel;
    }

    /**
     * Get the last connection time of the admin.
     *
     * @return DateTime The last connection time
     */
    public function getLastConnection(): DateTime {
        return $this->lastConnection;
    }

    /**
     * Set the last connection time of the admin.
     *
     * @param DateTime $lastConnection The new last connection time
     */
    public function setLastConnection(DateTime $lastConnection): void {
        $this->lastConnection = $lastConnection;
    }

    /**
     * Manage users in the system (add, modify, delete).
     *
     * @return void
     */
    public function manageUsers(): void {
        // Method to manage users (empty for now)
    }

    /**
     * Access system logs for auditing purposes.
     *
     * @return array An array of system logs
     */
    public function accessSystemLogs(): array {
        // Return logs as an array (empty for now)
        return [];
    }
}
?>
