#!/bin/bash

# Colores para que quede chulo (postureo técnico)
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🚀 Preparando entorno y compilando dependencias, nano...${NC}"
# --- NOTA: NO HACEMOS 'docker-compose up' AQUÍ ---

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
    # Crear el directorio si no existe (por si acaso)
    mkdir -p ./backend/database
    touch ./backend/database/database.sqlite
    # Aseguramos que los permisos sean correctos
    chmod 664 ./backend/database/database.sqlite
fi

# 2. INSTALACIÓN DE DEPENDENCIAS (Usamos 'run --rm' para contenedores temporales de trabajo)

# 2.1 Backend (PHP y configuración inicial)
echo -e "${BLUE}🐘 Instalando dependencias de Backend (Composer) y preparando Laravel...${NC}"
# Usamos 'run --rm' para un contenedor temporal. El build de PHP se ejecuta si no existe.
docker-compose run --rm backend composer install
docker-compose run --rm backend php artisan key:generate
docker-compose run --rm backend php artisan migrate:fresh --seed --force

# 2.2 Frontend (NPM y Compilación/Build)
echo -e "${BLUE}⚛️  Instalando dependencias de Frontend (NPM) y compilando...${NC}"
# Instalación de módulos
docker-compose run --rm frontend npm install

# Compilación de recursos (genera el build final en la carpeta /dist)
echo -e "${BLUE}🏗️  Generando build de producción de React...${NC}"
docker-compose run --rm frontend npm run build
# NOTA: Asegúrate de que tu .env en backend esté configurado para buscar el 'build'

echo -e "${GREEN}✨ ¡Setup completo, tete! El entorno está listo para ejecución.${NC}"
echo -e "${BLUE}👉 Ahora, arranca la aplicación con: docker compose up -d${NC}"