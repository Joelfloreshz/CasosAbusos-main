# CasosAbusos
Proyecto enfocado seguimiento de casos de abuso hacia mujeres

## Configuración inicial para desarrolladores

Después de clonar el repositorio, ejecutar:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

Otra Terminal
npm run dev
```

## Credenciales de prueba

El sistema incluye usuarios de prueba con la contraseña: `password123`

- **Directora**: directora@melidas.org
- **Admin**: admin@melidas.org
- **Psicóloga**: psicologa@melidas.org
- **Abogada**: abogada@melidas.org

## Datos de prueba incluidos

Los seeders crean automáticamente:
- 5 usuarios con diferentes roles
- 5 proyectos (activos, finalizados, futuros)
- 6 casos de abuso (psicológicos y jurídicos)
- 5 seguimientos de casos
- 5 formularios dinámicos con 28 preguntas

## Recargar datos de prueba

Si necesitas resetear la base de datos con datos frescos:

```bash
php artisan migrate:fresh --seed
```

⚠️ **Advertencia**: Este comando borrará todos los datos existentes que se agregan manualmente adicionales a los seeders.
