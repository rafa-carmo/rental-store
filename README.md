# Rental Store

![Language: PHP](https://img.shields.io/badge/language-PHP-777BB4?logo=php&logoColor=white)
![Language: TypeScript](https://img.shields.io/badge/language-TypeScript-3178C6?logo=typescript&logoColor=white)
![Framework: Laravel 12](https://img.shields.io/badge/framework-Laravel%2012-FF2D20?logo=laravel&logoColor=white)
![Framework: React 19](https://img.shields.io/badge/framework-React%2019-61DAFB?logo=react&logoColor=111827)
![Framework: Inertia.js v2](https://img.shields.io/badge/framework-Inertia.js%20v2-9553E9)
![PHP Required: >=8.3](https://img.shields.io/badge/PHP-%3E%3D8.3-777BB4?logo=php&logoColor=white)
![Node.js Required: >=20](https://img.shields.io/badge/Node.js-%3E%3D20-339933?logo=nodedotjs&logoColor=white)

A rental management system built with **Laravel 12** on the backend and **React 19** on the frontend, using **Inertia.js** to integrate both layers smoothly.

## Main stack

### Backend
- PHP 8.3
- Laravel 12
- Laravel Fortify (authentication)
- Inertia Laravel
- Laravel Wayfinder

### Frontend
- React 19
- Inertia React
- Vite 7
- Tailwind CSS 4
- Headless UI
- Radix UI
- lucide-react

### Quality and development
- Pest 4 (tests)
- PHPUnit 12
- Laravel Pint (PHP code style)
- ESLint 9
- Prettier 3

## How to run the project

### 1. Prerequisites
- PHP 8.3+
- Composer
- Node.js 20+
- NPM
- MySQL

### 2. Install dependencies and prepare the environment

```bash
composer setup
```

This command already runs:
- `composer install`
- copy `.env` (if needed)
- `php artisan key:generate`
- `php artisan migrate --force`
- `npm install`
- `npm run build`

### 3. Run in development mode

```bash
composer dev
```

This command starts in parallel:
- Laravel server
- queue (`queue:listen`)
- Vite (`npm run dev`)

### 4. Run tests

```bash
composer test
```

### 5. Useful commands

```bash
# Frontend only (hot reload)
npm run dev

# Production build
npm run build

# Lint/fix frontend
npm run lint

# Frontend formatting
npm run format

# PHP formatting
vendor/bin/pint --dirty
```

## How to contribute

1. Fork the project.
2. Create a branch for your feature or fix.
3. Implement your changes following the project conventions.
4. Run tests and linters before opening a PR.
5. Open a Pull Request with clear context:
- the problem
- the solution you adopted
- how to test it

### PR checklist
- [ ] Code follows project conventions
- [ ] Tests are passing
- [ ] No lint/format errors
- [ ] Change documented when needed

## License

This project is licensed under the MIT License.
