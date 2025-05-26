# Planificación Integral del Proyecto: Aplicación Web de Gestión de Negocio

**Tecnologías base:** CodeIgniter 4, Shield (CodeIgniter), Bootstrap 5, DataTables, MySQL.

---

## Introducción

Este documento consolida el análisis de los requerimientos detallados proporcionados, la estrategia de desarrollo por fases (enfocada en un Producto Mínimo Viable - MVP), y la planificación específica para la Fase 1 (MVP Core) del proyecto de aplicación web para la gestión de un negocio. El objetivo es proporcionar una hoja de ruta clara y estructurada para el desarrollo.

---

## Sección 1: Análisis de Requerimientos Detallados (Versión Extendida del Usuario)

A continuación, se presenta el análisis, comentarios y sugerencias sobre los requerimientos funcionales y no funcionales detallados que proporcionaste, incluyendo la gestión de devoluciones y la conformidad con normativas peruanas.

### Comentarios Generales (Sobre Requerimientos Extendidos)

1. **Complejidad Aumentada:** Has añadido una capa significativa de complejidad, especialmente en lo referente a la localización peruana (facturación electrónica, SIRE, validaciones SUNAT, PCGE). Esto es realista y necesario, pero también implica un mayor esfuerzo de desarrollo.
2. **Interdependencias Claras:** Has hecho un buen trabajo identificando cómo las devoluciones afectan el inventario, la contabilidad y los registros fiscales.
3. **Priorización:** Aunque muchos requerimientos fueron marcados como "Prioridad Alta", es crucial considerar si todos son absolutamente indispensables para una primera versión funcional (MVP). Una estrategia de lanzamiento por fases es beneficiosa (desarrollada más adelante).

---

### Análisis y Sugerencias por Sección de Requerimientos Funcionales (RF)

**RF1: Gestión de Productos**
* **RF1.2 (Editar/eliminar con historial):** El "historial de cambios" es una excelente adición para auditoría. Define qué campos críticos necesitan este historial.
* **RF1.3 (FIFO/FEFO, cuentas PCGE):**
  * FIFO/FEFO son cruciales y tienen un impacto directo en la lógica. FEFO (Primero en Expirar, Primero en Salir) es más complejo.
  * La vinculación a cuentas PCGE (ej. 60.1) desde productos es avanzado; clarificar la lógica de asignación.
* **RF1.6 (Validar unidad de medida SUNAT):** Importante. Considerar un catálogo actualizable.
  * **Sugerencias RF1:** Para FIFO/FEFO, el diseño de tablas de lotes y movimientos es crítico. Para historial, considerar tabla de auditoría o soft deletes/versionado.

**RF2: Gestión de Compras**
* **RF2.1 (Proveedor RUC validación SUNAT, lote, fecha vencimiento):** Validación RUC es estándar. Lote y fecha de vencimiento vitales para FIFO/FEFO.
* **RF2.2 (Registro de Compras para SIRE):** Requerimiento mayor. Necesitarás estructura exacta (XML/CSV) de SUNAT SIRE.
* **RF2.5 (Almacenar comprobantes PDF/XML):** Considerar volumen de almacenamiento.
* **RF2.6 (Devoluciones al proveedor):** Bien detallado. Actualización de inventario, contabilidad (60.1, 42), y Registro de Compras (SIRE) es complejo pero necesario. "Validar estado del lote" es importante.
    * **Sugerencias RF2:** Para validación RUC, usar servicios web SUNAT/terceros. Para SIRE, conocer especificaciones técnicas de SUNAT.

**RF3: Gestión de Ventas**

* **RF3.2 (Registro de Ventas e Ingresos para SIRE):** Similar a RF2.2, desarrollo clave.
* **RF3.6 (Devoluciones de clientes):** Excelente detalle. Emisión de nota de crédito electrónica (QR, portal web) y actualización contable (70, 12) e impacto en SIRE son cruciales. "Validar estado del producto devuelto" es clave.
    * **Sugerencias RF3:** La generación de comprobantes electrónicos es compleja. Considerar desarrollar desde cero (XML, firma, comunicación SUNAT) o usar un Proveedor de Servicios Electrónicos (PSE) homologado.

**RF4: Gestión de Pagos**

* **RF4.1 (Tipos Yape/Plin, registro contable):** Correcta especificación de métodos y afectación contable (70, 12, 42).
* **RF4.2 (Confirmación automática Yape/Plin):** Integración API es desarrollo significativo.
* **RF4.4 (Reembolsos por devoluciones):** Correcta vinculación con nota de crédito y contabilidad.

**RF5: Gestión de Inventarios**

* **RF5.1 (Ubicación):** Útil para múltiples almacenes/secciones, añade complejidad.
* **RF5.2 (FIFO/FEFO):** Reafirma necesidad de lógica robusta.
* **RF5.5 (Ingresos/salidas por devoluciones):** "Validando reutilización" es un detalle práctico.

**RF6: Gestión de Precios y Descuentos**

* Bien detallado. **RF6.4 (Validar descuentos contra costo)** es importante para rentabilidad.

**RF7: Registro de Gastos Operativos**

* **RF7.1 (Categorías PCGE 63, 65):** Buena especificación contable.

**RF8: Gestión de Clientes y Proveedores**

* Estándar. Validación de RUC (RF8.2) es importante.

**RF9: Gestión de Comprobantes**

* Centraliza requisitos de facturación electrónica.
* **RF9.1 (Generar para ventas y compras):** Para "compras", usualmente se registran comprobantes emitidos *por el proveedor*. La emisión es para ventas y notas de crédito de ventas. Para devoluciones a proveedor, se *registra* la nota de crédito emitida *por el proveedor*.
* **RF9.1 (Publicar en portal web por 5 años):** Requisito SUNAT significativo (Res. N° 193-2020/SUNAT y otras). Implica interfaz segura para consulta/descarga por clientes.
  * **Sugerencias RF9:** Evaluar PSE. Si es desarrollo interno para e-invoicing: generación XML UBL 2.1, firma digital, envío a SUNAT, manejo de CDR, PDF con QR. Portal de comprobantes debe ser seguro y disponible.

---

### Análisis y Sugerencias por Sección de Requerimientos No Funcionales (RNF)

**RNF1: Rendimiento**

* Metas razonables (respuesta < 2s, 20-50 usuarios). Consultas FIFO/FEFO y SIRE pueden ser intensivas; optimizar base de datos (indexación) y consultas.

**RNF2: Seguridad**

* **RNF2.1 (Roles con Shield):** Shield es buena base. Definir permisos granulares.
* **RNF2.2 (Encriptación Ley 29733):** Identificar datos personales/sensibles. Usar librerías de CodeIgniter. Shield maneja hashing de contraseñas.
* **RNF2.3 (Cumplimiento SUNAT):** Hilo conductor en muchos RNF.

**RNF3: Usabilidad**

* Buenas elecciones (Bootstrap, DataTables). "Guías contextuales" (RNF3.3) para procesos complejos son excelente idea.

**RNF4: Interoperabilidad**

* **RNF4.1 (Exportación SIRE):** Crítico.
* **RNF4.3 (Compatibilidad CONCAR, ContaPyme):** Implica generar archivos de exportación (TXT/CSV) según especificaciones de estos sistemas. Punto de integración importante.

**RNF5: Escalabilidad y Disponibilidad**

* **RNF5.1 (5,000 productos, 10,000 transacciones):** Aclarar período (¿mensual/anual?). Manejable con stack optimizado. Considerar archivado de datos a largo plazo.
* **RNF5.2 (Respaldos diarios):** Esencial (BD y archivos XML/PDF).

**RNF6: Cumplimiento Normativo**

* Reitera puntos clave de SUNAT.

**RNF7: Tecnologías de Desarrollo**

* Pila tecnológica coherente.

---

### Sugerencias Adicionales y Puntos Críticos (Sobre Requerimientos Extendidos)

1.  **MVP y Fases (Desarrollado en Sección 2):**
    * Dada la amplitud, es **fundamental** definir un MVP acotado y proceder por fases para gestionar la complejidad y entregar valor incrementalmente.
2.  **Investigación SUNAT:**
    * Invertir tiempo en entender a fondo las **últimas resoluciones y especificaciones técnicas de SUNAT** para comprobantes electrónicos, SIRE y portal de consulta. Estas normativas pueden cambiar.
    * Visitar el portal de SUNAT y buscar documentación para desarrolladores/contribuyentes.
3.  **Contador/Asesor:**
    * Si es posible, validar flujos contables (PCGE, afectaciones por devoluciones, etc.) y requisitos SIRE con un contador familiarizado. Su feedback puede ser invaluable.
4.  **Diseño de Base de Datos (Detallado en Fase 1):**
    * Prestar especial atención al diseño de tablas para lotes, movimientos de inventario, y almacenamiento de datos para comprobantes electrónicos y SIRE. Normalización y correcta definición de relaciones e índices serán cruciales.

---

## Sección 2: Estrategia de Desarrollo por Fases (MVP)

Para abordar la complejidad del proyecto, especialmente los requisitos de SUNAT, se propone una estrategia de desarrollo por fases, comenzando con un Producto Mínimo Viable (MVP) Core.

* **Fase 1 (MVP Core):**
  * **Descripción:** Funcionalidades básicas de registro de productos, compras y ventas manuales simples, control de stock básico por movimiento, gestión básica de clientes/proveedores y otros gastos operativos. Autenticación.
  * **Objetivo:** Tener una aplicación funcional para las operaciones diarias más esenciales, sin la complejidad de la facturación electrónica completa ni SIRE.
* **Fase 2 (Facturación Electrónica Ventas):**
  * **Descripción:** Implementar la generación y envío de facturas y boletas electrónicas de venta según normativa SUNAT. Incluye la creación del portal de consulta de estos comprobantes para clientes.
  * **Objetivo:** Cumplir con los requisitos básicos de emisión de comprobantes de venta electrónicos.
* **Fase 3 (SIRE - Sistema Integrado de Registros Electrónicos):**
  * **Descripción:** Desarrollar la generación de los archivos XML/CSV para el Registro de Compras y el Registro de Ventas e Ingresos compatibles con SIRE.
  * **Objetivo:** Cumplir con la obligación de llevar los registros electrónicos según SUNAT.
* **Fase 4 (Devoluciones y Notas de Crédito Completas):**
  * **Descripción:** Implementar todo el flujo de devoluciones de clientes y a proveedores, incluyendo la emisión/registro de notas de crédito electrónicas, y su impacto en inventario, contabilidad y SIRE.
  * **Objetivo:** Gestionar el ciclo completo de devoluciones y su documentación fiscal.
* **Fase 5 (Contabilidad Avanzada e Integraciones):**
  * **Descripción:** Implementar lógicas avanzadas de inventario (FIFO/FEFO), enlaces detallados con cuentas PCGE, exportaciones a software contable (CONCAR, ContaPyme), e integraciones opcionales con APIs (Yape/Plin).
  * **Objetivo:** Proveer herramientas avanzadas de gestión y facilitar la integración con el ecosistema contable y de pagos.

---

## Sección 3: Planificación Detallada - Fase 1 (MVP Core)

**Objetivo Principal del MVP Core:** Registrar productos, gestionar compras y ventas simples, controlar el stock básico, registrar clientes/proveedores y otros gastos operativos, con un sistema de autenticación.

---

### 1. Requisitos Funcionales Detallados para el MVP Core 🎯

* **Autenticación y Usuarios (Usando Shield de CodeIgniter):**
  * [ ] **RF-MVP-AUTH.1:** Sistema de inicio y cierre de sesión para un único tipo de usuario (Administrador).
  * [ ] **RF-MVP-AUTH.2:** (Opcional) Página de registro de usuario (para el primer administrador) o creación manual/seeder.
  * **Fuera del MVP Core:** Roles y permisos complejos.

* **Gestión de Productos (Básico):**
    * [ ] **RF-MVP-PROD.1:** Registrar: Código (manual/autogenerado simple), nombre, descripción, unidad de medida (lista simple), precio venta estándar, costo unitario estándar. Lote inicial (informativo). Categoría (texto simple/tabla básica).
    * [ ] **RF-MVP-PROD.2:** Listar productos (DataTables: búsqueda, paginación).
    * [ ] **RF-MVP-PROD.3:** Editar información básica.
    * [ ] **RF-MVP-PROD.4:** Eliminar productos (soft delete/validación).
    * **Fuera del MVP Core:** Precios de campaña, FIFO/FEFO, PCGE, import/export, reportes avanzados, validación SUNAT exhaustiva.

* **Gestión de Compras (Registro Manual Simplificado):**
    * [ ] **RF-MVP-COMP.1:** Registrar: Fecha, Proveedor (texto/lista simple), productos comprados (producto, cantidad, costo unitario).
    * [ ] **RF-MVP-COMP.2:** Listar compras.
    * [ ] **RF-MVP-COMP.3:** Ver detalle de compra.
    * **Fuera del MVP Core:** Gestión detallada proveedores (RUC, validación SUNAT), e-comprobantes, métodos pago, PCGE, SIRE, devoluciones, PDF/XML.

* **Gestión de Ventas (Registro Manual Simplificado):**
    * [ ] **RF-MVP-VENT.1:** Registrar: Fecha, Cliente (texto/lista simple), productos vendidos (producto, cantidad, precio venta, total).
    * [ ] **RF-MVP-VENT.2:** Listar ventas.
    * [ ] **RF-MVP-VENT.3:** Ver detalle de venta.
    * **Fuera del MVP Core:** Gestión detallada clientes (RUC/DNI), e-comprobantes, SIRE, descuentos, métodos pago, devoluciones.

* **Gestión de Inventarios (Básico y Automático por Movimientos):**
    * [ ] **RF-MVP-INV.1:** Stock se actualiza por compra (incrementa).
    * [ ] **RF-MVP-INV.2:** Stock se actualiza por venta (decrementa, validar disponibilidad).
    * [ ] **RF-MVP-INV.3:** Visualizar stock actual (lista productos/apartado simple).
    * **Fuera del MVP Core:** Lotes, fechas vencimiento, FIFO/FEFO, alertas stock bajo, reportes detallados, ubicaciones, devoluciones complejas.

* **Gestión de Clientes y Proveedores (Básico):**
    * [ ] **RF-MVP-CP.1:** Registrar clientes: Nombre/Razón Social, (opcional DNI/RUC texto simple).
    * [ ] **RF-MVP-CP.2:** Listar, Editar, Eliminar clientes.
    * [ ] **RF-MVP-CP.3:** Registrar proveedores: Nombre/Razón Social, (opcional RUC texto simple).
    * [ ] **RF-MVP-CP.4:** Listar, Editar, Eliminar proveedores.
    * **Fuera del MVP Core:** Validación RUC/DNI SUNAT, reportes avanzados.

* **Registro de Gastos Operativos (Básico):**
    * [ ] **RF-MVP-GAST.1:** Registrar: Fecha, descripción, monto, categoría de gasto (lista simple).
    * [ ] **RF-MVP-GAST.2:** Listar, Editar, Eliminar gastos.
    * **Fuera del MVP Core:** Vinculación comprobantes, proveedores gastos, PCGE, reportes avanzados, exportación contable.

---

### 2. Diseño de la Base de Datos para el MVP Core 💾

* [ ] **`users`** (Shield): `id`, `username`, `email`, `password_hash`, etc.
* [ ] **`products`**: `id`, `code`, `name`, `description`, `unit_of_measure`, `sale_price`, `cost_price`, `stock_quantity`, `category_id` (FK, NULLABLE), `created_at`, `updated_at`.
* [ ] **`product_categories`** (opcional): `id`, `name`, `created_at`, `updated_at`.
* [ ] **`customers`**: `id`, `name`, `document_number` (NULLABLE), `created_at`, `updated_at`.
* [ ] **`suppliers`**: `id`, `name`, `ruc` (NULLABLE), `created_at`, `updated_at`.
* [ ] **`purchases`**: `id`, `supplier_id` (FK, NULLABLE) / `supplier_name`, `purchase_date`, `total_amount`, `created_at`, `updated_at`.
* [ ] **`purchase_items`**: `id`, `purchase_id` (FK), `product_id` (FK), `quantity`, `unit_cost`, `subtotal`, `created_at`, `updated_at`.
* [ ] **`sales`**: `id`, `customer_id` (FK, NULLABLE) / `customer_name`, `sale_date`, `total_amount`, `created_at`, `updated_at`.
* [ ] **`sale_items`**: `id`, `sale_id` (FK), `product_id` (FK), `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`.
* [ ] **`expenses`**: `id`, `expense_date`, `description`, `amount`, `expense_category_id` (FK, NULLABLE), `created_at`, `updated_at`.
* [ ] **`expense_categories`** (opcional): `id`, `name`, `created_at`, `updated_at`.
* [ ] **`inventory_movements`** (Considerar para trazabilidad básica): `id`, `product_id` (FK), `type` (ENUM('purchase', 'sale', 'initial_stock', 'adjustment')), `quantity_change`, `new_stock_quantity`, `movement_date`, `reference_id`, `created_at`.

**Tareas de Diseño de BD (MVP Core):**
* [ ] Definir todas las columnas, tipos de datos, restricciones.
* [ ] Establecer relaciones con claves foráneas.
* [ ] Crear script SQL o migraciones de CodeIgniter.

---

### 3. Diseño de UI/UX para el MVP Core 🎨💻

* [ ] **Layout General:** Plantilla base Bootstrap 5 (cabecera, menú, contenido, pie). Menú: Productos, Compras, Ventas, (Inventario), Clientes, Proveedores, Gastos.
* [ ] **Wireframes/Bocetos (MVP):** Login (Shield), Dashboard (simple), Productos (Listado/Formulario), Compras (Listado/Formulario/Detalle), Ventas (Listado/Formulario/Detalle), Clientes (Listado/Formulario), Proveedores (Listado/Formulario), Gastos (Listado/Formulario).
* [ ] **Componentes Bootstrap:** Identificar uso de formularios, tablas, botones, alertas, modales simples.

---

### 4. Definición de Arquitectura y Módulos (CodeIgniter) para el MVP Core 🏗️

* [ ] **Estructura de Carpetas:** Organizar controladores, modelos, vistas.
* [ ] **Controladores (MVP):** `AuthController` (Shield), `ProductController`, `PurchaseController`, `SaleController`, `CustomerController`, `SupplierController`, `ExpenseController`, `DashboardController`.
* [ ] **Modelos (MVP):** `ProductModel`, `PurchaseModel`, `PurchaseItemModel`, `SaleModel`, `SaleItemModel`, `CustomerModel`, `SupplierModel`, `ExpenseModel`, (Opcional: `ProductCategoryModel`, `ExpenseCategoryModel`), (Si se incluye: `InventoryMovementModel`).
* [ ] **Vistas (MVP):** Vistas para CRUD y listados.
* [ ] **Rutas (MVP):** Definir en `app/Config/Routes.php`.
* [ ] **Helpers/Libraries (MVP):** Identificar helpers simples (formateo).

---

### 5. Plan de Trabajo Detallado para el MVP Core (Tareas Específicas) 🗓️

1.  **Configuración Inicial del Proyecto (Hito 0):**
    * [ ] Instalar CodeIgniter 4, configurar BD (`.env`).
    * [ ] Instalar y configurar Shield (migraciones, rutas auth).
    * [ ] Integrar Bootstrap 5 en layout.
    * [ ] Integrar DataTables (JS/CSS base).
    * [ ] Crear primer usuario administrador.
    * [ ] Configurar Git.
2.  **Módulo de Productos (MVP):**
    * [ ] Migraciones `products` (y `product_categories`).
    * [ ] `ProductModel` (y `ProductCategoryModel`).
    * [ ] `ProductController` (CRUD).
    * [ ] Vistas (listar, crear, editar).
3.  **Módulo de Clientes (MVP):**
    * [ ] Migración `customers`. Model, Controller (CRUD), Vistas.
4.  **Módulo de Proveedores (MVP):**
    * [ ] Migración `suppliers`. Model, Controller (CRUD), Vistas.
5.  **Módulo de Compras (MVP) e Impacto en Inventario:**
    * [ ] Migraciones `purchases`, `purchase_items`.
    * [ ] `PurchaseModel`, `PurchaseItemModel`.
    * [ ] `PurchaseController` (registrar, listar, detalle).
    * [ ] Lógica actualización `products.stock_quantity`.
    * [ ] (Opcional) Registrar en `inventory_movements`.
    * [ ] Vistas (registrar, listar, detalle).
6.  **Módulo de Ventas (MVP) e Impacto en Inventario:**
    * [ ] Migraciones `sales`, `sale_items`.
    * [ ] `SaleModel`, `SaleItemModel`.
    * [ ] `SaleController` (registrar, listar, detalle).
    * [ ] Lógica actualización `products.stock_quantity` (validar stock).
    * [ ] (Opcional) Registrar en `inventory_movements`.
    * [ ] Vistas (registrar, listar, detalle).
7.  **Módulo de Gastos Operativos (MVP):**
    * [ ] Migraciones `expenses` (y `expense_categories`).
    * [ ] `ExpenseModel` (y `ExpenseCategoryModel`).
    * [ ] `ExpenseController` (CRUD).
    * [ ] Vistas (listar, crear, editar).
8.  **Dashboard Básico y Refinamientos (MVP):**
    * [ ] `DashboardController` y vista simple.
    * [ ] Pruebas básicas, consistencia UI.

---

### 6. Estimación de Tiempos (Muy General para MVP Core) ⏱️

* Configuración Inicial: 1-2 días.
* Módulo de Productos: 3-5 días.
* Módulos Clientes/Proveedores: 2-3 días (cada uno).
* Módulo de Compras: 4-6 días.
* Módulo de Ventas: 4-6 días.
* Módulo de Gastos: 2-3 días.
* Dashboard y Pruebas: 1-2 días.
* **Total Estimado MVP Core: 19 - 30 días de desarrollo (aprox. 4-6 semanas a buen ritmo).**

---

## Conclusión

Este documento proporciona una base sólida para la planificación y ejecución de tu proyecto. El enfoque por fases, comenzando con un MVP Core bien definido, te permitirá gestionar la complejidad, obtener retroalimentación temprana y construir gradualmente una solución robusta y completa. ¡Mucho éxito!