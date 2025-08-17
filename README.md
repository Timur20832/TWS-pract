# TWS Practice Project

Laravel 12 + Orchid Platform проект с API для управления постами и пользователями.

## 🚀 Технологии

- **Backend**: Laravel 12, PHP 8.2+
- **Admin Panel**: Orchid Platform 14
- **API**: Laravel Sanctum
- **Frontend Assets**: Vite
- **Database**: MySQL/PostgreSQL

## 📋 Требования

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+ или PostgreSQL 13+

## 🛠️ Установка

1. **Клонирование репозитория**
```bash
git clone <repository-url>
cd TWS-pract
```

2. **Установка PHP зависимостей**
```bash
composer install
```

3. **Установка Node.js зависимостей**
```bash
npm install
```

4. **Настройка окружения**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Настройка базы данных**
```bash
# В .env файле указать параметры БД
php artisan migrate
php artisan db:seed
```

6. **Сборка frontend assets**
```bash
npm run dev    # для разработки
npm run build  # для продакшена
```

7. **Запуск сервера**
```bash
php artisan serve
```

## 🔐 Доступ к админке

- **URL**: `http://localhost:8000/admin`
- **Email**: `admin@example.com`
- **Пароль**: `admin123`

## 📚 API Документация

### Base URL
```
http://localhost:8000/api
```

### Аутентификация

#### Регистрация пользователя
```http
POST /api/auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
}
```

**Ответ:**
```json
{
    "access_token": "1|abc123...",
    "token_type": "Bearer"
}
```

#### Вход в систему
```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

**Ответ:**
```json
{
    "access_token": "1|abc123...",
    "token_type": "Bearer"
}
```

### Посты

#### Получить все посты
```http
GET /api/posts
```

**Параметры запроса:**
- `sort_by` - поле для сортировки (created_at, title)
- `sort_order` - порядок сортировки (asc, desc)
- `limit` - количество постов (по умолчанию 10)
- `offset` - смещение (по умолчанию 0)
- `date_from` - дата начала (YYYY-MM-DD)
- `date_to` - дата окончания (YYYY-MM-DD)

**Пример:**
```http
GET /api/posts?sort_by=created_at&sort_order=desc&limit=20&date_from=2025-01-01
```

#### Создать пост (требует авторизации)
```http
POST /api/posts
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Мой первый пост",
    "text": "Содержание поста должно быть не менее 10 символов и не более 1000 символов."
}
```

#### Получить свои посты (требует авторизации)
```http
GET /api/posts/my
Authorization: Bearer {token}
```

**Параметры:** те же, что и для получения всех постов.

### Структура ответа постов

```json
{
    "data": [
        {
            "id": 1,
            "title": "Заголовок поста",
            "text": "Содержание поста",
            "created_at": "2025-08-17T15:30:00.000000Z",
            "user_id": 1,
            "author_name": "John Doe"
        }
    ]
}
```

## 🏗️ Архитектура

### Структура проекта
```
app/
├── Http/
│   ├── Controllers/     # API контроллеры
│   ├── Requests/        # Валидация запросов
│   └── Resources/       # API ресурсы
├── Models/              # Eloquent модели
├── Services/            # Бизнес-логика
├── DTO/                 # Data Transfer Objects
└── Orchid/              # Админ панель
    ├── Screens/         # Экраны админки
    └── Layouts/         # Макеты экранов
```

### Компоненты
- **Контроллеры** - обработка HTTP запросов
- **Сервисы** - бизнес-логика
- **DTO** - структуры данных
- **Ресурсы** - форматирование API ответов
- **Orchid Screens** - экраны админки

## 🔒 Безопасность

- **Rate Limiting**: 60 запросов в минуту для API
- **Sanctum**: токен-аутентификация
- **Валидация**: строгая валидация всех входных данных
- **Роли**: система ролей для разграничения доступа

## 🧪 Тестирование

```bash
# Запуск тестов
php artisan test

# Запуск тестов с покрытием
php artisan test --coverage
```

## 📦 Развертывание

### Production
```bash
# Оптимизация для продакшена
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Docker (опционально)
```bash
docker-compose up -d
```


1. Fork репозитория
2. Создать feature branch (`git checkout -b feature/amazing-feature`)
3. Commit изменения (`git commit -m 'Add amazing feature'`)
4. Push в branch (`git push origin feature/amazing-feature`)
5. Создать Pull Request

При возникновении проблем создавайте Issue в репозитории.

