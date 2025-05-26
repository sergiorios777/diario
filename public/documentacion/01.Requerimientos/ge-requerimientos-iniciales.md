# Planificación de Proyecto: Aplicación Web de Gestión de Negocio

**Tecnologías base:** CodeIgniter, Shield (CodeIgniter), Bootstrap 5, DataTables.

---

## Fase de Planificación del Proyecto

Esta fase es crucial para sentar las bases de tu aplicación y asegurar un desarrollo más fluido.

---

### 1. Definición Detallada del Alcance y Requisitos 🎯

Aunque ya tienes una idea general, es importante profundizar.

* **Requisitos Funcionales (Qué hará la aplicación):**
  * **Gestión de Productos:**
    * [ ] **Crear, Leer, Actualizar, Eliminar (CRUD)** productos (nombre, descripción, categoría, SKU opcional, unidad de medida, imagen opcional).
    * [ ] Definir precio de compra y precio de venta por producto.
    * [ ] Indicar stock mínimo y máximo deseado (para futuras alertas).
  * **Gestión de Ingresos de Productos (Compras):**
    * [ ] Registrar compras a proveedores (proveedor, fecha, número de factura/referencia).
    * [ ] Detallar productos comprados (producto, cantidad, costo unitario, costo total).
    * [ ] Actualizar automáticamente el stock al registrar una compra.
    * [ ] Gestionar devoluciones de compras a proveedores (motivo, productos, cantidades) y ajustar stock.
  * **Gestión de Salidas de Productos:**
    * [ ] Registrar ventas (cliente opcional, fecha, método de pago opcional).
    * [ ] Detallar productos vendidos (producto, cantidad, precio unitario, precio total).
    * [ ] Actualizar automáticamente el stock al registrar una venta.
    * [ ] Registrar descartes/mermas de productos (motivo, producto, cantidad) y ajustar stock.
    * [ ] Gestionar devoluciones de ventas de clientes (motivo, productos, cantidades) y ajustar stock.
  * **Control de Inventario:**
    * [ ] Visualizar el stock actual de cada producto.
    * [ ] Ver un historial de movimientos por producto (entradas, salidas, ajustes).
    * [ ] (Opcional para v1) Alertas de stock bajo.
  * **Gestión de Otros Gastos Operativos:**
    * [ ] Registrar gastos no relacionados con productos (ej: alquiler, servicios, marketing).
    * [ ] Campos: descripción del gasto, categoría (luz, agua, alquiler, etc.), monto, fecha, método de pago opcional.
    * [ ] CRUD para categorías de gastos.
  * **Autenticación y Autorización (con Shield):**
    * [ ] Registro de usuarios (si es necesario, o un único usuario administrador para v1).
    * [ ] Inicio y cierre de sesión.
    * [ ] (Opcional para v1) Roles y permisos si planeas múltiples usuarios con diferentes accesos.
  * **Reportes Básicos (para v1):**
    * [ ] Reporte de ventas (por período, por producto).
    * [ ] Reporte de compras (por período, por proveedor).
    * [ ] Reporte de gastos operativos (por período, por categoría).
    * [ ] Listado de inventario actual con valoración (stock * precio de compra/venta).
* **Requisitos No Funcionales (Cómo funcionará la aplicación):**
  * [ ] **Usabilidad:** Interfaz intuitiva y fácil de usar (Bootstrap 5 ayudará).
  * [ ] **Rendimiento:** Carga rápida de datos, especialmente en listados con DataTables.
  * [ ] **Seguridad:** Protección contra vulnerabilidades comunes (Shield y buenas prácticas de CodeIgniter).
  * [ ] **Mantenibilidad:** Código bien organizado y comentado para facilitar futuras actualizaciones.
  * [ ] **Compatibilidad:** Funcionamiento en navegadores web modernos.

---

### 2. Diseño de la Base de Datos 💾

Define la estructura de tu base de datos. Es uno de los pilares de la aplicación.

* [ ] **Identificar Entidades Principales:** Productos, Categorías de Productos, Proveedores (opcional para v1), Compras, Detalles de Compra, Ventas, Detalles de Venta, Movimientos de Inventario, Gastos, Categorías de Gastos, Usuarios (manejado por Shield).
* [ ] **Definir Atributos (campos) para cada Entidad:** Tipos de datos, longitudes, si son nulos o no.
  * *Ej: `productos` (id, nombre, descripcion, precio_compra, precio_venta, stock_actual, id_categoria_producto, fecha_creacion, fecha_actualizacion).*
  * *Ej: `movimientos_inventario` (id, id_producto, tipo_movimiento (compra, venta, ajuste_positivo, ajuste_negativo, devolucion_cliente, devolucion_proveedor), cantidad, fecha, id_referencia (ej: id_venta, id_compra), stock_anterior, stock_nuevo).*
* [ ] **Establecer Relaciones entre Entidades:** Claves primarias (PK) y claves foráneas (FK).
* [ ] **Normalizar la Base de Datos:** Para evitar redundancia y asegurar la integridad de los datos.
* [ ] **Crear un Diagrama Entidad-Relación (DER):** Visualizar la estructura.

---

### 3. Diseño de la Interfaz de Usuario (UI) y Experiencia de Usuario (UX) 🎨💻

Define cómo se verá y cómo interactuará el usuario con la aplicación.

* [ ] **Wireframes o Bocetos de Pantallas Clave:**
  * Login (manejado por Shield, personalizable).
  * Dashboard (vista principal con resúmenes).
  * Listado de Productos (con DataTables).
  * Formulario de Alta/Edición de Producto.
  * Listado de Compras.
  * Formulario de Registro de Compra.
  * Listado de Ventas.
  * Formulario de Registro de Venta.
  * Vista de Inventario Actual.
  * Listado de Otros Gastos.
  * Formulario de Registro de Otros Gastos.
* [ ] **Flujo de Navegación:** Cómo el usuario se moverá entre las diferentes secciones.
* [ ] **Definir el Layout Principal:** (Cabecera, menú lateral/superior, pie de página) usando Bootstrap 5.
* [ ] **Componentes de Bootstrap a Utilizar:** Identificar qué componentes se usarán.
* [ ] **Uso de DataTables:** Definir columnas, ordenamiento, búsqueda para cada listado.

---

### 4. Definición de la Arquitectura y Módulos (CodeIgniter) 🏗️

Organiza cómo estructurarás tu código en CodeIgniter.

* [ ] **Módulos Principales (Conceptuales):** Productos, Compras, Ventas, Inventario, Gastos.
* [ ] **Controladores:** `ProductController`, `PurchaseController`, `SaleController`, `ExpenseController`, `DashboardController`, etc.
* [ ] **Modelos:** `ProductModel`, `PurchaseModel`, `SaleModel`, `InventoryMovementModel`, etc.
* [ ] **Vistas:** Vistas para cada acción de los controladores.
* [ ] **Rutas:** Planificar las URLs.
* [ ] **Bibliotecas/Helpers:** Identificar si se necesitarán personalizados.
* [ ] **Configuración de Shield:** Planificar la configuración inicial.

---

### 5. Plan de Trabajo y Milestones (Hitos) 🗓️

Divide el proyecto en partes más pequeñas y manejables.

* [ ] **Establecer Hitos (Milestones):**
  1. **Hito 1: Configuración Base y Autenticación.**
  2. **Hito 2: Gestión de Productos.**
  3. **Hito 3: Gestión de Compras e Impacto en Inventario.**
  4. **Hito 4: Gestión de Ventas e Impacto en Inventario.**
  5. **Hito 5: Visualización de Inventario y Movimientos.**
  6. **Hito 6: Gestión de Otros Gastos.**
  7. **Hito 7: Reportes Básicos y Dashboard.**
  8. **Hito 8: Pruebas, Ajustes y Despliegue (v1).**
* [ ] **Estimar Tiempos (aproximados):** Asignar tiempo a cada tarea e hito.
* [ ] **Priorizar Funcionalidades:** Definir el MVP (Producto Mínimo Viable) para la v1.

---

### 6. Configuración del Entorno de Desarrollo ⚙️

Prepara todo lo necesario para empezar a codificar.

* [ ] **Servidor Local:** XAMPP, WAMP, MAMP, Laragon o Docker.
* [ ] **Editor de Código/IDE:** VS Code, PhpStorm, Sublime Text.
* [ ] **Gestor de Base de Datos:** phpMyAdmin, DBeaver, HeidiSQL, MySQL Workbench.
* [ ] **Control de Versiones:** Instalar Git y crear un repositorio.
* [ ] **Instalación de CodeIgniter.**
* [ ] **Instalación de Shield** (Composer y migraciones).
* [ ] **Integración de Bootstrap 5.**
* [ ] **Integración de DataTables.**

---

### 7. Identificación de Riesgos y Desafíos Potenciales ⚠️

Anticipa posibles problemas.

* [ ] **Curva de aprendizaje:** Nuevas tecnologías o funcionalidades.
* [ ] **Gestión del tiempo:** Si es un proyecto de tiempo parcial.
* [ ] **"Scope creep" (ampliación del alcance):** Mantenerse enfocado en el MVP de la v1.
* [ ] **Complejidad en la lógica de negocio:** Manejo preciso del stock.

---

Este documento te servirá como una guía y lista de verificación durante la fase de planificación de tu aplicación. ¡Mucho éxito con tu desarrollo!
