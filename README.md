# Alejandria


## Cómo levantar el proyecto

Clona el proyecto con:

```
git clone https://github.com/EvamAlonso95/tfg_alejandria.git
```

Para levantar todos los servicios del proyecto (PHP, MySQL, Qdrant, phpMyAdmin, etc.) usa el siguiente comando:

```bash
docker compose up -d --build
```

- `up -d --build`: construye las imágenes y levanta los contenedores en segundo plano.

## Cómo detener el proyecto

Para detener el proyecto, usa el siguiente comando:

```bash
docker compose down -v
```

- `down -v`: detendrá todos los contenedores y eliminará los volúmenes asociados.

---

## Nota importante sobre la precarga de datos

Este proyecto realiza una precarga automática de usuarios y libros en la base de datos y en Qdrant al iniciar.

**Es necesario esperar aproximadamente 60 segundos tras el arranque para que Qdrant tenga todos los libros cargados correctamente y esté listo para usarse.**
