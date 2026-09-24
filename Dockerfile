# ========================
# 1️⃣ Etapa de construcción del frontend
# ========================
FROM node:20 AS build-frontend

WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ========================
# 2️⃣ Etapa base para PHP + Composer
# ========================
FROM php:8.2-fpm-bullseye AS app
RUN apt-get update
# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    libxml2-dev libzip-dev libicu-dev libcurl4-openssl-dev pkg-config \
    nginx supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql xml curl zip gd mbstring bcmath intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2.8.11 /usr/bin/composer /usr/bin/composer
RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/conf.d/default.conf


# Crear directorio de trabajo
WORKDIR /var/www/html

# Copiar código de la aplicación
COPY . .

# Copiar assets del frontend ya compilados
COPY --from=build-frontend /app/public ./public

# Configurar permisos para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Instalar dependencias PHP (sin desarrollo)
RUN composer install --no-dev --optimize-autoloader

# Generar clave de aplicación solo si no existe
RUN if [ ! -f .env ]; then cp .env.example .env; fi && \
    php artisan key:generate --force || true

# Cachear configuración y vistas (omite route:cache temporalmente)
RUN php artisan config:cache && php artisan view:cache || true
# Habilitar el local storage
RUN php artisan storage:link
# Configurar permisos para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache



# ========================
# 3️⃣ Configurar Nginx y PHP-FPM con Supervisor
# ========================
COPY ./config/nginx.conf /etc/nginx/conf.d/default.conf
COPY ./config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord"]
