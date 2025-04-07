# 📽️ IonicVideosAppNatalia

IonicVideosAppNatalia és una aplicació híbrida desenvolupada amb **Laravel** (backend) i **Ionic amb Vue.js** (frontend) per a la gestió de vídeos. Permet als usuaris autenticats realitzar operacions CRUD (crear, visualitzar, editar i eliminar) sobre vídeos mitjançant una interfície intuïtiva, amb un enfocament especial a la pestanya "My Videos".

---

## 🚀 Funcionalitats Principals

✅ **Gestió de vídeos**: Creació, visualització, edició i eliminació de vídeos a la pestanya "My Videos".  
✅ **Autenticació d'usuaris**: Amb **Laravel Sanctum** per a una autenticació segura via API.  
✅ **Pujada de vídeos**: Suport per pujar vídeos en formats com MP4, AVI i MOV, amb validacions de mida i tipus.  
✅ **Interfície mòbil i web**: Desenvolupada amb Ionic per a una experiència híbrida compatible amb Android i web.  
✅ **Integració amb Capacitor**: Per generar aplicacions natives (APK) per a Android.  
✅ **Logs detallats**: Tant al backend com al frontend per facilitar la depuració d'errors.  

---

## 🛠️ Instal·lació

### 1️⃣ Requisits previs
Abans d'iniciar el projecte, assegura't de tenir instal·lats els següents programes:

- [PHP](https://www.php.net/) (mínim PHP 8.x)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) i npm
- [Ionic CLI](https://ionicframework.com/docs/cli) (`npm install -g @ionic/cli`)
- [Android SDK](https://developer.android.com/studio#command-line-tools-only) (per generar l'APK)
- [Java Development Kit (JDK)](https://www.oracle.com/java/technologies/javase-jdk11-downloads.html) (versió 11 o superior)
- [Git](https://git-scm.com/)

---

### 2️⃣ Clonar el Repositori
Clona el repositori des de GitHub:

```bash
git clone https://github.com/<teu-usuari>/IonicVideosAppNatalia.git
cd IonicVideosAppNatalia
```

---

### 3️⃣ Configuració del Backend (Laravel)
1. **Instal·la les dependències de PHP**:
   ```bash
   composer install
   ```

2. **Copia el fitxer d'entorn**:
   ```bash
   cp .env.example .env
   ```

3. **Genera la clau de l'aplicació**:
   ```bash
   php artisan key:generate
   ```

4. **Configura la base de dades**:
   - Edita el fitxer `.env` per configurar la base de dades (per exemple, SQLite):
     ```
     DB_CONNECTION=sqlite
     DB_DATABASE=/ruta/al/teu/projecte/database/database.sqlite
     ```
   - Crea el fitxer de base de dades si uses SQLite:
     ```bash
     touch database/database.sqlite
     ```

5. **Executa les migracions i el seeder**:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Inicia el servidor Laravel**:
   ```bash
   npm run dev
   php artisan serve
   ```

---

### 4️⃣ Configuració del Frontend (Ionic)
1. **Instal·la les dependències de Node.js**:
   ```bash
   npm install
   ```

2. **Inicia el servidor Ionic**:
   ```bash
   ionic serve
   ```
