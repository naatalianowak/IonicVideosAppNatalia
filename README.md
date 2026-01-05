# 📽️ IonicVideosAppNatalia  
### Aplicación híbrida para la gestión de vídeos (Laravel + Ionic + Vue)

**IonicVideosAppNatalia** es una aplicación híbrida desarrollada con **Laravel** como backend (API REST) y **Ionic con Vue.js** como frontend. La aplicación permite a usuarios autenticados gestionar vídeos mediante operaciones **CRUD** (crear, visualizar, editar y eliminar), con especial protagonismo de la sección **“My Videos”**.

Este proyecto demuestra competencias en **desarrollo full-stack**, **arquitectura API**, **aplicaciones móviles híbridas**, **autenticación segura** y **despliegue para Android**, integrando tecnologías modernas del ecosistema web y mobile.

---

## 🚀 Funcionalidades Principales

🎬 **Gestión completa de vídeos**  
Creación, visualización, edición y eliminación de vídeos desde la pestaña **My Videos**, accesible únicamente para usuarios autenticados.

🔐 **Autenticación segura mediante API**  
Implementación de autenticación con **Laravel Sanctum**, garantizando acceso seguro desde clientes web y móviles.

📤 **Subida de vídeos**  
Soporte para formatos habituales como **MP4, AVI y MOV**, con validaciones de tipo y tamaño de archivo.

📱 **Interfaz híbrida móvil y web**  
Interfaz desarrollada con **Ionic**, compatible con:
- Navegadores web  
- Dispositivos Android  

⚙️ **Integración con Capacitor**  
Generación de aplicaciones nativas (**APK**) para Android a partir del proyecto web.

🧾 **Sistema de logs detallados**  
Registro de logs tanto en backend como en frontend para facilitar la depuración y el mantenimiento.

---

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel**
- **Laravel Sanctum**
- **PHP 8**
- **SQLite / MySQL**
- **API REST**

### Frontend
- **Ionic Framework**
- **Vue.js**
- **Capacitor**
- **HTML5 / CSS3 / JavaScript**

---

## 🧩 Arquitectura del Proyecto

- Backend desacoplado mediante **API REST**
- Autenticación por tokens
- Comunicación frontend–backend vía HTTP
- Enfoque escalable para futuras funcionalidades

---

## 📦 Instalación y Configuración

### 1️⃣ Requisitos Previos

Asegúrate de tener instalados los siguientes componentes:

- [PHP](https://www.php.net/) (mínimo PHP 8.x)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) y npm
- [Ionic CLI](https://ionicframework.com/docs/cli)
  ```bash
  npm install -g @ionic/cli
