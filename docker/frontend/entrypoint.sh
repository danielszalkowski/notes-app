#!/bin/sh
set -e

echo "⚛️ Init frontend..."

if [ ! -d node_modules ]; then
  echo "📦 Instalando dependencias frontend..."
  npm install
fi

echo "🚀 Arrancando Vite..."
exec npm run dev -- --host 0.0.0.0
