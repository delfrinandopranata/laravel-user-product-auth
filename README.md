# Laravel User Project Timesheet Authentication API

This project provides a basic CRUD API with authentication, allowing users to manage projects, timesheets, and other user-related data using secure endpoints. It uses JWT (JSON Web Token) authentication for user management and includes features such as login, registration, and profile management. The project is built with Laravel 9.

## Features

- **User Authentication**: Register, login, logout, refresh tokens, and view authenticated user profile.
- **Project Management**: CRUD operations for managing projects with user assignments.
- **Timesheet Management**: CRUD operations for managing timesheets associated with users and projects.

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
    - Update the environment variables in the `.env` file (e.g., database credentials).

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

7. **Access API Documentation**:
    - Visit: `http://localhost:8000/api/documentation` for Swagger UI.

## Endpoints Overview

### Authentication
- **Login API Response**:
  ```json
  {
    "status": true,
    "message": "Logged In Successfully!",
    "errors": null,
    "data": {
        "access_token": "your_jwt_token",
        "token_type": "bearer",
        "expires_in": 1866240000,
        "user": {
            "id": 1,
            "first_name": "Delfrinando",
            "last_name": "Pranata",
            "date_of_birth": "1989-12-31T18:00:00.000000Z",
            "gender": "male",
            "email": "delfrinando@gmail.com",
            "email_verified_at": null,
            "created_at": "2024-10-12T09:40:22.000000Z",
            "updated_at": "2024-10-12T09:40:22.000000Z"
        }
    }
  }
  ```

- `POST /api/auth/register`: Register a new user.
- `POST /api/auth/login`: Log in and get a JWT token.
- `GET /api/auth/me`: Get the profile of the authenticated user.
- `POST /api/auth/logout`: Log out the authenticated user.

### Projects
- **Project API Response**:
  ```json
  {
    "status": true,
    "message": "Projects fetched successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 12,
                "name": "New Project",
                "department": "IT",
                "start_date": "2024-01-01",
                "end_date": "2024-12-31",
                "status": "in_progress",
                "created_at": "2024-10-12T09:42:10.000000Z",
                "updated_at": "2024-10-12T09:42:10.000000Z",
                "users": [
                    {
                        "id": 1,
                        "first_name": "Delfrinando",
                        "last_name": "Pranata",
                        "date_of_birth": "1989-12-31T18:00:00.000000Z",
                        "gender": "male",
                        "email": "delfrinando@gmail.com",
                        "email_verified_at": null,
                        "created_at": "2024-10-12T09:40:22.000000Z",
                        "updated_at": "2024-10-12T09:40:22.000000Z",
                        "pivot": {
                            "project_id": 12,
                            "user_id": 1,
                            "created_at": "2024-10-12T09:42:10.000000Z",
                            "updated_at": "2024-10-12T09:42:10.000000Z"
                        }
                    }
                ]
            }
        ]
    }
  }
  ```

- `GET /api/projects`: Get a list of projects.
- `POST /api/projects`: Create a new project.
- `GET /api/projects/{id}`: Get details of a specific project.
- `PUT /api/projects/{id}`: Update an existing project.
- `DELETE /api/projects/{id}`: Delete a project.

### Timesheets
- **Timesheet API Response**:
  ```json
  {
    "status": true,
    "message": "Timesheets fetched successfully",
    "data": [
        {
            "id": 1,
            "task_name": "Initial Task",
            "date": "2024-01-01",
            "hours": "8.00",
            "user_id": 1,
            "project_id": 1,
            "created_at": "2024-10-12T09:40:22.000000Z",
            "updated_at": "2024-10-12T09:40:22.000000Z",
            "project": {
                "id": 1,
                "name": "Initial Project",
                "department": "Engineering",
                "start_date": "2024-01-01",
                "end_date": "2024-12-31",
                "status": "in_progress",
                "created_at": "2024-10-12T09:40:22.000000Z",
                "updated_at": "2024-10-12T09:40:22.000000Z"
            }
        }
    ]
  }
  ```

- `GET /api/timesheets`: Get a list of timesheets.
- `POST /api/timesheets`: Create a new timesheet.
- `GET /api/timesheets/{id}`: Get details of a specific timesheet.
- `PUT /api/timesheets/{id}`: Update an existing timesheet.
- `DELETE /api/timesheets/{id}`: Delete a timesheet.

## Step-by-Step Guide to Using the API

1. **Register or Login**: First, you need to register or login to get the authentication token (JWT).

```bash
curl --location 'http://localhost:8000/api/auth/login' \
--header 'Content-Type: application/json' \
--data-raw '{
  "email": "delfrinando@gmail.com",
  "password": "123456",
}'
```
   Example of a successful login response:
   ```json
   {
       "status": true,
       "message": "Logged In Successfully!",
       "data": {
           "access_token": "your_jwt_token",
           "token_type": "bearer",
           "expires_in": 1866240000,
           "user": {
               "id": 1,
               "first_name": "Delfrinando",
               "last_name": "Pranata",
               "email": "delfrinando@gmail.com"
           }
       }
   }
   ```

2. **Set Authorization Header**: After obtaining the `access_token`, include it in the Authorization header for all requests that require authentication.

   Example of setting the Authorization header:
   ```bash
   Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3Mjg3MjYwNjMsImV4cCI6MTczMTMxODA2MywibmJmIjoxNzI4NzI2MDYzLCJqdGkiOiJZNXJxVHRMVGRIQXV4bG5qIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ._-xJnAXDp3MfoVSRk4F6jAPt1e-2HVG3qLE4wVnwglU
   ```

3. **Access Protected Endpoints**: Use the token in the Authorization header to access any protected endpoints, such as fetching project or timesheet data.

4. **Refresh Token**: If your token expires, you can refresh it by using the refresh token endpoint:
   ```bash
   POST /api/auth/refresh
   ```

## License

This project is licensed under the MIT License.

## Author

Developed by Delfrinando Pranata.