# James Gifford - Professional Website

Personal portfolio and blog for James Gifford, a software engineer who builds clean, well-crafted web applications, backend systems, and developer tools.

## About

This is the source code for [jamesgifford.dev](https://jamesgifford.dev) - a professional portfolio site featuring:

- **Portfolio** - Showcasing software projects with descriptions, screenshots, and technology tags
- **Blog** - Thoughts on software, engineering, and building things
- **Contact** - Links to email, GitHub, and LinkedIn

## Tech Stack

![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4-FB70A9?logo=livewire&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7-646CFF?logo=vite&logoColor=white)
![Pest](https://img.shields.io/badge/Pest-4-F28D1A?logo=pest&logoColor=white)
![Flux UI](https://img.shields.io/badge/Flux_UI-2-FB70A9)
![SQLite](https://img.shields.io/badge/SQLite-003B57?logo=sqlite&logoColor=white)

## Local Development

```bash
# Install dependencies
composer install && npm install

# Set up environment
cp .env.example .env
php artisan key:generate
php artisan migrate

# Build frontend assets
npm run build

# Start the development server
composer run dev
```

## Testing

```bash
php artisan test
```

## Contact

- **Email**: hello@jamesgifford.dev
- **GitHub**: [github.com/jamesgifford](https://github.com/jamesgifford)
- **LinkedIn**: [linkedin.com/in/jamesgifford](https://linkedin.com/in/jamesgifford)
