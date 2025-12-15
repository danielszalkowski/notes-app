#!/bin/bash

# Colores para que quede chulo (postureo técnico)
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🚀 Arrancando motores y preparando entorno, nano...${NC}"

# 1. GENERACIÓN DE ARCHIVOS CRÍTICOS (PORTABILIDAD)
echo -e "${BLUE}⚙️  Verificando archivos de configuración y base de datos...${NC}"

# 1.1 Copiar .env y generar Key si no existe
if [ ! -f ./backend/.env ]; then
    echo -e "${GREEN}-> Copiando .env.example a .env...${NC}"
    cp ./backend/.env.example ./backend/.env
fi

# 1.2 Crear el archivo SQLite si no existe
if [ ! -f ./backend/database/database.sqlite ]; then
    echo -e "${GREEN}-> Creando archivo SQLite vacío...${NC}"
    touch ./backend/database/database.sqlite
    # Aseguramos que los permisos sean correctos desde el host/WSL
    chmod 664 ./backend/database/database.sqlite
fi

# 2. Levantar contenedores (con build por si acaso)
docker-compose up -d --build

echo -e "${GREEN}✅ Contenedores levantados.${NC}"

# 3. Instalación de dependencias (PHP y NPM)
echo -e "${BLUE}🐘 Instalando dependencias de Backend (Composer)...${NC}"
# Ejecutamos el install dentro del contenedor backend
docker-compose exec -u www-data backend composer install

echo -e "${BLUE}⚛️  Instalando dependencias de Frontend (NPM)...${NC}"
# Usamos 'run --rm' para levantar un contenedor temporal solo para instalar
docker-compose run --rm frontend npm install

# 4. CONFIGURACIÓN DE LARAVEL DENTRO DEL CONTENEDOR
echo -e "${BLUE}🔑 Generando App Key (si es la primera vez)...${NC}"
# Usamos 'exec -u www-data' para que los permisos de cache/log sean correctos
docker-compose exec -u www-data backend php artisan key:generate

echo -e "${BLUE}💿 Migrando y preparando la base de datos...${NC}"
docker-compose exec -u www-data backend php artisan migrate --seed --force

echo -e "${GREEN}✨ ¡Setup completo, tete! ¡A darle caña!${NC}"
echo -e "${GREEN}🌍 Backend (API) listo en http://localhost:8000 ${NC}"
echo -e "${GREEN}⚛️  Frontend (React) listo en http://localhost:5173 ${NC}"