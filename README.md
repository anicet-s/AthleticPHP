# AthleticPHP

Athletic training website helper - A comprehensive web application to help athletic trainers with injury diagnosis and treatment information.

## Features

- 🔍 Search athletic injuries and conditions
- 🩺 Interactive diagnostic tool for common sports injuries
- 📚 Comprehensive injury database with treatments
- 📱 Responsive design for mobile and desktop
- 🔒 Secure with modern PHP practices

## Quick Start

```bash
# Install dependencies
composer install

# Configure environment
cp .env.example .env
# Edit .env with your database credentials

# Start development server
cd public && php -S localhost:8000
```

Visit `http://localhost:8000`

## Documentation

- [Installation Guide](INSTALLATION.md) - Complete setup instructions
- [Migration Guide](MIGRATION_GUIDE.md) - Upgrading from old version

## Requirements

- PHP 7.4+
- MySQL 5.7+
- Composer
- Apache with mod_rewrite OR Nginx

## Security

This application has been refactored with security best practices:
- SQL injection prevention with prepared statements
- CSRF protection
- Environment-based configuration
- Input validation and sanitization
- Secure password handling

## Contributing

Contributions are welcome! Please ensure:
- Code follows PSR-12 standards
- All security best practices are maintained
- Tests pass (when implemented)

## License

Copyright © 2024 The Athletic Trainer. All rights reserved.

## Contact

For questions or support: webmaster@athletictrainer.com 
