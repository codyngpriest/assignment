-- Create the products table
CREATE TABLE products (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  sku VARCHAR(50) NOT NULL,
  name VARCHAR(100) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  type VARCHAR(50) NOT NULL
);

-- Create the dvd_products table
CREATE TABLE dvd_products (
  id INT(11) UNSIGNED PRIMARY KEY,
  size INT(11),
  FOREIGN KEY (id) REFERENCES products(id) ON DELETE CASCADE
);

-- Create the book_products table
CREATE TABLE book_products (
  id INT(11) UNSIGNED PRIMARY KEY,
  weight DECIMAL(10, 2),
  FOREIGN KEY (id) REFERENCES products(id) ON DELETE CASCADE
);

-- Create the furniture_products table
CREATE TABLE furniture_products (
  id INT(11) UNSIGNED PRIMARY KEY,
  height DECIMAL(10, 2),
  width DECIMAL(10, 2),
  length DECIMAL(10, 2),
  FOREIGN KEY (id) REFERENCES products(id) ON DELETE CASCADE
);

