# Laravel Smart Order API

An order management and discount calculation API built with **Laravel 10**. This project enables businesses to manage orders with a flexible discount system using SOLID principles, service-oriented architecture, and design patterns for clean, maintainable code.

---

## Features

- **Versioning**:
    - The API follows versioning conventions (/v1/) for backward compatibility and future updates.

- **Order Management**:
    - Create new orders with customer information and product items
    - List all orders with detailed information
    - View specific order details
    - Delete orders
    - Stock validation to prevent ordering unavailable products

- **Smart Discount System**:
    - Implements the Strategy pattern for flexible discount rules
    - Calculates discounts based on various conditions:
        - Percentage discount on orders above a certain amount
        - Buy X Get Y Free for products in specific categories
        - Percentage discount on the cheapest product when buying multiple products from a specific category
    - Easily extendable architecture for additional discount rules

- **Clean Architecture**:
    - Repository pattern for data access
    - Service layer for business logic
    - SOLID principles implementation
    - Standardized API responses

- **Validation**:
    - Robust input validation for all requests
    - Meaningful error messages

- **Postman Collection & Environment**:
    - Predefined Postman collection and environment files available in resources/docs/postman/ for quick API testing

---

## Technologies Used

- **Backend**: Laravel 10 (PHP 8.1+)
- **Database**: MySQL
- **ORM**: Eloquent ORM
- **API Design**: RESTful API with versioning (/v1/)
- **Validation**: Laravel Request Validation
- **Design Patterns**: Repository, Service, Strategy patterns
- **Documentation**: Postman collection and environment

---

## Project Architecture

- **API Response Structure**: Standardized responses using `ApiResponse` trait for consistent success & error handling
- **Service Layer**: Business logic contained in `App\Services` (e.g., `OrderService`, `DiscountService`)
- **Repository Layer**: Data access through `App\Repositories` interfaces and implementations
- **Strategy Pattern**: Discount rules implemented as strategies in `App\Services\Discounts\Strategies`
- **Exception Handling**: Centralized exception handling in `App\Exceptions\Handler.php`
- **Middleware**: Custom middleware for request/response handling

---

## Project Structure

The project follows a layered architecture with clear separation of concerns:

- **Models**: Represent database entities with relationships
- **Repositories**: Handle data access and persistence
- **Services**: Contain business logic and orchestrate operations
- **Controllers**: Handle HTTP requests and responses
- **Requests**: Validate incoming data
- **Discount Strategies**: Encapsulate discount calculation logic
- **Documentation**:
    - Postman collection: resources/docs/postman/laravel-smart-order-api.postman_collection.json
    - Postman environment: resources/docs/postman/laravel-smart-order-api.postman_environment.json
    - Example data: resources/docs/example-data/

---

## API Endpoints

### Orders
- **GET /api/v1/orders**: List all orders
- **GET /api/v1/orders/{id}**: Get details of a specific order
- **POST /api/v1/orders**: Create a new order
- **DELETE /api/v1/orders/{id}**: Delete an order

### Discounts
- **GET /api/v1/discounts/{orderId}**: Calculate discounts for a specific order

---

## Setup & Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL or another database supported by Laravel

### Step 1: Clone the Repository

```bash
git clone https://github.com/your-username/laravel-smart-order-api.git
cd laravel-smart-order-api
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Configure Environment Variables

Copy the `.env.example` file to `.env` and update the database credentials:

```bash
cp .env.example .env
php artisan key:generate
```

Edit the `.env` file with your database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_order
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Run Migrations and Seeders

```bash
php artisan migrate --seed
```

This will create the necessary database tables and populate them with example data.

### Step 5: Start the Development Server

```bash
php artisan serve
```

By default, the API will be available at `http://localhost:8000/api/v1/`.

---

## API Usage Examples

### Create a New Order

**Request:**
```bash
POST /api/v1/orders
```

**Body:**
```json
{
  "customer_id": 1,
  "items": [
    {
      "product_id": 102,
      "quantity": 10
    },
    {
      "product_id": 100,
      "quantity": 2
    }
  ]
}
```

### Calculate Discounts for an Order

**Request:**
```bash
GET /api/v1/discounts/3
```

**Response:**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "orderId": 3,
    "discounts": [
      {
        "discountReason": "BUY_5_GET_1",
        "discountAmount": "11.28",
        "subtotal": "1263.90"
      },
      {
        "discountReason": "10_PERCENT_OVER_1000",
        "discountAmount": "127.51",
        "subtotal": "1136.39"
      }
    ],
    "totalDiscount": "138.79",
    "discountedTotal": "1136.39"
  }
}
```

---

## Postman Collection

The project includes a complete Postman collection and environment for testing all API endpoints. You can find these files in:

- Collection: `resources/docs/postman/laravel-smart-order-api.postman_collection.json`
- Environment: `resources/docs/postman/laravel-smart-order-api.postman_environment.json`

Import these files into Postman to quickly test the API.

---

## Architecture Details

### Discount Strategy Implementation

The project uses the Strategy pattern to implement various discount rules:

1. **TotalAmountDiscount**: Percentage discount on orders above a certain amount
2. **CategoryQuantityDiscount**: Buy X Get Y Free for products in specific categories
3. **CategoryMultipleItemsDiscount**: Percentage discount on the cheapest product when buying multiple items from a specific category

New discount strategies can be easily added by:
1. Creating a new class that implements `DiscountStrategyInterface`
2. Implementing the `apply()` and `getReason()` methods
3. Registering the strategy in `AppServiceProvider`

---

## Why This Project?

This project demonstrates my approach to building maintainable and extensible APIs using Laravel. It showcases:

- Implementation of design patterns like Strategy, Repository, and Service
- SOLID principles in action
- Clean code practices
- Thoughtful API design
- Flexible architecture that allows for easy extension

---

## Future Enhancements

Potential enhancements for future versions:
- Authentication and authorization
- Custom discount rules per customer or customer group
- Product and category management endpoints
- Performance optimizations for discount calculations
- More sophisticated order management features
- Reporting and analytics
- Integration with payment gateways

---

## Contact

- Website: [www.ferzendervarli.com](https://www.ferzendervarli.com/)
- GitHub: [github.com/fvarli](https://github.com/fvarli)
- LinkedIn: [linkedin.com/in/fvarli](https://www.linkedin.com/in/fvarli)
