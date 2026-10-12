
# WorkTrack - Employee Daily Work Update & Performance Evaluation System

## Project Overview

WorkTrack is a web-based employee task management and performance evaluation system developed using Laravel and MySQL. It helps managers allocate tasks, track employee progress, review daily work updates, and evaluate employee performance.

## Key Features

### 1. Employee Task Allocation and Tracking
- Managers can create and assign tasks to employees.
- Tasks include descriptions, priorities, start dates, and due dates.
- Employees can view their assigned tasks and update task status.

### 2. Daily Work Updates
- Employees can submit daily work updates.
- Record completed work, pending work, blockers, and hours spent.
- Managers can review submitted updates.

### 3. Task Completion and Overdue Tracking
- Track To Do, In Progress, and Completed tasks.
- Identify overdue tasks based on their due dates.
- Display task statistics on the dashboard.

### 4. Manager Dashboard and Reports
- Display task summary statistics.
- View employee task progress.
- Track overdue tasks and recent work updates.
- Summarize reported employee work hours.

### 5. Employee Performance Evaluation
- Managers can create employee performance reviews.
- Assign ratings from 1 to 5.
- Record review periods and feedback comments.
- Employees can view their own performance reviews.

### 6. Role-Based Access
- Separate manager and employee experiences.
- Restrict manager-only features to authorized users.
- Limit employees to their own assigned tasks and personal records.

### 7. Employee Directory
- Managers can view employee details and task statistics.

## Technologies Used

- Backend: PHP 8.2, Laravel 12
- Database: MySQL
- Frontend: HTML, CSS, JavaScript, Bootstrap 5
- Template Engine: Laravel Blade
- Development Environment: WAMP Server
- Version Control: Git and GitHub

## Installation and Setup

### Prerequisites

- PHP 8.2 or compatible version required by the project
- Composer
- MySQL or WAMP Server
- Git

### Step 1: Clone the Repository

```bash
git clone https://github.com/Abinaya227/Work_track.git
cd Work_track
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Configure Environment

Create a local environment file.

On Windows Command Prompt:

```bash
copy .env.example .env
```

Update the database settings in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=worktrack_db
DB_USERNAME=root
DB_PASSWORD=
```

Use the correct username and password for your local MySQL configuration.

### Step 4: Create the Database

Create a MySQL database named `worktrack_db` using phpMyAdmin or MySQL.

### Step 5: Generate the Application Key

```bash
php artisan key:generate
```

### Step 6: Run Migrations and Seeders

```bash
php artisan migrate --seed
```

### Step 7: Start the Application

```bash
php artisan serve
```

Open the application at:

http://127.0.0.1:8000

## Security Notes

- Never commit `.env` or real API keys, passwords, or database credentials.
- Use development accounts only for local testing.
- Configure secure credentials and production settings before deployment.

## Project Repository

https://github.com/Abinaya227/Work_track
