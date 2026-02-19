# CoreData – Base de datos inicial para proyectos Laravel / Filament

Este repositorio contiene la **base de datos estructural inicial** utilizada como punto de partida para proyectos Laravel con Filament.

Su objetivo es proporcionar **migraciones y seeders reutilizables**, con datos mayormente **inmutables**, comunes a múltiples tipos de proyectos empresariales.

---

## 🎯 Propósito

`CoreData` NO es una aplicación ni un paquete Composer.

Es un **dataset estructural** pensado para:

- Inicializar proyectos nuevos rápidamente
- Estandarizar catálogos base
- Reducir trabajo repetitivo
- Servir como cimiento para:
  - Gestión de inventarios
  - Gestión de alquileres
  - Órdenes de servicio / producción
  - Proyectos administrativos en general

---

## 📦 Qué incluye

- Migraciones de tablas base
- Seeders con datos estructurales
- Catálogos reutilizables

Ejemplos típicos:
- País / departamentos / municipios
- Tipos de documento
- Monedas
- Estados de procesos
- Tipos de pago
- Estados genéricos (activo / inactivo)

---

## 🚫 Qué NO incluye

Para evitar errores conceptuales, este repositorio **NO debe contener**:

- Usuarios reales
- Clientes reales
- Proveedores reales
- Credenciales
- Tokens
- Datos financieros reales
- Configuración de entorno (`.env`)

Este repositorio es **estructural**, no operativo.

---

## 🗂️ Estructura del repositorio


