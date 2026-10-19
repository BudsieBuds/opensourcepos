---
title: Testing & Code Standards
description: Coding standards, formatting with PHP-CS-Fixer, and running automated test suites with PHPUnit.
---

Open Source Point of Sale adheres to strict code quality and testing standards to maintain stability across retail checkout environments.

---

## 1. Coding Standards & Conventions

All PHP code must conform to the **PSR-12** extended coding style guide, CodeIgniter 4 conventions, and OSPOS project rules:

### Automated Formatting via PHP-CS-Fixer
The repository includes a pre-configured `.php-cs-fixer.no-header.php` ruleset. Before committing code, run:

```bash
# Automatically format all PHP files to PSR-12 standards
composer cs-fix

# Check for style violations without modifying files
composer cs-check
```

### Core Code Conventions
- **Naming Conventions**:
  - `camelCase` for all variables, properties, and methods.
  - `PascalCase` for class names, interfaces, and test fixtures.
  - `UPPER_CASE` for constants.
  - **Refactor on Touch**: When modifying an older method or file containing legacy snake_case variables, refactor surrounding variable names to `camelCase`.
- **Import Statements**:
  - Always import classes, functions, and constants at the top of the file via `use` statements.
  - Inline fully-qualified class references (e.g. `\Config\Database::connect()`) are prohibited.
- **Documentation**:
  - Do not write redundant comments or docblocks that merely restate type hints or method names.
  - Comments should strictly document non-obvious rationale, edge cases, or domain constraints.
- **JavaScript**:
  - Use `const` for immutable bindings and `let` for reassignments.
  - `var` is strictly prohibited.
- **Security Rules**:
  - Never commit `.env`, credentials, or API tokens.
  - Runtime `.env` modifications must acquire a dedicated file lock via `lockEnvFile()` (`app/Helpers/security_helper.php`) to prevent race conditions during concurrent requests.
  - Never reference vulnerability advisory IDs (CVE, GHSA, etc.) in code, comments, docblocks, commit messages, or PR documentation.

---

## 2. Automated Testing with PHPUnit

Test suites are located in the `tests/` directory:
- **Unit Tests**: Test isolated helper functions and library algorithms.
- **Database Tests**: Test models, database transactions, and data integrity against a dedicated test database (`ospos_test`).
- **Feature / Controller Tests**: Simulate HTTP requests, form submissions, and session validation.

### Testing Rules & Architecture
- **One Test File Per Class**: Each controller, model, library, or helper has exactly one canonical test file covering its behavior (e.g. `Sales.php` $\rightarrow$ `tests/Controllers/SalesControllerTest.php`, `Sale_lib.php` $\rightarrow$ `tests/Libraries/Sale_libTest.php`). Creating ad-hoc, endpoint-scoped companion test files is prohibited.
- **Test Method Naming Convention**: Methods must follow `test{MethodUnderTest}_{Behavior}`:
  - `PascalCase` name of the method under test, followed by an underscore `_`, followed by a behavior phrase starting with a verb (`Accepts`, `Requires`, `Rejects`, `Returns`).
  - *Example*: `testPostSave_RejectsNegativeTaxPercent()`
  - *Example*: `testSaveLocale_AcceptsValidReferenceCodeMinMax()`
  - *Example*: `testCheckNumeric_ReturnsFalseForAlphabeticInput()`

### Configuring the Test Database

Ensure your `.env` contains credentials for a dedicated testing database:

```ini
database.tests.hostname = 'localhost'
database.tests.database = 'ospos_test'
database.tests.username = 'admin'
database.tests.password = 'pointofsale'
database.tests.DBDriver = 'MySQLi'
database.tests.DBPrefix = 'ospos_'
```

:::caution[Dedicated Test DB Required]
Never point `database.tests` to your production database! Running tests will truncate tables and seed dummy data.
:::

### Running Tests

```bash
# Run the complete PHPUnit test suite
vendor/bin/phpunit

# Run a specific test class
vendor/bin/phpunit tests/app/Models/ItemTest.php

# Run with test coverage report
vendor/bin/phpunit --coverage-html build/coverage
```

---

## 3. GitHub Actions Continuous Integration (CI)

Every Pull Request submitted to the OSPOS repository triggers automated GitHub Actions workflows:

1. **PHP Linter & Coding Standard**: Verifies syntax and PSR-12 formatting compliance.
2. **PHPUnit Matrix**: Runs tests across supported PHP versions (PHP 8.2, 8.3, and 8.4) and MariaDB/MySQL versions.
3. **Frontend Build Check**: Ensures `npm run build` compiles cleanly with zero bundler errors.

