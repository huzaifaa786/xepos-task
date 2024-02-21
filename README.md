# Xepos Mini CRM (Test Task Submission)

A web application built with Laravel and Vue.js for managing companies and their employees.

## Features

- **CRUD Functionality**: Perform Create, Read, Update, and Delete operations for companies and employees.
- **Company Management**: Create companies with details such as name, email, logo, and website.
- **Employee Management**: Manage employees with details such as first name, last name, email, phone, and associated company.
- **Database Migrations**: Utilize Laravel's database migrations to define the schema for companies and employees tables.
- **File Storage**: Store company logos in the `storage/app/public` folder and make them accessible from the public directory.
- **Resource Controllers**: Use Laravel's resource controllers to handle CRUD operations for companies and employees.
- **Form Validation**: Utilize Laravel's form request validation for validating input data.
- **Pagination**: Implement Laravel's pagination feature to display lists of companies and employees with a specified number of entries per page.
- **Email Notifications**: Send welcome emails to users when new companies are created, using Laravel observers to trigger email notifications. MailTrap is used for email testing and development purposes.

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/huzaifaa786/xepos-task
    ```

2. Install dependencies:

    ```bash
    cd xepos-task
    composer install
    npm install
    ```

3. Set up your environment variables:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Edit the `.env` file and configure your database connection, mail settings, and any other required environment variables. Make sure to set up MailTrap credentials for email testing.

4. Run database migrations:

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. Link storage directory:

    ```bash
    php artisan storage:link
    ```

6. Serve the application:

    ```bash
    php artisan serve
    ```

7. Visit `http://localhost:8000` in your browser to access the application.

## Usage

- Register and log in to the application.
- Navigate to the Companies section to create, view, update, and delete companies.
- Navigate to the Employees section to manage employees associated with companies.
- Explore the features and functionalities of the application.

## Technologies Used

- **Backend**: Laravel
- **Frontend**: Vue.js with Inertia.js
- **Database**: MySQL (or your preferred database)
- **Package Manager**: Composer, npm
- **Other Tools**: Tailwind CSS, Axios, MailTrap
