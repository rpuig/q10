# Makefile for CodeIgniter 4 Application Deployment
.PHONY: help install build deploy clean test docker-build docker-up docker-down production staging development

# Default target
help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

# Environment variables
ENV ?= development
PHP_CONTAINER = my-php-apache
DB_CONTAINER = my-postgres
WEB_USER = www-data
CURRENT_USER = deployer

# Installation and Setup
install: ## Install all dependencies
	@echo "Installing PHP dependencies..."
	composer install --no-dev --optimize-autoloader
	@echo "Installing Node.js dependencies..."
	npm install
	@echo "Setting up environment..."
	$(MAKE) setup-env
	@echo "Setting permissions..."
	$(MAKE) permissions-fix

install-dev: ## Install development dependencies
	@echo "Installing PHP dependencies (dev)..."
	composer install
	@echo "Installing Node.js dependencies..."
	npm install
	$(MAKE) setup-env
	$(MAKE) permissions-fix

# Environment setup
setup-env: ## Setup environment file
	@if [ ! -f .env ]; then \
		echo "Creating .env file..."; \
		echo "# CodeIgniter 4 Environment Configuration" > .env; \
		echo "CI_ENVIRONMENT = development" >> .env; \
		echo "" >> .env; \
		echo "# App" >> .env; \
		echo "app.baseURL = 'http://localhost:8080/'" >> .env; \
		echo "app.forceGlobalSecureRequests = false" >> .env; \
		echo "app.sessionDriver = 'CodeIgniter\\Session\\Handlers\\FileHandler'" >> .env; \
		echo "app.sessionCookieName = 'ci_session'" >> .env; \
		echo "app.sessionExpiration = 7200" >> .env; \
		echo "app.sessionSavePath = null" >> .env; \
		echo "app.sessionMatchIP = false" >> .env; \
		echo "app.sessionTimeToUpdate = 300" >> .env; \
		echo "app.sessionRegenerateDestroy = false" >> .env; \
		echo "" >> .env; \
		echo "# Database" >> .env; \
		echo "database.default.hostname = localhost" >> .env; \
		echo "database.default.database = q_local" >> .env; \
		echo "database.default.username = postgres" >> .env; \
		echo "database.default.password = " >> .env; \
		echo "database.default.DBDriver = Postgre" >> .env; \
		echo "database.default.DBPrefix = " >> .env; \
		echo "database.default.port = 5432" >> .env; \
		echo "" >> .env; \
		echo "# Logger" >> .env; \
		echo "logger.threshold = 4" >> .env; \
		echo ".env file created successfully"; \
	else \
		echo ".env file already exists"; \
	fi

# Fix permissions for neo:www-data setup
permissions-fix: ## Fix permissions for current setup
	@echo "Fixing permissions for neo:www-data setup..."
	chown -R deployer:www-data writable/ 2>/dev/null || true
	chmod -R 775 writable/ 2>/dev/null || true
	chmod -R 777 writable/cache/ 2>/dev/null || true
	chmod -R 777 writable/logs/ 2>/dev/null || true
	chmod -R 777 writable/session/ 2>/dev/null || true
	chmod -R 777 writable/debugbar/ 2>/dev/null || true
	chmod -R 755 public/assets/ 2>/dev/null || true
	@echo "Permissions fixed"

# Clean writable directories
clean-writable: ## Clean writable directories
	@echo "Cleaning writable directories..."
	rm -rf writable/cache/* 2>/dev/null || true
	rm -rf writable/debugbar/* 2>/dev/null || true
	rm -rf writable/session/ci_session* 2>/dev/null || true
	find writable/logs/ -name "*.log" -type f -exec truncate -s 0 {} \; 2>/dev/null || true
	@echo "Writable directories cleaned"

# Composer operations
composer-update: ## Update composer dependencies
	@echo "Updating composer dependencies..."
	composer update

composer-fix: ## Fix composer lock file
	@echo "Fixing composer lock file..."
	composer update --lock

# Build targets
build: ## Build frontend assets
	@echo "Building frontend assets..."
	@if [ -f package.json ] && grep -q '"build"' package.json; then \
		npm run build; \
	else \
		echo "No build script found, skipping..."; \
	fi

build-dev: ## Build development assets
	@echo "Building development assets..."
	@if [ -f package.json ] && grep -q '"dev"' package.json; then \
		npm run dev; \
	else \
		echo "No dev script found, skipping..."; \
	fi

# Database operations (manual only - not run automatically)
db-migrate: ## Run database migrations
	@echo "Running database migrations..."
	php spark migrate || echo "Migration failed - database may not be available"

db-seed: ## Run database seeders
	@echo "Running database seeders..."
	php spark db:seed || echo "Seeding failed - database may not be available"

db-reset: ## Reset database (migrate:refresh + seed)
	@echo "Resetting database..."
	php spark migrate:refresh || echo "Migration refresh failed"
	php spark db:seed || echo "Seeding failed"

db-setup: ## Setup database (migrate + seed)
	@echo "Setting up database..."
	$(MAKE) db-migrate
	$(MAKE) db-seed

# Testing
test: ## Run PHPUnit tests
	@echo "Running PHPUnit tests..."
	@if [ -f vendor/bin/phpunit ]; then \
		./vendor/bin/phpunit; \
	else \
		echo "PHPUnit not installed"; \
	fi

# Docker operations
docker-build: ## Build Docker containers
	@echo "Building Docker containers..."
	@if [ -f docker-compose.yml ]; then \
		docker compose build; \
	else \
		echo "docker-compose.yml not found"; \
	fi

docker-up: ## Start Docker containers
	@echo "Starting Docker containers..."
	@if [ -f docker-compose.yml ]; then \
		docker compose up -d; \
	else \
		echo "docker-compose.yml not found"; \
	fi

docker-down: ## Stop Docker containers
	@echo "Stopping Docker containers..."
	@if [ -f docker-compose.yml ]; then \
		docker compose down; \
	else \
		echo "docker-compose.yml not found"; \
	fi

docker-logs: ## Show Docker logs
	@if [ -f docker-compose.yml ]; then \
		docker compose logs -f; \
	else \
		echo "docker-compose.yml not found"; \
	fi

docker-shell: ## Access PHP container shell
	@if [ -f docker-compose.yml ]; then \
		docker compose exec $(PHP_CONTAINER) bash; \
	else \
		echo "docker-compose.yml not found"; \
	fi

docker-restart: ## Restart Docker containers
	@echo "Restarting Docker containers..."
	@if [ -f docker-compose.yml ]; then \
		docker compose restart; \
	else \
		echo "docker-compose.yml not found"; \
	fi

# Deployment environments (no automatic DB operations)
development: ## Deploy to development environment
	@echo "=== Development Deployment ==="
	$(MAKE) clean-writable
	$(MAKE) composer-fix
	$(MAKE) install-dev
	$(MAKE) build-dev
	$(MAKE) permissions-fix
	@if [ -f docker-compose.yml ]; then \
		$(MAKE) docker-up; \
		sleep 5; \
	fi
	@echo "=== Development environment ready! ==="
	@echo "Run 'make db-setup' if you need to setup the database"

staging: ## Deploy to staging environment
	@echo "=== Staging Deployment ==="
	$(MAKE) clean-writable
	$(MAKE) install
	$(MAKE) build
	$(MAKE) cache-clear
	$(MAKE) optimize
	$(MAKE) permissions-fix
	@echo "=== Staging deployment complete! ==="
	@echo "Run 'make db-migrate' if you need to run migrations"

production: ## Deploy to production environment
	@echo "=== Production Deployment ==="
	$(MAKE) clean-writable
	$(MAKE) install
	$(MAKE) build
	$(MAKE) cache-clear
	$(MAKE) optimize
	$(MAKE) permissions-fix
	$(MAKE) security-check
	@echo "=== Production deployment complete! ==="
	@echo "Run 'make db-migrate' if you need to run migrations"

# Optimization
optimize: ## Optimize application for production
	@echo "Optimizing application..."
	composer dump-autoload --optimize --no-dev
	@echo "Application optimized"

cache-clear: ## Clear application cache
	@echo "Clearing application cache..."
	php spark cache:clear 2>/dev/null || echo "Cache clear command not available"
	$(MAKE) clean-writable
	@echo "Cache cleared"

# Backup operations
backup-db: ## Backup database
	@echo "Creating database backup..."
	@mkdir -p writable/backups
	@if command -v docker >/dev/null 2>&1 && [ -f docker-compose.yml ]; then \
		docker compose exec -T $(DB_CONTAINER) pg_dump -U postgres -d q_local > writable/backups/db_backup_$(shell date +%Y%m%d_%H%M%S).sql; \
		echo "Database backup created"; \
	else \
		echo "Docker not available for database backup"; \
	fi

backup-files: ## Backup uploaded files
	@echo "Creating files backup..."
	@mkdir -p writable/backups
	tar -czf writable/backups/files_backup_$(shell date +%Y%m%d_%H%M%S).tar.gz writable/uploads/ 2>/dev/null || echo "Files backup failed"
	@echo "Files backup created"

# Security
security-check: ## Run security checks
	@echo "Running security checks..."
	@if command -v composer >/dev/null 2>&1; then \
		composer audit 2>/dev/null || echo "Composer audit not available"; \
	fi
	@if command -v npm >/dev/null 2>&1; then \
		npm audit 2>/dev/null || echo "NPM audit not available"; \
	fi

# Logs
logs: ## Show application logs
	@echo "Showing recent application logs..."
	@if [ -d writable/logs ] && [ "$$(ls -A writable/logs/)" ]; then \
		tail -f writable/logs/*.log; \
	else \
		echo "No log files found"; \
	fi

logs-show: ## Show recent log entries
	@echo "Recent log entries:"
	@if [ -d writable/logs ] && [ "$$(ls -A writable/logs/)" ]; then \
		tail -20 writable/logs/*.log; \
	else \
		echo "No log files found"; \
	fi

# Quick deployment shortcuts (no DB operations)
quick-deploy: ## Quick deployment (install + build)
	@echo "=== Quick Deployment ==="
	$(MAKE) install
	$(MAKE) build
	$(MAKE) cache-clear
	$(MAKE) permissions-fix
	@echo "=== Quick deployment complete! ==="

full-deploy: ## Full deployment with all optimizations (no DB operations)
	@echo "=== Full Deployment ==="
	$(MAKE) clean-writable
	$(MAKE) composer-fix
	$(MAKE) install
	$(MAKE) build
	$(MAKE) optimize
	$(MAKE) permissions-fix
	$(MAKE) security-check
	@echo "=== Full deployment complete! ==="

# Development helpers (no automatic DB operations)
dev-setup: ## Complete development setup (no database operations)
	@echo "=== Development Setup ==="
	$(MAKE) composer-fix
	$(MAKE) clean-writable
	$(MAKE) install-dev
	@if [ -f docker-compose.yml ]; then \
		$(MAKE) docker-build; \
		$(MAKE) docker-up; \
		echo "Waiting for services to start..."; \
		sleep 10; \
	fi
	$(MAKE) permissions-fix
	@echo "=== Development setup complete! ==="
	@echo "Database operations available:"
	@echo "  make db-migrate  - Run migrations"
	@echo "  make db-seed     - Run seeders"
	@echo "  make db-setup    - Run migrations + seeders"

dev-reset: ## Reset development environment
	@echo "=== Resetting Development Environment ==="
	@if [ -f docker-compose.yml ]; then \
		$(MAKE) docker-down; \
	fi
	$(MAKE) clean-writable
	$(MAKE) dev-setup
	@echo "=== Development environment reset complete! ==="

# Fix common issues
fix-permissions: ## Fix permission issues
	@echo "Fixing permission issues..."
	$(MAKE) clean-writable
	$(MAKE) permissions-fix
	@echo "Permissions fixed"

fix-composer: ## Fix composer issues
	@echo "Fixing composer issues..."
	$(MAKE) composer-fix
	$(MAKE) install-dev
	@echo "Composer issues fixed"

# Status checks
status: ## Show application status
	@echo "=== Application Status ==="
	@echo "Current User: $(CURRENT_USER)"
	@echo "Web User: $(WEB_USER)"
	@echo "PHP Version: $$(php -v 2>/dev/null | head -n 1 || echo 'PHP not found')"
	@echo "Composer Version: $$(composer --version 2>/dev/null || echo 'Composer not found')"
	@echo "Node Version: $$(node --version 2>/dev/null || echo 'Node not found')"
	@echo "NPM Version: $$(npm --version 2>/dev/null || echo 'NPM not found')"
	@echo ""
	@echo "Environment file:"
	@ls -la .env 2>/dev/null || echo "No .env file found"
	@echo ""
	@echo "Writable directory status:"
	@ls -la writable/ | head -5
	@echo ""
	@if [ -f docker-compose.yml ]; then \
		echo "Docker Status:"; \
		docker compose ps 2>/dev/null || echo "Docker not running"; \
	else \
		echo "Docker compose file not found"; \
	fi

# Maintenance
maintenance-on: ## Enable maintenance mode
	@echo "Enabling maintenance mode..."
	@echo "<?php header('HTTP/1.1 503 Service Temporarily Unavailable'); echo 'Site under maintenance'; exit; ?>" > public/.maintenance.php
	@echo "Maintenance mode enabled"

maintenance-off: ## Disable maintenance mode
	@echo "Disabling maintenance mode..."
	@rm -f public/.maintenance.php
	@echo "Maintenance mode disabled"