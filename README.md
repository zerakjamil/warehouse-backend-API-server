<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

---

# Warehouse Management API

This repository contains a simple Warehouse management API built using Laravel v11 and PHP v8.3.1 The API supports basic functionalities like CRUD operations on warehouses and branches, device management, and more, with a focus on scalability, security, and efficiency.

## Table of Contents
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [API Endpoints](#api-endpoints)
- [Logging](#logging)
- [Validation](#validation)
- [Error Handling](#error-handling)
- [Testing](#testing)
- [Dependencies](#dependencies)
- [Best Practices](#best-practices)

## Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/zerakjamil/warehouse-backend-API-server.git
    ```

2. **Navigate to the project directory:**
    ```bash
    cd warehouse-backend-API-server
    ```

3. **Install the dependencies:**
    ```bash
    composer install
    ```

4. **Set up the environment file:**
    ```bash
    cp .env.example .env
    ```


5. **Configure the database in the `.env` file:**

    Update the following lines with your database credentials:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

6. **Run the database migrations:**
    ```bash
    php artisan migrate:fresh --seed
    ```

## Configuration

Ensure you have the following configurations in your `.env` file:

- **Mail Configuration:** For sending emails to the super admin.
- **Queue Configuration:** For handling background jobs (e.g., importing devices from a CSV file).

## Running the Application

Start the Laravel development server:
```bash
php artisan serve
```

Your API will be accessible at `http://localhost:8000`.

## API Endpoints

### Branches
- **GET /branches/{id}**
    - Returns details of a specific branch including name, profile logo, address, date of creation, remaining devices, and sold devices.

### Warehouses
- **GET /warehouse/{id}/branches**
    - Returns all branches related to a specific warehouse.
- **GET /warehouse/{id}/devices**
    - Returns a list of all devices that belong to a specific warehouse.

### Devices
- **GET /devices/search?q={query}**
    - Searches and returns devices by serial number or MAC address.
- **GET /devices/export**
    - Exports all devices to a CSV file.
- **POST /devices/import**
    - Imports devices from a CSV file .

### Custom Commands
- **Export Database:**
    ```bash
    php artisan db:export
    ```
- **Export Devices to JSON:**
    ```bash
    php artisan devices:export-json
    ```

## Logging

All actions are logged in both the database and a log file, capturing who performed the action and when it occurred, along with other relevant details stored in actions.log file.

## Validation

All inputs are fully validated to ensure data integrity and security.

## Error Handling

The API uses structured error handling to provide meaningful error messages and status codes.


## Dependencies

- PHP v8.3.1
- Laravel v11
- MySQL v8.4.0
- Composer v2.7.6

## Best Practices

- **Problem-solving:** Efficient and simple solutions.
- **Code style:** Readable and maintainable code.
- **Security:** Secure coding practices.
- **Scalability:** Designed to scale efficiently.
- **Design patterns:** Use of appropriate design patterns.
- **Code reusability:** Following the DRY principle.
- **Efficiency:** Optimized for performance.

## Documentation

Postman collection : https://api.postman.com/collections/28087875-71ac9f57-71fd-4af1-ab5a-6e52a11b375a?access_key=PMAT-01J0TH612SVJQSFR6MWCP1B8PN

## Notes

- The system is ready for production use.
- Ensure to adhere to the rate limit of 10 requests per minute per user.

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
