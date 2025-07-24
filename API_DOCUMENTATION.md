# Libretto Sanctum API Documentation

## Base URL
```
http://127.0.0.1:8000/api
```

## Authentication
The API uses Laravel Sanctum for authentication. Include the token in the Authorization header:
```
Authorization: Bearer {your_token}
```

## Token Management Features
- ✅ **Token Reuse**: Won't generate new token if current one isn't expired
- ✅ **Token Expiration**: Tokens expire after 24 hours
- ✅ **Smart Login**: Returns existing token info if still valid

---

## 🔐 Authentication Endpoints

### 1. Register User
**POST** `/api/register`

**Body (JSON):**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response:**
```json
{
    "status": "success",
    "message": "User registered successfully",
    "user": {...},
    "token": "1|xxxxx",
    "token_expires_at": "2024-07-25T08:00:00.000000Z"
}
```

### 2. Login User
**POST** `/api/login`

**Body (JSON):**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (New Token):**
```json
{
    "status": "success",
    "message": "Login successful",
    "user": {...},
    "token": "2|xxxxx",
    "token_expires_at": "2024-07-25T08:00:00.000000Z"
}
```

**Response (Existing Token):**
```json
{
    "status": "success",
    "message": "Using existing valid token",
    "user": {...},
    "token_expires_at": "2024-07-25T08:00:00.000000Z",
    "note": "Your existing token is still valid. Use your previous token."
}
```

### 3. Get Current User
**GET** `/api/user`
**Headers:** `Authorization: Bearer {token}`

### 4. Logout
**POST** `/api/logout`
**Headers:** `Authorization: Bearer {token}`

---

## 📚 Authors API

### List Authors
**GET** `/api/authors`

### Create Author
**POST** `/api/authors`
```json
{
    "name": "Stephen King"
}
```

### Get Author
**GET** `/api/authors/{id}`

### Update Author
**PUT** `/api/authors/{id}`
```json
{
    "name": "Stephen Edwin King"
}
```

### Delete Author
**DELETE** `/api/authors/{id}`

---

## 📖 Books API

### List Books
**GET** `/api/books`

### Create Book
**POST** `/api/books`
```json
{
    "title": "The Shining",
    "author_id": 1,
    "description": "A horror novel",
    "publication_year": 1977,
    "isbn": "978-0-385-12167-5",
    "genre_ids": [1, 3]
}
```

### Get Book
**GET** `/api/books/{id}`

### Update Book
**PUT** `/api/books/{id}`

### Delete Book
**DELETE** `/api/books/{id}`

### 🔥 Get Reviews by Book ID
**GET** `/api/books/{id}/reviews`

**Response:**
```json
{
    "status": "success",
    "data": {
        "book": {
            "id": 1,
            "title": "The Shining",
            "author": {...},
            "genres": [...]
        },
        "reviews": [
            {
                "id": 1,
                "reviewer_name": "John Doe",
                "comment": "Great book!",
                "rating": 5,
                "created_at": "2024-07-24T10:00:00.000000Z"
            }
        ],
        "reviews_count": 1
    }
}
```

---

## 🏷️ Genres API

### List Genres
**GET** `/api/genres`

### Create Genre
**POST** `/api/genres`
```json
{
    "name": "Horror",
    "description": "Scary and suspenseful stories"
}
```

### Get Genre
**GET** `/api/genres/{id}`

### Update Genre
**PUT** `/api/genres/{id}`

### Delete Genre
**DELETE** `/api/genres/{id}`

---

## ⭐ Reviews API

### List Reviews
**GET** `/api/reviews`

### Create Review
**POST** `/api/reviews`
```json
{
    "book_id": 1,
    "reviewer_name": "Jane Smith",
    "comment": "Amazing book, couldn't put it down!",
    "rating": 5
}
```

### Get Review
**GET** `/api/reviews/{id}`

### Update Review
**PUT** `/api/reviews/{id}`

### Delete Review
**DELETE** `/api/reviews/{id}`

---

## 🧪 Postman Testing Steps

### 1. Authentication Flow
1. **Register** a new user or **Login** with existing credentials
2. **Copy the token** from response
3. **Set up Authorization** in Postman:
   - Type: Bearer Token
   - Token: {your_copied_token}

### 2. Test Token Reuse
1. Login once and get token
2. Login again immediately
3. Verify you get "Using existing valid token" message
4. Use the same token for subsequent requests

### 3. Test All CRUD Operations
1. Create authors, books, genres
2. Associate books with authors and genres
3. Add reviews to books
4. Test the special endpoint: `GET /api/books/{id}/reviews`

### 4. Error Handling
- Try accessing protected routes without token (401)
- Try invalid credentials (401)
- Try invalid data (422)

---

## 📋 Sample Test Data

### Test User
```json
{
    "email": "test@example.com",
    "password": "password"
}
```

### Sample Author
```json
{
    "name": "Stephen King"
}
```

### Sample Genre
```json
{
    "name": "Horror",
    "description": "Scary and suspenseful stories"
}
```

### Sample Book
```json
{
    "title": "The Shining",
    "author_id": 1,
    "description": "A psychological horror novel",
    "publication_year": 1977,
    "isbn": "978-0-385-12167-5",
    "genre_ids": [1]
}
```

### Sample Review
```json
{
    "book_id": 1,
    "reviewer_name": "Book Lover",
    "comment": "Absolutely terrifying and brilliantly written!",
    "rating": 5
}
```

## 🚀 Quick Start Commands

```bash
# Start the server
php artisan serve

# Run migrations and seed
php artisan migrate:fresh --seed

# Clear caches
php artisan config:clear
php artisan route:clear
```

Your API will be available at `http://127.0.0.1:8000/api`!
