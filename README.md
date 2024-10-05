# aes-256-encryption-decryption
# Description
This web application allows users to register, log in, and manage files with encryption and decryption functions. Upon successful login, users are directed to a dashboard that provides navigation for encrypting and decrypting files. User activities, such as login, logout, encryption, and decryption, are logged with information including timestamp, username, filename, and type of activity. The application uses PHP and MySQL as the backend.

# Key Features
* **Registration and Login:** Users can create an account and log into the application. Passwords are securely stored using hashing (password_hash).
* **Dashboard:** After logging in, users are directed to a dashboard that provides navigation for encryption and decryption.
* **Encryption and Decryption:** Utilizes the AES-256 algorithm for file encryption and decryption. Users can upload various types of files to be encrypted and decrypted, and they can download the results.
* **Activity Log:** Each user activity (login, logout, encryption, decryption) is recorded with timestamp, username, and filename information.
* **Data Storage:** User data and activity logs are securely stored in a MySQL database, ensuring data integrity and security.

# Prerequisites
* **Local Server:** XAMPP.
* **PHP:** Version 7.2 or newer.
* **MySQL:** MySQL database to store user data and activity logs.

