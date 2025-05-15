# PHP API Boilerplate

A simple, framework-free PHP API boilerplate designed to help you quickly build robust RESTful APIs. This project provides a clean architecture with clear separation of concerns, making it easy to scale and maintain.

## Features

- **No frameworks required:** Pure PHP, giving you full control.
- **MVC-inspired structure:** Organize your code into controllers, services, and models.
- **Reusable utilities:** Includes request/response handling, logging, and validation.
- **Middleware support:** Easily add authentication, CORS, and other middleware.
- **Simple routing:** Define your API endpoints in a centralized place.

## Technologies Used

- **PHP 7.4+**: Core language for backend logic.
- **PDO**: Secure database access.
- **Composer**: Dependency management (optional, for adding packages).
- **.htaccess**: URL rewriting for clean endpoints.

## Folder Structure

```
api/
├── config/
│   ├── Database.php        # Database connection settings
│   └── Config.php          # General configuration
├── controllers/
│   ├── UserController.php  # Handles user-related endpoints
│   └── ProductController.php
├── models/
│   ├── User.php            # User data model
│   └── Product.php
├── services/
│   ├── UserService.php     # Business logic for users
│   └── ProductService.php
├── utils/
│   ├── Request.php         # HTTP request handling
│   ├── Response.php        # HTTP response formatting
│   ├── Logger.php          # Simple logging utility
│   └── Validator.php       # Input validation
├── routes/
│   ├── Router.php          # Core routing logic
│   └── api.php             # API route definitions
├── middleware/
│   ├── AuthMiddleware.php  # Authentication middleware
│   └── CorsMiddleware.php  # CORS handling
├── bootstrap.php           # App initialization
├── index.php               # Entry point
└── .htaccess               # URL rewriting rules
```

## Getting Started

1. **Clone the repository**
2. **Configure your database in `config/Database.php`**
3. **Set up your web server to point to `api/index.php`**
4. **Start building your API endpoints in the `controllers` and `routes` folders**

## License

MIT

