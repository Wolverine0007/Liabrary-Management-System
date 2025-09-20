# 📚 Library Management System

A simple web-based Library Management System built using **PHP** and **MySQL**, designed to help manage books, users, and issue records efficiently.

---

## 🚀 Getting Started

Follow the steps below to set up and run the project locally using **XAMPP**.

---

### 🧰 Requirements

- [XAMPP](https://www.apachefriends.org/index.html)
- A modern web browser (Chrome, Firefox, etc.)

---

## 📥 Installation Steps

### 1. Download and Install XAMPP

- Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org).
- Open the **XAMPP Control Panel** after installation.

---

### 2. Download the Project Files

1. Go to the GitHub repository.
2. Click the green **Code** button and select **Download ZIP**.
3. Extract the ZIP file.
4. Rename the extracted folder to `LibraryManagementSystem` (or any name you like).
5. Move the folder to:  
```

C:\xampp\htdocs\LibraryManagementSystem

```

---

### 3. Import the Database

1. In your browser, go to:  
```

[http://localhost/phpmyadmin](http://localhost/phpmyadmin)

````

2. Click **New**, enter a name for your database (e.g., `lms`), and click **Create**.

3. Select the newly created database.

4. Go to the **Import** tab and upload the `lms.sql` file from the project folder.

5. Click **Go** to import the database structure and data.

---

### 4. Configure the Database Connection

In all PHP files that connect to the database, find and edit the line below:

```php
$connection = mysqli_connect("localhost", "root", "", "your_database_name");
````

* Replace `"your_database_name"` with the name of the database you created (e.g., `lms`).

---

## ▶️ Running the Project

1. Open **XAMPP Control Panel**.
2. Start both **Apache** and **MySQL**.

> ⚠️ If either doesn’t start, check Task Manager for port conflicts (e.g., Skype or IIS may be using ports 80 or 3306).

3. Open your browser and navigate to:

```
http://localhost/LibraryManagementSystem/index.php
```

> Replace `LibraryManagementSystem` with the folder name you used in `htdocs`, if different.

---

## 💡 Features

* ✅ User registration and login
* ✅ User profile view and edit
* ✅ Password change functionality
* ✅ Admin dashboard to manage books
* ✅ View issued books and profiles
* ✅ Responsive UI using Bootstrap 4

---

## 🔐 Default Credentials

* There are **no default login credentials**.
* Please register an account using the registration page to log in as a user or admin.

---

## 📁 Project Folder Structure

```
LibraryManagementSystem/
├── admin/
├── bootstrap-4.4.1/
├── images/
├── index.php
├── register.php
├── login.php
├── update.php
├── lms.sql
├── README.md
└── ...
```

---

## 📄 License

This project is licensed under the **MIT License**.

---


## ✏️ Additional Notes

* **Default MySQL credentials:**

  * Username: `root`
  * Password: *(leave blank)*

* If you use PHP short tags (`<?`), make sure they are enabled in your `php.ini`.

* For production use:

  * Change default database credentials
  * Secure user input to prevent SQL injection
  * Use prepared statements
  * Add authentication and role-based access

```
