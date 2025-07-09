# 📚 Laravel Libretto - Book Management System

A comprehensive book management system built with Laravel 11 and Sanctum authentication, featuring both web interface and REST API endpoints.

## ✨ Features

### 🔐 **Dual Authentication System**
- **Web Authentication**: Session-based login with beautiful UI
- **API Authentication**: Laravel Sanctum with 24-hour token expiration
- **Auto Token Management**: Automatic token regeneration and cleanup
- **Security**: Single active token per user, secure logout

### 📖 **Book Management**
- **Authors**: Manage book authors with relationships
- **Books**: Full book catalog with author and genre associations
- **Genres**: Categorize books by genres
- **Reviews**: Book reviews and ratings

### 🎨 **Modern UI**
- **Responsive Design**: Built with Tailwind CSS
- **Dashboard**: Statistics and quick navigation
- **Clean Interface**: User-friendly forms and layouts

### 🚀 **API Features**
- **RESTful API**: Complete CRUD operations
- **Token Authentication**: Secure API access
- **JSON Responses**: Structured API responses
- **Error Handling**: Comprehensive error management

## 🛠️ **Technology Stack**

- **Backend**: Laravel 11 (PHP 8.4+)
- **Authentication**: Laravel Sanctum
- **Database**: MySQL
- **Frontend**: Blade Templates + Tailwind CSS
- **API**: RESTful with JSON responses

## 📋 **Requirements**

- PHP 8.4 or higher
- Composer
- MySQL 5.7+ or 8.0+
- Node.js & NPM (for asset compilation)

## 🚀 **Installation**

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/laravel-libretto.git
cd laravel-libretto
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies (if using Vite)
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=libretto
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Start Development Server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 🌐 **Usage**

### **Web Interface**
- **Login**: `http://localhost:8000/login`
- **Register**: `http://localhost:8000/register`
- **Dashboard**: `http://localhost:8000/dashboard`

**Test Credentials:**
- Email: `test@example.com`
- Password: `password`

### **API Endpoints**

#### **Authentication**
```bash
# Login
POST /api/login
{
    "email": "test@example.com",
    "password": "password"
}

# Register
POST /api/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}

# Logout
POST /api/logout
# Requires: Authorization: Bearer {token}
```

#### **CRUD Operations** (All require authentication)
```bash
# Authors
GET    /api/authors           # List all authors
POST   /api/authors           # Create author
GET    /api/authors/{id}      # Get specific author
PUT    /api/authors/{id}      # Update author
DELETE /api/authors/{id}      # Delete author

# Books
GET    /api/books             # List all books
POST   /api/books             # Create book
GET    /api/books/{id}        # Get specific book
PUT    /api/books/{id}        # Update book
DELETE /api/books/{id}        # Delete book

# Genres
GET    /api/genres            # List all genres
POST   /api/genres            # Create genre
GET    /api/genres/{id}       # Get specific genre
PUT    /api/genres/{id}       # Update genre
DELETE /api/genres/{id}       # Delete genre

# Reviews
GET    /api/reviews           # List all reviews
POST   /api/reviews           # Create review
GET    /api/reviews/{id}      # Get specific review
PUT    /api/reviews/{id}      # Update review
DELETE /api/reviews/{id}      # Delete review
```

## 🔒 **Authentication Details**

### **Token Management**
- **Expiration**: Tokens expire after 24 hours
- **Auto-Renewal**: New login generates fresh token
- **Cleanup**: Old tokens are automatically revoked
- **Security**: Each user can have only one active token

### **API Usage**
Include the token in your requests:
```bash
curl -H "Authorization: Bearer your-token-here" \
     -H "Content-Type: application/json" \
     http://localhost:8000/api/books
```

## 📁 **Project Structure**

```
app/
├── Http/Controllers/
│   ├── Api/              # API Controllers
│   │   ├── AuthController.php
│   │   ├── AuthorController.php
│   │   ├── BookController.php
│   │   ├── GenreController.php
│   │   └── ReviewController.php
│   └── Web/              # Web Controllers
│       ├── AuthController.php
│       └── DashboardController.php
├── Models/
│   ├── Author.php
│   ├── Book.php
│   ├── Genre.php
│   ├── Review.php
│   └── User.php
resources/views/
├── auth/                 # Authentication views
├── dashboard/            # Dashboard views
└── layouts/              # Layout templates
routes/
├── api.php              # API routes
└── web.php              # Web routes
```

## 🤝 **Contributing**

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 **License**

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🙏 **Acknowledgments**

- Laravel Framework
- Laravel Sanctum
- Tailwind CSS
- PHP Community

## 📞 **Support**

If you encounter any issues or have questions, please open an issue on GitHub.

---

**Built with ❤️ using Laravel & Sanctum**

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
