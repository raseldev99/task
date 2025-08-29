## Simple Service Booking System

This project is a **Simple Service Booking System** built with Laravel.  
It provides functionality for two types of users: **Customers** and **Admins**.

---

## Features

### Customer
- View available services
- Create new bookings
- View their own bookings

### Admin
- Manage services (create, update, delete)
- View all bookings


## Tech Stack
- **Backend:** Laravel (PHP)
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **API Format:** RESTful JSON responses


1. Clone the repository:
   ```bash
   git clone https://github.com/raseldev99/task.git
   
   cd task
2. Install dependencies:
   ```bash
   composer install
3. Copy .env file and configure your database:
   ```bash
   cp .env.example .env
4. Generate the application key:
   ```bash
   php artisan key:generate
5. Run migrations and seed the database:
   ```bash
   php artisan migrate:fresh --seed
   
6. Start the server:
   ```bash
   php artisan serve

## Login Credentials

#### Admin Account
```
Username: admin@example.com
Password: 12345678
```

#### Customer Account
```
email: customer@example.com
password: 12345678
```

## Example of API Response Output

### Successful Login Response
```json
{
    "success": true,
    "message": "Login Successful",
    "status_code": 200,
    "data": {
        "user": {
            "id": 2,
            "email": "admin@example.com",
            "name": "Admin",
            "role": "admin"
        },
        "token": {
            "token_type": "Bearer",
            "access_token": "8|07t4rh050dWa96b1cVAVKlkmu4U1MMTzjvA0fV7i34788f7a"
        }
    },
    "timestamp": "2025-08-29T17:15:28.753808Z"
}
```

### Validation Error Response
```json
{
    "success": false,
    "message": "The email field is required. (and 1 more error)",
    "status_code": 422,
    "error_code": "VALIDATION_ERROR",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ]
    },
    "timestamp": "2025-08-29T17:18:44.017877Z"
}
```

### Wrong Credentials
```json
{
    "success": false,
    "message": "These credentials do not match our records.",
    "status_code": 401,
    "error_code": "UNAUTHORIZED",
    "timestamp": "2025-08-29T17:19:52.222472Z"
}
```

### List Response With Pagination
```json
{
    "success": true,
    "message": "Data retrieved successfully",
    "status_code": 200,
    "data": [
        {
            "id": 1,
            "name": "Clovis Hill",
            "price": "1000.00",
            "description": "Saepe nobis accusamus",
            "status": "archived"
        },
        {
            "id": 2,
            "name": "Catherine Nikolaus V",
            "price": "1000.00",
            "description": "Voluptas possimus magni in ea.",
            "status": "draft"
        }
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 34,
        "per_page": 3,
        "total": 100,
        "from": 1,
        "to": 3,
        "has_more_pages": true
    },
    "links": {
        "first": "http://task.test/api/admin/services?page=1",
        "last": "http://task.test/api/admin/services?page=34",
        "prev": null,
        "next": "http://task.test/api/admin/services?page=2"
    },
    "timestamp": "2025-08-29T17:20:35.823430Z"
}
```
   
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


