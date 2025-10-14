# استخدام صورة PHP مع FPM
FROM php:8.2-fpm

# تثبيت الحزم الأساسية (أدوات التكوين)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxpm-dev \
    git \
    unzip \
    curl \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# تثبيت مكتبة GD الخاصة بـ PHP مع دعم freetype و jpeg و xpm
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-xpm && \
    docker-php-ext-install gd

# تثبيت Node.js و npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# تثبيت مكتبات PHP الأخرى
RUN docker-php-ext-install pdo pdo_mysql

# تثبيت Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# إعداد work directory
WORKDIR /var/www

# نسخ الملفات إلى الحاوية
COPY . .

# إعداد أذونات التخزين
RUN chmod -R 777 storage bootstrap/cache

# تثبيت Composer dependencies مع خيار الـ optimize-autoloader
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-scripts

# تثبيت npm dependencies
RUN npm install

# تشغيل الخادم Laravel على المنفذ 8000
#CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
CMD ["php-fpm"]
