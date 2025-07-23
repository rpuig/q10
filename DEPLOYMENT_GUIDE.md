# Q.Local Docker Deployment Guide

This guide covers setting up a portable Docker development environment for CodeIgniter with PostgreSQL and deploying it to a VPS using Docker contexts.

## Table of Contents
1. [Local Development Setup](#local-development-setup)
2. [VPS User Setup](#vps-user-setup)
3. [Production Configuration](#production-configuration)
4. [SSL Certificates](#ssl-certificates)
5. [Deployment Scripts](#deployment-scripts)
6. [Usage Commands](#usage-commands)

## Local Development Setup

### Directory Structure ############################################################################3
```
q.local/
├── app/                          # CodeIgniter application files
├── config/
│   ├── apache/
│   │   ├── q.local.conf         # Local Apache config
│   │   └── q.local.prod.conf    # Production Apache config
│   ├── ssl/                     # SSL certificates
│   └── php/
│       ├── custom.ini           # Local PHP config
│       ├── custom.prod.ini      # Production PHP config
│       └── xdebug.ini          # Xdebug config
├── data/
│   ├── postgres/               # PostgreSQL data
│   └── pgadmin/               # PgAdmin data
├── scripts/
│   └── generate-ssl.sh        # SSL certificate generator
├── docker-compose.yml         # Local development
├── docker-compose.prod.yml    # Production
├── Dockerfile
├── .env                       # CodeIgniter environment
├── .env.docker               # Docker environment (local)
├── .env.prod                 # Docker environment (production)
├── .env.production           # CodeIgniter environment (production)
├── deploy.sh                 # Deployment script
└── Makefile                  # Convenience commands
```

### Docker Compose - Local Development

```yml
# docker-compose.yml
services:
  postgres:
    image: postgres:17
    container_name: q-local-postgres
    env_file:
      - .env.docker
    environment:
      POSTGRES_USER: ${POSTGRES_USER}
      POSTGRES_PASSWORD: ${POSTGRES_PASSWORD}
      POSTGRES_DB: ${POSTGRES_DB}
    ports:
      - "${POSTGRES_PORT:-1543}:5432"
    volumes:
      - ./data/postgres:/var/lib/postgresql/data
    networks:
      - app-network

  pgadmin:
    image: dpage/pgadmin4
    container_name: q-local-pgadmin
    env_file:
      - .env.docker
    environment:
      PGADMIN_DEFAULT_EMAIL: ${PGADMIN_EMAIL}
      PGADMIN_DEFAULT_PASSWORD: ${PGADMIN_PASSWORD}
    volumes:
      - ./data/pgadmin:/var/lib/pgadmin  
    ports:
      - "${PGADMIN_PORT:-8888}:80"
    depends_on:
      - postgres
    networks:
      - app-network
    
  web:
    build: .
    container_name: q-local-web
    env_file:
      - .env.docker
      - .env  # CodeIgniter env file
    volumes:
      - ./app:/var/www/html/q.local
      - ./config/apache/q.local.conf:/etc/apache2/sites-available/q.local.conf:ro
      - ./config/apache/q.local.conf:/etc/apache2/sites-enabled/q.local.conf:ro
      - ./config/ssl:/etc/ssl/localcerts:ro
      - ./config/php/custom.ini:/usr/local/etc/php/conf.d/custom.ini:ro
      - ./config/php/xdebug.ini:/usr/local/etc/php/conf.d/xdebug.ini:ro
    ports:
      - "${WEB_HTTP_PORT:-8080}:80" 
      - "${WEB_HTTPS_PORT:-8443}:443"
    depends_on:
      - postgres
    command: >
      bash -c "
        a2enmod rewrite &&
        a2enmod ssl &&
        a2ensite q.local &&
        apache2-foreground
      "
    networks:
      app-network:
        ipv4_address: ${WEB_IP:-192.168.100.10}

networks:
  app-network:
    driver: bridge
    ipam:
      config:
        - subnet: ${NETWORK_SUBNET:-192.168.100.0/24}
```

### Environment Files

#### .env.docker (Local)
```env
# Database credentials
POSTGRES_USER=neo
POSTGRES_PASSWORD=your_secure_db_password_here
POSTGRES_DB=xgroups
POSTGRES_PORT=1543

# PgAdmin credentials
PGADMIN_EMAIL=admin@yourdomain.com
PGADMIN_PASSWORD=your_secure_pgadmin_password

# Docker networking
WEB_HTTP_PORT=8080
WEB_HTTPS_PORT=8443
WEB_IP=192.168.100.10
NETWORK_SUBNET=192.168.100.0/24
```

#### .env (CodeIgniter - Local)
```env
# CodeIgniter Environment
CI_ENVIRONMENT = development

# Database - matches Docker postgres service
database.default.hostname = postgres
database.default.database = xgroups
database.default.username = neo
database.default.password = your_secure_db_password_here
database.default.DBDriver = Postgre
database.default.port = 5432

# Your other CodeIgniter configs...
app.baseURL = 'http://localhost:8080/'
```

## VPS User Setup ######################################################################################

### Create Non-Root User on VPS

```bash
# SSH into VPS as root
ssh root@your-vps-ip

# Create user
adduser deployer

# Add to groups
usermod -aG sudo deployer
usermod -aG docker deployer

# Switch to new user
su - deployer

# Create SSH directory
mkdir -p ~/.ssh
chmod 700 ~/.ssh
```

### SSH Key Setup

```bash
# On local machine - generate SSH keys
ssh-keygen -t ed25519 -C "deployer@your-vps" -f ~/.ssh/vps_deployer

# Copy public key to VPS
ssh-copy-id -i ~/.ssh/vps_deployer.pub deployer@your-vps-ip

# Test connection
ssh -i ~/.ssh/vps_deployer deployer@your-vps-ip
```


### Docker Context Setup

```bash
# Create Docker context
docker context create vps --docker "host=ssh://deployer@your-vps-ip"

# Test context
docker context use vps
docker ps
docker context use default
```

## Production Configuration

### Docker Compose - Production

```yml
# docker-compose.prod.yml
services:
  postgres:
    image: postgres:17
    container_name: q-local-postgres-prod
    env_file:
      - .env.prod
    environment:
      POSTGRES_USER: ${POSTGRES_USER}
      POSTGRES_PASSWORD: ${POSTGRES_PASSWORD}
      POSTGRES_DB: ${POSTGRES_DB}
    ports:
      - "${POSTGRES_PORT:-5432}:5432"
    volumes:
      - ./data/postgres:/var/lib/postgresql/data
    networks:
      - app-network
    restart: unless-stopped

  pgadmin:
    image: dpage/pgadmin4
    container_name: q-local-pgadmin-prod
    env_file:
      - .env.prod
    environment:
      PGADMIN_DEFAULT_EMAIL: ${PGADMIN_EMAIL}
      PGADMIN_DEFAULT_PASSWORD: ${PGADMIN_PASSWORD}
    volumes:
      - ./data/pgadmin:/var/lib/pgadmin  
    ports:
      - "${PGADMIN_PORT:-8888}:80"
    depends_on:
      - postgres
    networks:
      - app-network
    restart: unless-stopped
    
  web:
    build: .
    container_name: q-local-web-prod
    env_file:
      - .env.prod
      - .env  # CodeIgniter env file
    volumes:
      - ./app:/var/www/html/q.local
      - ./config/apache/q.local.prod.conf:/etc/apache2/sites-available/q.local.conf:ro
      - ./config/apache/q.local.prod.conf:/etc/apache2/sites-enabled/q.local.conf:ro
      - ./config/ssl:/etc/ssl/localcerts:ro
      - ./config/php/custom.prod.ini:/usr/local/etc/php/conf.d/custom.ini:ro
    ports:
      - "80:80" 
      - "443:443"
    depends_on:
      - postgres
    command: >
      bash -c "
        a2enmod rewrite &&
        a2enmod ssl &&
        a2enmod headers &&
        a2ensite q.local &&
        apache2-foreground
      "
    networks:
      app-network:
        ipv4_address: ${WEB_IP:-68.168.218.159}
    restart: unless-stopped

networks:
  app-network:
    driver: bridge
    ipam:
      config:
        - subnet: ${NETWORK_SUBNET:-68.168.218.159/24}


### Apache Virtual Host - Production

```apache
# config/apache/q.local.prod.conf
<VirtualHost *:80>
    ServerName your-vps-ip
    DocumentRoot /var/www/html/q.local/public
    
    <Directory /var/www/html/q.local/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
        
        # CodeIgniter URL rewriting
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php/$1 [L]
    </Directory>
    
    # Logging
    ErrorLog ${APACHE_LOG_DIR}/q.local_error.log
    CustomLog ${APACHE_LOG_DIR}/q.local_access.log combined
</VirtualHost>

<VirtualHost *:443>
    ServerName your-vps-ip
    DocumentRoot /var/www/html/q.local/public
    
    <Directory /var/www/html/q.local/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
        
        # CodeIgniter URL rewriting
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php/$1 [L]
    </Directory>
    
    # Security headers
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options SAMEORIGIN
    Header always set X-XSS-Protection "1; mode=block"
    
    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /etc/ssl/localcerts/vps-dev.crt
    SSLCertificateKeyFile /etc/ssl/localcerts/vps-dev.key
    
    # Logging
    ErrorLog ${APACHE_LOG_DIR}/q.local_ssl_error.log
    CustomLog ${APACHE_LOG_DIR}/q.local_ssl_access.log combined
</VirtualHost>
```

## SSL Certificates

### Self-Signed Certificate Generator

```bash
#!/bin/bash
# scripts/generate-ssl.sh

VPS_IP="your-vps-ip"  # Replace with your actual VPS IP
CERT_DIR="./config/ssl"

echo "🔐 Generating self-signed SSL certificates for VPS development..."

# Create SSL directory if it doesn't exist
mkdir -p $CERT_DIR

# Generate private key
openssl genrsa -out $CERT_DIR/vps-dev.key 2048

# Generate certificate signing request
openssl req -new -key $CERT_DIR/vps-dev.key -out $CERT_DIR/vps-dev.csr -subj "/C=US/ST=Development/L=Development/O=Development/CN=$VPS_IP"

# Generate self-signed certificate
openssl x509 -req -days 365 -in $CERT_DIR/vps-dev.csr -signkey $CERT_DIR/vps-dev.key -out $CERT_DIR/vps-dev.crt

# Set proper permissions
chmod 600 $CERT_DIR/vps-dev.key
chmod 644 $CERT_DIR/vps-dev.crt

# Clean up CSR file
rm $CERT_DIR/vps-dev.csr

echo "✅ SSL certificates generated successfully!"
```

## Deployment Scripts

### Main Deployment Script

````bash
#!/bin/bash
# deploy.sh

set -e

VPS_USER="deployer"
VPS_HOST="your-vps-ip"  # Replace with your actual VPS IP
VPS_PATH="/home/deployer/q-local"

echo "🚀 Deploying to VPS ($VPS_HOST) as $VPS_USER..."

# Check if we're on the right context
CURRENT_CONTEXT=$(docker context show)
if [ "$CURRENT_CONTEXT" != "vps" ]; then
    echo "Switching to VPS context..."
    docker context use vps
fi

# Generate SSL certificates if they don't exist
if [ ! -f "./config/ssl/vps-dev.crt" ]; then
    echo "🔐 Generating SSL certificates..."
    sed -i "s/your-vps-ip/$VPS_HOST/g" ./scripts/generate-ssl.sh
    ./scripts/generate-ssl.sh
fi

# Update config files with VPS IP
echo "📝 Updating configuration files..."
sed -i "s/your-vps-ip/$VPS_HOST/g" ./config/apache/q.local.prod.conf
sed -i "s/your-vps-ip/$VPS_HOST/g" ./.env.production

# Sync files to VPS
echo "📁 Syncing files to VPS..."
rsync -avz --exclude='data/' --exclude='.git/' --exclude='node_modules/' \
    --exclude='.env.docker' --exclude='.env' \
    -e "ssh -i ~/.ssh/vps_deployer" \
    ./ $VPS_USER@$VPS_HOST:$VPS_PATH/

# Copy production environment files
echo "📋 Copying production configs..."
scp -i ~/.ssh/vps_deployer .env.prod $VPS_USER@$VPS_HOST:$VPS_PATH/.env.docker
scp -i ~/.ssh/vps_deployer .env.production $VPS_USER@$VPS_HOST:$VPS_PATH/.env

# Create necessary directories on VPS
echo "📁 Creating directories on VPS..."
ssh -i ~/.ssh/vps_deployer $VPS_USER@$VPS_HOST "
    cd $VPS_PATH && \
    mkdir -p data/{postgres,pgadmin} config/{apache,ssl,php} && \
    chmod -R 755 config/ && \
    chmod -R 700 config/ssl/ || true
"

# Build and deploy
echo "🔨 Building and starting containers..."
docker-compose -f docker-compose.prod.yml down || true
docker-


