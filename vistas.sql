use isadeli;
/*
create view productoss
as
select p.id_producto, c.categoria, p.nombre_producto, p.precio_producto, p.existencias, p.descripcion, p.estado, i.imagen_producto
from categorias c , productos p, img_productos i
where p.id_categoria = c.id_categoria and i.id_producto = p.id_producto 

select * from productoss where id_producto = 2
*/
create view productosss
as
select i.imagen_producto, i.id_producto, i.id_presentacion
from img_productos i, productos p, presentaciones w
where i.id_producto = p.id_producto and i.id_presentacion = w.id_presentacion;

select * from productosss where id_producto = 1 or id_presentacion = 1;

create view bita
as
select b.id_tabla, a.id_tipo_accion, e.nombres_empleado, t.tabla, a.tipo_accion, b.descripcion, b.fecha_ingreso
from empleados e, tablas t, tipos_acciones a, bitacora b
where b.id_empleado = e.id_empleado and b.id_tabla = t.id_tabla and b.id_tipo_accion = a.id_tipo_accion;

select * from bita where cast( fecha_ingreso as date ) between '2016-06-11' and '2016-06-11' and nombres_empleado like '%ariel%' and id_tabla like '%%' and id_tipo_accion like '%%';

select * from bita where (nombres_empleado like '%ale %' and id_tabla like '%%' and id_tipo_accion like '%%' and cast( fecha_ingreso as date ) between '2016-06-11' and '2016-06-11'

select id_empleado from empleados where usuario = 'kratos' and clave = 123456;

create view carritooo
as
select p.id_producto, p.nombre_producto, c.nombres_cliente, c. apellidos_cliente, s.cantidad_producto
from productos p, clientes c, carrito s 
where s.id_img_producto = p.id_producto and s.id_cliente = c.id_cliente

select * from carritooo where nombres_cliente like '%diego%' and apellidos_cliente like '%campos%'

alter view entrega_horario_ver
as
select p.id_pedido, c.id_cliente, c.nombres_cliente, c.apellidos_cliente, d.direccion, j.nombre_producto, p.fecha_pedido, p.total, p.estado
from pedidos p, clientes c, direcciones d, carrito s, productos j, entregar_pedidos i, img_productos k, detalles_pedidos h
where s.id_cliente = c.id_cliente and s.id_img_producto = k.id_img_producto and h.id_img_producto = k.id_img_producto
and h.id_pedido = p.id_pedido and i.id_pedido = p.id_pedido and  h.id_pedido = j.id_producto /*hola xd*/


select * from entrega_horario_ver where id_pedido = 1;

create view horariosss
as
select h.id_horario_entrega, d.dia, h.hora_inicial, h.hora_final
from horarios_entrega h, dias d
where h.dia = d.id_dia

select * from horariosss


