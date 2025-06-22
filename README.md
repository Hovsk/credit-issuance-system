# Credit Issuance System

A Symfony based application for managing clients and issuing loans based on flexible business rules.
## Requirements

- PHP 8.3
- Composer
- Docker + Docker Compose

## Setup

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/your-username/credit-issuance-system.git
   cd credit-issuance-system
   ```

2. **Start Services & Setup Project:**

   Use the `Makefile` provided:

   ```bash
   make setup
   ```

   This will:
   - Start Docker containers
   - Install dependencies
   - Run database migrations
   - Start Symfony server in the background

##  API Endpoints

### Create a Client

`POST /api/client`

**Request Body (JSON):**
```json
{
  "name": "John Doe",
  "age": 30,
  "region": "PR",
  "city": "Prague",
  "income": 2000,
  "score": 700,
  "pin": "123-45-6789",
  "email": "john.doe@example.com",
  "phone": "+420123456789"
}
```

---

### Request a Loan

`POST /api/client/{id}/loan`

**Request Body (JSON):**
```json
{
  "name": "Personal Loan",
  "amount": 1000,
  "rate": 10.5,
  "start_date": "2024-01-01",
  "end_date": "2024-12-31",
  "pin": "123-45-6789"
}
```

---

## Business Rules

1. Credit Score must be above 500.
2. Monthly income must be at least $1000.
3. Age must be between 18 and 60.
4. Only clients from PR (Prague), BR (Brno), OS (Ostrava) are eligible.
5. Random rejections may occur for clients from Prague.
6. Clients from Ostrava receive a +5% rate adjustment.

---

## Dev Commands

```bash
make start      # Start Docker containers
make install    # Install PHP dependencies
make migrate    # Run database migrations
make serve      # Start Symfony server
make setup      # Run all above steps
```

## Run Tests

```bash
php bin/phpunit
```

---

## Folder Structure

- `src/Controller/` – API endpoints
- `src/Service/` – Business logic and orchestration
- `src/Dto/` – Input data structures
- `src/Entity/` – Doctrine entities
- `src/Enum/` – Enums for strict typing
- `src/Event/` – Domain events
- `src/EventListener/` – Event listeners (e.g., loan notification)

---

## License

MIT
