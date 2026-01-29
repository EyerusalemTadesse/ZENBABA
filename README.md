# ZENBABA
LOCAL E-COMMERCE SITE
Zenbaba Market is inspired by the story of a talented woman who creates beautiful handmade children’s toys using crochet. She moves from shop to shop to sell her products, facing challenges with limited reach, inconsistent sales, and effort to market her work.
Her story reflects a larger reality. Thousands of skilled artisans across Ethiopia create high quality handmade items, yet face limited access to markets.
Zenbaba Bridges this gap - Turning individual creativity into a Trusted, Accessible, and Scalable brand.

# Zenbaba – PHP & MySQL Web Application

## 📌 Description
Zenbaba is a PHP-based web application developed using **XAMPP (Apache & MySQL)** and **Visual Studio Code**.  
The application runs locally on `localhost` and uses a MySQL database for data storage and management.

---

## 🛠️ Technologies Used
- PHP
- MySQL
- Apache (XAMPP)
- HTML5
- CSS3
- JavaScript
- Visual Studio Code

---
## 🚀 Local Setup Instructions (XAMPP)

Follow these steps to get this project running on your local machine using XAMPP.

### 1. Prerequisites
* **XAMPP** installed (Download at [apachefriends.org](https://www.apachefriends.org/))
* **Git** installed (optional, for cloning)

---

### 2. Installation & Directory Setup
1. Open your XAMPP installation directory (usually `C:/xampp` on Windows).
2. Navigate to the `htdocs` folder.
3. Clone this repository or extract the ZIP file into a new folder:
   cd C:/xampp/htdocs
   git clone (https://github.com/EyerusalemTadesse/ZENBABA/) project-folder

Database Setup

Open the XAMPP Control Panel and start Apache and MySQL.

Navigate to http://localhost/phpmyadmin/ in your web browser.

Click on "New" in the left-hand sidebar to create a new database.

Name the database mywebsite_db and click Create.

Select your new database, click the Import tab at the top, and choose the .sql file included in this repository.

Scroll down and click Import (or Go).

Configuration
Update the database connection settings to match your local XAMPP environment. Locate the configuration file (typically config.php, database.php, or .env) and apply the following settings:

PHP
// Example configuration settings
$host = "localhost";
$username = "root";
$password = ""; // XAMPP default is empty
$dbname = "project_db"; // The name you created in Step 3

Running the Application
Once the database is imported and the configuration is saved, you can view the project by typing the following URL into your browser:

http://localhost/zenbaba/

User Registration

To create a new account within the application:

Open the application in your browser and click on the Register

Fill in the required fields (Full Name, Email, Password and phone number).

Click Register.

Upon success, your information will be stored in the users table of your local database.

Accessing the Application

Once registered, you can log in to access the full features of the project:

Navigate to the Login page.

Enter the Email and Password you used during registration.

Click Login to be redirected to the user dashboard.

Testing Credentials 

If you have already imported the .sql file, you can use these default admin credentials to test the system immediately:

Email: - admin@yourdomain.com
Password: - admin123

## 📂 Project Structure
zenbaba/
├── README.md
├── index.php
├── config/
│   └── db.php
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── database/
│   └── mywebsite_db.sql

