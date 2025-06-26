+# Diary-farm-Management-system-in-Php
**1. Download and Install XAMPP
      **Download XAMPP from the official website: https://www.apachefriends.org.
      **Install XAMPP on your computer.

**2. Start XAMPP Control Panel
      **Open the XAMPP Control Panel.
      Start Apache (for PHP) and MySQL (for database) services.

3. Place Your PHP Project in the htdocs Folder
      Locate the XAMPP installation directory (default is usually C:\xampp on Windows).
      Navigate to the htdocs folder inside the XAMPP directory.
      Copy your PHP project folder and paste it into the htdocs directory. Example: C:\xampp\htdocs\YourProjectFolder

4. Create a Database (If Needed)
      Open a web browser and go to http://localhost/phpmyadmin/.
      Create a new database for your project:
      Click Databases.
      Enter the database name (dairyfarm_management).
      Click Create.

5. Configure Database Connection
Open your project's database connection file (db_connect.php).
Ensure the credentials match your XAMPP setup:
                  
                  $servername = "localhost";
                  $username = "root";
                  $password = "";
                  $dbname = "dairyfarm_management";
                  
                  $conn = new mysqli($servername, $username, $password, $dbname);
                  
                  if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                  }
6. Access the Project in the Browser
Open a browser and navigate to your project by typing:

                http://localhost/YourProjectFolder/
                a) Login
                i) Admin Dashboard( Username: Admin, Password: admin)
                ii) Employee Dashboard ( Username: employee, Password: password)
                iii) Veterinarian Dashboard (Username: veterinarian, Password: password)

If you have a specific file to load first, add it to the URL:

http://localhost/YourProjectFolder/

7. Test the Project
    Ensure all dependencies are working and the project is running correctly.
    Check for errors and resolve them.**

![image](https://github.com/user-attachments/assets/2e0f27eb-b3a2-4165-ad40-1873edbf1135)


