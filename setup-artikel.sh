#!/bin/bash

# ========================================
# Setup Script - Fitur Artikel
# Future Leader Academy
# ========================================

echo "🚀 Starting Artikel Feature Setup..."
echo ""

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if Laravel is installed
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Are you in Laravel root directory?"
    exit 1
fi

echo -e "${BLUE}Step 1/5:${NC} Clearing cache..."
php artisan route:clear
php artisan config:clear
php artisan view:clear
echo -e "${GREEN}✅ Cache cleared${NC}"
echo ""

echo -e "${BLUE}Step 2/5:${NC} Running migrations..."
php artisan migrate
echo -e "${GREEN}✅ Migrations completed${NC}"
echo ""

echo -e "${BLUE}Step 3/5:${NC} Creating storage link..."
php artisan storage:link
echo -e "${GREEN}✅ Storage linked${NC}"
echo ""

echo -e "${YELLOW}Step 4/5:${NC} Do you want to seed dummy data? (y/n)"
read -r seed_answer
if [ "$seed_answer" == "y" ] || [ "$seed_answer" == "Y" ]; then
    echo "Seeding artikel data..."
    php artisan db:seed --class=ArtikelSeeder
    echo -e "${GREEN}✅ Data seeded successfully${NC}"
else
    echo "⏭️  Skipping seeder"
fi
echo ""

echo -e "${BLUE}Step 5/5:${NC} Checking artikel stats..."
php artisan artikel:stats
echo ""

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}🎉 Setup Complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo "📍 Available URLs:"
echo "   • List Artikel: http://localhost:8000/artikel"
echo "   • Admin Panel:  http://localhost:8000/admin/artikel"
echo ""
echo "🚀 To start the server, run:"
echo "   php artisan serve"
echo ""
echo "📚 Read documentation:"
echo "   • CARA_MENJALANKAN_ARTIKEL.md"
echo "   • ARTIKEL_README.md"
echo "   • SUMMARY_ARTIKEL.md"
echo ""
