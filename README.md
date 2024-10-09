# FoodFarm 🥕🛒

FoodFarm is an e-commerce application built with vanilla PHP that enables users to perform CRUD (Create, Read, Update, Delete) operations on products. It serves as a foundation for managing an online shop, offering a seamless experience for product management.

## Features 🌟

- **User-Friendly Interface:** Intuitive navigation for easy interaction. 👩‍💻
  
- **CRUD Operations:** Fully functional product management including:
  
  - ➕ Add new products
  - 🛍️ View product listings
  - ✏️ Edit existing products
  - ❌ Delete products
  
- **Responsive Design:** Accessible across various devices and screen sizes. 📱💻
  
- **Custom Components:** Modular design for enhanced functionality. ⚙️

## Installation ⚙️

1. Clone the repository:
   
   ```bash
   git clone https://github.com/Joselay/FoodFarm.git
   ```

2. Navigate to the project directory:
   
   ```bash
   cd FoodFarm
   ```

3. Set up a local server (e.g., XAMPP, MAMP, WAMP) and place the project folder in the htdocs directory. In this project, we'll use WAMP.
   
4. Access the application via your web browser:

   ```bash
   http://localhost/FoodFarm
   ```

## Database Dump 💾

The project includes a SQL dump file for setting up the database. You can import this file into your MySQL server to create the necessary tables and sample data.

### Database Dump File

- **Filename:** `foodfarm_database_dump.sql`
- **Description:** This SQL script creates the `FoodFarm` database and the `products` table, along with some sample data.
- **Usage:**
  1. Open your MySQL command line or a tool like phpMyAdmin. 🖥️
  2. Import the `foodfarm_database_dump.sql` file to set up the database structure and sample data.

### Importing the Database

You can import the SQL dump using the following command in the MySQL command line:

```bash
mysql -u username -p < path/to/foodfarm_database_dump.sql
```

## Usage 🛠️

- Use the “Add Product” feature to create new product entries. ➕
- View all products in the “Product List” section. 🛒
- Edit existing products as necessary. ✏️
- Delete products that are no longer available. ❌

## Contributing 🤝

Contributions are welcome! If you’d like to contribute to the project, please fork the repository and submit a pull request.

## Author ✍️

- Joselay: [GitHub](https://github.com/Joselay)
- Sokhen: [GitHub](https://github.com/simsokhen70)

## License 📄

This project is open-source and available under the MIT License.
