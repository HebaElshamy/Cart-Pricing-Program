# Cart Pricing Program
## Overview
This project presents a comprehensive solution for managing a shopping cart service, covering both the back-end and front-end aspects. Its purpose is to address the need for a robust and scalable system that enables users to seamlessly interact with their shopping carts. The focus is on delivering a user-friendly and efficient shopping experience.
## Description
This project addresses the challenge of pricing a cart of products with different shipping rates, discounts, and VAT. The solution is a PHP (Laravel+MySql) backend application that calculates the total cost, applies discounts, and generates a detailed invoice in USD.
## Solution Overview
- Problem: Pricing a cart with various products, each with different shipping fees, discounts, and VAT.
- Solution: Developed a PHP application using Laravel, adhering to Object-Oriented (OO) fundamentals, SOLID principles, and utilizing pre-defined design patterns.
## Features
- Accepts multiple products from different countries.
- Combines special offers and calculates discounts.
- Displays a detailed invoice in USD, including subtotal, shipping fees, VAT, and applicable discounts.
### Backend Highlights:
- **Comprehensive Logic**: The backend houses the core logic for cart pricing, ensuring accuracy and reliability.
- **Object-Oriented Design**: Leveraging OO fundamentals enhances code organization and readability.
- **Scalability**: The chosen technologies and design patterns allow for seamless scalability to accommodate future enhancements.
- **Layered Service Design**: The application follows a layered service design pattern, promoting modular development and ease of maintenance.
While the frontend utilizes jQuery and AJAX to enhance user interactions, the primary focus remains on delivering a robust backend solution. This choice aims to provide a foundation for a scalable and extendable system, ensuring a positive and efficient user experience.
## Technical Choices
- **Language/Framework**: PHP (Laravel+MySql) for backend development.
- **Frontend Interaction**: Utilized jQuery and AJAX to handle asynchronous requests, providing a seamless user experience without the need for page refresh.
- **Design Patterns**: Employed a layered service design pattern, adhering to Object-Oriented (OO) fundamentals, SOLID principles.
## How to Run the Program
1. Clone the repository.
  ```bash
   git clone https://github.com/HebaElshamy/Cart-Pricing-Program.git
2.  Install project dependencies using Composer:

   ```bash
   composer install
3. Copy the .env.example file and rename it to .env:
    ```bash
    cp .env.example .env
4. Generate the application key:
    ```bash
    php artisan key:generate
5. Configure the .env file with your database connection details   
6. Run the database migrations to create tables:
    ```bash
    php artisan migrate
7. Populate the database with the required data.
    ```bash
    php artisan db:seed   
8. Start the local server:
    ```bash
    php artisan serve  
9. Open the project in the browser at http://localhost:8000. 
10. To login as an user, use the following credentials:
    Email: user1@example.com
    Password: 123456789
    - or
    Email: user2@example.com
    Password: 123456789
11. Enjoy your experience!
## Review Guidelines
This project adheres to industry best practices, including:
- Object-Oriented fundamentals.
- SOLID principles.
- Well-structured and commented code.
- Error handling.




