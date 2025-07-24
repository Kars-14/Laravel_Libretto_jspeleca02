# Libretto-Sanctum Branch Setup Instructions

## This branch includes Laravel Sanctum Authentication + CRUD

### Features:
- ✅ User registration and login
- ✅ Laravel Sanctum authentication
- ✅ Protected CRUD routes
- ✅ Guest middleware for auth pages
- ✅ Complete Authors, Books, Genres, Reviews CRUD
- ✅ Book-Genre many-to-many relationships
- ✅ Multiple reviews per book

### Required .env Configuration:

```env
# Database settings
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=libretto
DB_USERNAME=root
DB_PASSWORD=your_password

# Session settings
SESSION_DRIVER=file
CACHE_STORE=file

# App settings
APP_NAME="Libretto Sanctum"
APP_ENV=local
APP_DEBUG=true
```

### Setup Commands:

```bash
# 1. Install dependencies
composer install

# 2. Copy environment file
copy .env.example .env

# 3. Generate app key
php artisan key:generate

# 4. Edit .env with your database credentials

# 5. Run migrations and seed
php artisan migrate:fresh --seed

# 6. Clear caches
php artisan config:clear
php artisan cache:clear

# 7. Start server
php artisan serve
```

### Default Login Credentials:
- **Email:** test@example.com
- **Password:** password

### Route Structure:

#### Public Routes:
- `/` - Welcome page
- `/login` - Login form
- `/register` - Registration form

#### Protected Routes (require authentication):
- `/dashboard` - Main dashboard
- `/authors` - Authors CRUD
- `/books` - Books CRUD  
- `/genres` - Genres CRUD
- `/reviews` - Reviews CRUD
- `/books/{book}/reviews` - Add review to specific book

### Key Differences from Libretto Branch:
1. **Authentication required** - Must login to access CRUD
2. **User management** - Registration and login system
3. **Session-based auth** - Uses Laravel Sanctum
4. **Protected routes** - All CRUD behind auth middleware
5. **Guest middleware** - Redirects authenticated users from login/register

### Testing:
1. Visit `/register` to create account
2. Login with credentials
3. Access `/dashboard` to see CRUD interface
4. Test all CRUD operations
5. Test logout functionality
