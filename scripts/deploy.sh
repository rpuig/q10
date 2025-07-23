#!/bin/bash
# deploy.sh

set -e

VPS_USER="deployer"
VPS_HOST="68.168.218.159"  # Replace with your actual VPS IP
VPS_PATH="/home/deployer/www/q.local"

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
    sed -i "s/your-vps-ip/$VPS_HOST/g" ./generate-ssl.sh
    ./generate-ssl.sh
fi  

# Update config files with VPS IP
echo "📝 Updating configuration files..."
sed -i "s/your-vps-ip/$VPS_HOST/g" ../config/apache/q.local.prod.conf
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
docker-compose -f docker-compose.prod.yml up -d --build
