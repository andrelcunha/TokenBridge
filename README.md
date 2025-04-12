## TokenBridge
### Secure JWT-based Authentication & Authorization for Laravel Microservices

_TokenBridge_ is a proof-of-concept project showcasing how to implement and validate **JSON Web Tokens (JWT)** for authentication and authorization in microservice architectures. Built with **Laravel** for the backend and **Vue + Quasar** for the frontend, _TokenBridge_ demonstrates seamless communication between services while ensuring security and scalability.

```tree
TokenBridge/
├── auth-service/         # Authentication service (Laravel)
├── task-service/         # Task management service (Laravel)
├── analytics-service/    # Analytics and reporting service (Laravel)
├── frontend/             # Main frontend app (Vue + Quasar)
├── shared/               # Shared utilities and libraries
├── docker-compose.yml    # Docker setup for all services
└── README.md             # Documentation
```
### Features
- **Authentication Service**: Secure user login and JWT generation.
- **Task Manager Service**: Manage tasks with JWT-based authorization.
- **Analytics Service**: Provide insights and reports with protected endpoints.
- **Frontend**: User-friendly UI to interact with all services.

### Technologies
- **Backend**: Laravel, PHP, Firebase PHP-JWT
- **Frontend**: Vue.js, Quasar Framework
- **Containerization**: Docker

### How it works
 1. **JWT Authentication**: 
 - The authentication service issues JWTs for authenticated users.
 - Other microservices validate tokens, decode claims, and authorize requests.

 2. **Role-Based Access Control (RBAC)**:
 - Tokens include user roles and permissions for fine-grained access control.

 3. **Frontend Integration**:
 - JWTs are stored securely (e.g., HTTP-Only Cookies) and sent with API requests.
___
 ### Running the Project (Docker)
 For quickly testing the application in a production-like environment, you can use Docker Compose:
 #### Steps to run
 1. Clone the Monorepo:
 ```bash
 git clone https://github.com/andrelcunha/tokenbridge.git
 ```
 2. Run All Services:
 ```bash
 docker-compose up --build
 ```
 3. Access:
 - Visit `http://localhost:8080` for the frontend.
 - Backend services are available via REST APIs.
___
### Set Up for Development
If you want to work on the code base, follow these steps:

#### Backend Setup
1. Install dependencies:
- For each Llaravel service (`auth-service`, `task-service`, etc.),  navigate to the folder and run:
 ```bash
 composer install
 ```
 2. Configure Environment Variables:
 - Copy the `.env.example` file to `.env` in each service directory:
 ```bash
 cp .env.example .env
 ```
 - Configure the database connection and JWT settings.
 3. Migrate Database:
 - Run migrations for each service:
 ```bash
 php artisan migrate
 ```
 4. Start Development Servers:
 - Run the built-in Laravel development server for each service:
 ```bash
 php artisan serve
 ```

#### Frontend Setup
 1. Install Dependencies:
 - Navigate to the `frontend/main-frontend` directory and run:
 ```bash
 npm install
 ```
 2. Start the Development Server:
 - Use Quasar CLI to start the frontend:
 ```bash
 quasar dev
 ```
 3. Update Environment Variables:
 - Modify API URLs in the `.env` file to point to local development servers.

 ### Future Enhancements
 - Add refresh token funcionality for extended sessions.
 - Implment caching for analytics queries.
 - Scale microservices independently.
