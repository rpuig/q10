#!/bin/bash
# scripts/generate-ssl.sh

VPS_IP="68.168.218.159"  # Replace with your actual VPS IP
CERT_DIR="../config/ssl"

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