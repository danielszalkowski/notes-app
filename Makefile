up:
	docker-compose up -d

down:
	docker-compose down

setup:
	@echo "🏗️  Levantando y construyendo..."
	docker-compose up -d --build
	@echo "📦 Instalando dependencias de Backend (Composer)..."
	docker-compose exec backend composer install
	@echo "📦 Instalando dependencias de Frontend (NPM)..."
	# Usamos 'sh -c' para asegurar que corre dentro del contenedor
	docker-compose run --rm frontend npm install
	@echo "🚀 ¡Todo listo, tete! Abre http://localhost:8000"

shell-back:
	docker-compose exec backend sh

shell-front:
	docker-compose run --rm frontend sh