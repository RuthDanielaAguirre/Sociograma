# 🎓 Sociograma DAW - Práctica 2

Aplicación PHP para recoger información sociométrica de la clase mediante formularios.

## 📋 Requisitos

- Docker Desktop
- Git
- Navegador web
- (Opcional) Postman para probar la API

---

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone <tu-repo>
cd sociograma
```

### 2. Crear archivo `.env`

Crea un archivo `.env` en la raíz del proyecto con estas variables:

```bash
# MySQL Configuration
DB_HOST=db
DB_NAME=sociograma_db
DB_USER=sociograma_user
DB_PASSWORD=tu_password_aqui

# MySQL Root
MYSQL_ROOT_PASSWORD=tu_root_password_aqui

# Timezone
TZ=Europe/Madrid
```

**⚠️ Importante:** Cambia las contraseñas por las tuyas. Este archivo NO se sube a Git.

### 3. Levantar los contenedores

```bash
docker-compose up -d --build
```

Esto creará 3 contenedores:
- `sociograma-php` (PHP 8.2 + Apache)
- `sociograma-mysql` (MySQL 8.0)
- `sociograma-phpmyadmin` (Interfaz visual)

### 4. Verificar que funciona

Abre en tu navegador:
- **Aplicación:** http://localhost:8080
- **phpMyAdmin:** http://localhost:8081
- **Test conexión:** http://localhost:8080/test-connection.php

---

## 🔧 Comandos útiles

```bash
# Ver logs
docker-compose logs

# Ver logs de MySQL
docker-compose logs db

# Reiniciar contenedores
docker-compose restart

# Parar contenedores
docker-compose down

# Parar y eliminar volúmenes (resetea la BD)
docker-compose down -v

# Ver contenedores corriendo
docker-compose ps
```

---

## 🗂️ Estructura del proyecto

```
sociograma/
├── docker-compose.yml    # Orquestación de contenedores
├── Dockerfile            # Imagen PHP personalizada
├── .env                  # Variables de entorno (NO en Git)
├── .gitignore
├── database/
│   └── init.sql         # Script de inicialización BD
└── src/
    ├── index.php        # Formulario principal
    ├── process.php      # Procesamiento del formulario
    ├── api.php          # API JSON para Postman
    ├── includes/
    │   ├── header.php
    │   ├── footer.php
    │   ├── functions.php
    │   └── db.php       # Conexión MySQL
    ├── data/
    │   └── sociograma.json
    └── assets/
        ├── css/
        └── js/
```

---

## 🐘 Acceso a phpMyAdmin

- **URL:** http://localhost:8081
- **Usuario:** El valor de `DB_USER` en tu `.env`
- **Contraseña:** El valor de `DB_PASSWORD` en tu `.env`

---

## 📡 Probar la API con Postman

### Obtener todas las respuestas
```
GET http://localhost:8080/api.php
```

---

## 🤝 Contribuir

Este es un proyecto educativo. Si encuentras errores o mejoras:

1. Haz un fork
2. Crea una rama: `git checkout -b feature/mejora`
3. Commit: `git commit -m "feat: añadir mejora"`
4. Push: `git push origin feature/mejora`
5. Abre un Pull Request

---

## 📚 Tecnologías

- PHP 8.2
- MySQL 8.0
- Docker & Docker Compose
- Tailwind CSS (CDN)
- PDO para conexión segura

---

## 👨‍🎓 Autor

Ruth Daniela Aguirre - DAW - MONLAU