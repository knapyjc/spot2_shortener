# 📎  URLs Shortcut with Laravel

Este es un sistema de acortamiento de URLs desarrollado en Laravel. Permite a los usuarios generar URLs cortas, hacer seguimiento de clics y administrar las URLs generadas.

---

## 📋 Características

- Generación automática de URLs cortas únicas.
- Redirección con contador de clics.
- Validación de URLs.
- Listado y eliminación de URLs.
- Página de espera antes de la redirección.
- Pruebas unitarias y de integración con PHPUnit.

---

## 🛠️ Requisitos

- PHP >= 8.1
- Composer
- MySQL
- Node.js y npm (opcional para assets)
- Servidor web (Nginx o Apache)

---

## 🚀 Instalación local

```bash
git clone https://github.com/tu-usuario/shorturl.git
cd shorturl

composer install
cp .env.example .env
php artisan key:generate

# Configura tu archivo .env con los datos de la base de datos
php artisan migrate
php artisan serve
