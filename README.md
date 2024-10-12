# Laravel User Project Timesheet Authentication API

This project provides a basic API with authentication, allowing users to manage projects, timesheets, and other user-related data using secure endpoints. It uses JWT (JSON Web Token) authentication for user management and includes features such as login, registration, and profile management. The project is built with Laravel 9.

## Features

- **User Authentication**: Register, login, logout, refresh tokens, and view authenticated user profile.
- **Project Management**: Add, update, view, and delete projects, with the ability to assign users.
- **Timesheet Management**: Record, update, view, and delete timesheets for users and projects.

## Technologies Used

- Laravel 9
- JWT Authentication
- L5 Swagger for API documentation
- MySQL database
- PHP 8.0+
- Composer

## API Documentation

The API documentation is generated with Swagger and can be accessed via the following URL:
[Swagger API Documentation](http://localhost:8000/api/documentation)

![alt text](image.png)

## Installation

1. **Clone the repository**:
    ```bash
    git clone https://github.com/delfrinandopranata/laravel-user-product-auth.git
    cd laravel-user-product-auth
    ```

2. **Install dependencies**:
    ```bash
    composer install
    ```

3. **Configure environment**:
    - Copy the `.env.example` file and rename it to `.env`.
    - Update the environment variables in the `.env` file with your database credentials and other necessary configurations.
    - Make sure to create the database before running migrations.

4. **Generate application key**:
    ```bash
    php artisan key:generate
    ```

5. **Run database migrations and seeders**:
    ```bash
    php artisan migrate --seed
    ```

6. **Run the application**:
    ```bash
    php artisan serve
    ```

7. **Visit the homepage**:
    - Access the project homepage by visiting `http://127.0.0.1:8000/`.

8. **Access API Documentation**:
    - Visit: `http://localhost:8000/api/documentation` for Swagger UI.

## Sample Request

Here is an example of a `POST` request using cURL to log in and get a token:

```bash
curl --location 'http://localhost:8000/api/auth/login' \
--header 'Content-Type: application/json' \
--data-raw '{
  "email": "delfrinando@gmail.com",
  "password": "123456"
}'
```

sample for timesheets

```bash
curl --location --request GET 'http://localhost:8000/api/timesheets' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3Mjg3MjYwNjMsImV4cCI6MTczMTMxODA2MywibmJmIjoxNzI4NzI2MDYzLCJqdGkiOiJZNXJxVHRMVGRIQXV4bG5qIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ._-xJnAXDp3MfoVSRk4F6jAPt1e-2HVG3qLE4wVnwglU' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data '{
  "name": "New Project",
  "department": "IT",
  "start_date": "2024-01-01",
  "end_date": "2024-12-31",
  "status": "in_progress",
  "user_ids": [
    1,
    2,
    3
  ]
}'
```

## Endpoints Overview

### Authentication
- `POST /api/auth/register`: Register a new user.
- `POST /api/auth/login`: Log in and get a JWT token.
- `GET /api/auth/me`: Get the profile of the authenticated user.
- `POST /api/auth/logout`: Log out the authenticated user.

### Projects
- `GET /api/projects`: Get a list of projects.
- `POST /api/projects`: Create a new project.
- `GET /api/projects/{id}`: Get details of a specific project.
- `PUT /api/projects/{id}`: Update an existing project.
- `DELETE /api/projects/{id}`: Delete a project.

### Timesheets
- `GET /api/timesheets`: Get a list of timesheets.
- `POST /api/timesheets`: Create a new timesheet.
- `GET /api/timesheets/{id}`: Get details of a specific timesheet.
- `PUT /api/timesheets/{id}`: Update an existing timesheet.
- `DELETE /api/timesheets/{id}`: Delete a timesheet.

## Authorization Example

To access the protected routes, you need to authenticate using the **Authorization** header. After logging in and receiving the token, include it in your API requests:

```bash
Authorization: Bearer <your-token-here>
```

Example:
```bash
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3Mjg3MjYwNjMsImV4cCI6MTczMTMxODA2MywibmJmIjoxNzI4NzI2MDYzLCJqdGkiOiJZNXJxVHRMVGRIQXV4bG5qIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ._-xJnAXDp3MfoVSRk4F6jAPt1e-2HVG3qLE4wVnwglU
```

## License

This project is licensed under the MIT License.

## Author

Developed by Delfrinando Pranata.