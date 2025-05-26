# Requerimientos Funcionales y No Funcionales Actualizados con Devoluciones para Aplicación de Gestión de Productos

## Requerimientos Funcionales

### 1. Gestión de Productos (Prioridad Alta)

- **RF1.1**: Registrar nuevos productos: código único, nombre, descripción, unidad de medida, categoría, precio estándar, costo unitario, lote inicial (opcional).
- **RF1.2**: Editar/eliminar productos, con validación para transacciones asociadas, historial de cambios.
- **RF1.3**: Asociar productos a precios de campaña, estrategias FIFO/FEFO, cuentas PCGE (60.1).
- **RF1.4**: Importar/exportar productos in CSV.
- **RF1.5**: Reportes de productos por categoría, stock, precio, lote, exportables in CSV.
- **RF1.6**: Validar datos del producto (código único, unidad de medida SUNAT).

### 2. Gestión de Compras (Prioridad Alta)

- **RF2.1**: Registrar compras: proveedor (RUC, validación SUNAT), producto (código, lote, fecha de vencimiento), comprobante electrónico (boleta, factura), método de pago, cuenta 60.1.
- **RF2.2**: Generar **Registro de Compras** para SIRE (XML/CSV).
- **RF2.3**: Validar datos del comprobante (RUC, formato, IGV).
- **RF2.4**: Reportes de compras por período, proveedor, producto, lote, exportables in CSV.
- **RF2.5**: Almacenar comprobantes electrónicos (PDF/XML).
- **RF2.6**: Registrar **devoluciones al proveedor**:
  - Asociar a compra original.
  - Registrar productos devueltos (cantidad, lote, motivo).
  - Recibir nota de crédito (número, serie, fecha, monto).
  - Actualizar inventario, contabilidad (60.1, 42), Registro de Compras (SIRE).
  - Validar estado del lote.

### 3. Gestión de Ventas (Prioridad Alta)

- **RF3.1**: Registrar ventas: cliente (RUC/DNI), producto, comprobante electrónico, método de pago.
- **RF3.2**: Generar **Registro de Ventas e Ingresos** para SIRE (XML/CSV).
- **RF3.3**: Registrar descuentos promocionales in Registro de Ventas.
- **RF3.4**: Validar datos del comprobante y descuentos.
- **RF3.5**: Reportes de ventas por período, cliente, producto, lote, comprobante, exportables in CSV.
- **RF3.6**: Registrar **devoluciones de clientes**:
  - Asociar a venta original.
  - Registrar productos devueltos (cantidad, lote, motivo).
  - Emitir nota de crédito (número, serie, fecha, monto, código QR, portal web).
  - Actualizar inventario, contabilidad (70, 12), Registro de Ventas (SIRE).
  - Validar estado del producto.

### 4. Gestión de Pagos (Prioridad Alta)

- **RF4.1**: Registrar pagos: tipo (efectivo, Yape, Plin), estado, asociación con comprobante, registro contable (70, 12, 42).
- **RF4.2**: Confirmación manual/automática (APIs Yape/Plin).
- **RF4.3**: Reportes de pagos, exportables in CSV.
- **RF4.4**: Gestionar reembolsos por devoluciones de clientes:
  - Asociar al pago original y nota de crédito.
  - Registrar método de reembolso.
  - Actualizar contabilidad (12, 70).

### 5. Gestión de Inventarios (Prioridad Alta)

- **RF5.1**: Control de stock: cantidad, lote, fecha de vencimiento, ubicación.
- **RF5.2**: Estrategias FIFO/FEFO.
- **RF5.3**: Alertas para stock bajo o lotes próximos a vencer.
- **RF5.4**: Reportes de inventario, exportables in CSV.
- **RF5.5**: Gestionar ingresos/salidas por devoluciones:
  - Incrementar stock por devoluciones de clientes, validando reutilización.
  - Reducir stock por devoluciones al proveedor.
  - Registrar motivo y trazabilidad.

### 6. Gestión de Precios y Descuentos (Prioridad Alta)

- **RF6.1**: Asignar precios por producto/lote.
- **RF6.2**: Gestionar descuentos: tipo, ámbito, condiciones, registro de campaña.
- **RF6.3**: Historial de precios/descuentos.
- **RF6.4**: Validar descuentos contra costo.
- **RF6.5**: Reportes de precios/descuentos, exportables in CSV.

### 7. Registro de Gastos Operativos

- **RF7.1**: Registrar gastos: categorías PCGE (63, 65), comprobante, proveedor.
- **RF7.2**: Reportes de gastos, exportables in CSV.
- **RF7.3**: Exportar datos contables in XML/CSV.

### 8. Gestión de Clientes y Proveedores

- **RF8.1**: Crear, editar, eliminar clientes/proveedores (RUC/DNI).
- **RF8.2**: Validar RUC contra SUNAT.
- **RF8.3**: Reportes de clientes/proveedores.

### 9. Gestión de Comprobantes

- **RF9.1**: Gestionar comprobantes electrónicos (boletas, facturas, notas de crédito):
  - Generar para ventas y compras.
  - Registrar notas de crédito para devoluciones de clientes (emitidas) y al proveedor (recibidas).
  - Incluir: número, serie, fecha, RUC/DNI, monto gravado, IGV, total, código QR.
  - Publicar in portal web (5 años, Resolución N° 242-2018/SUNAT).
- **RF9.2**: Validar datos del comprobante.
- **RF9.3**: Exportar comprobantes in PDF/XML.
- **RF9.4**: Reportes de comprobantes por tipo, período, cliente/proveedor, exportables in CSV.

## Requerimientos No Funcionales

### 1. Rendimiento

- **RNF1.1**: Respuesta in menos de 2 segundos para productos, compras, ventas, devoluciones, SIRE.
- **RNF1.2**: Soporte para 20-50 usuarios concurrentes.

### 2. Seguridad

- **RNF2.1**: Autenticación con roles (administrador, vendedor, contador) usando **Shield de CodeIgniter**.
- **RNF2.2**: Encriptación de datos sensibles (Ley 29733) con CodeIgniter 4 y Shield.
- **RNF2.3**: Cumplimiento SUNAT: comprobantes electrónicos, SIRE.

### 3. Usabilidad

- **RNF3.1**: Interfaz sencilla con formularios para devoluciones (clientes, proveedores), implementada con **Bootstrap** y **DataTables** para reportes dinámicos.
- **RNF3.2**: Diseño responsivo con **Bootstrap**.
- **RNF3.3**: Guías contextuales para devoluciones y comprobantes.

### 4. Interoperabilidad

- **RNF4.1**: Exportación XML/CSV para SIRE, incluyendo devoluciones, con CodeIgniter 4.
- **RNF4.2**: (Opcional) Integración con APIs de Yape/Plin.
- **RNF4.3**: Compatibilidad con CONCAR, ContaPyme.

### 5. Escalabilidad y Disponibilidad

- **RNF5.1**: Soporte para 5,000 productos, 10,000 transacciones, optimizado con CodeIgniter 4.
- **RNF5.2**: Disponibilidad 99.9%, respaldos diarios.

### 6. Cumplimiento Normativo

- **RNF6.1**: Publicar comprobantes (incluyendo notas de crédito) in portal web (5 años).
- **RNF6.2**: Código QR in comprobantes.
- **RNF6.3**: Generar/exportar registros SIRE in XML/CSV.

### 7. Tecnologías de Desarrollo

- **RNF7.1**: Usar **CodeIgniter 4** para backend.
- **RNF7.2**: Autenticación con **Shield de CodeIgniter**.
- **RNF7.3**: Interfaz con **Bootstrap**.
- **RNF7.4**: Tablas dinámicas con **DataTables**.
- **RNF7.5**: Base de datos relacional (MySQL).
- **RNF7.6**: Compatibilidad con navegadores modernos.
