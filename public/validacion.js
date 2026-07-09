/**
 * validacion.js
 * Validaciones básicas de cliente para todos los formularios del sistema.
 * Complementa (no reemplaza) las validaciones HTML5 y las de PHP en backend.
 */

document.addEventListener('DOMContentLoaded', function () {
    const formLibro = document.getElementById('form-libro');
    if (formLibro) {
        formLibro.addEventListener('submit', function (e) {
            const errores = [];

            const titulo = formLibro.querySelector('#titulo');
            const autor = formLibro.querySelector('#autor');
            const editorial = formLibro.querySelector('#editorial');
            const anio = formLibro.querySelector('#anio_publicacion');
            const isbn = formLibro.querySelector('#isbn');
            const stock = formLibro.querySelector('#stock');

            limpiarError(titulo);
            limpiarError(autor);
            limpiarError(editorial);
            limpiarError(anio);
            limpiarError(isbn);
            limpiarError(stock);

            if (!titulo.value.trim()) errores.push(marcarError(titulo, 'El título es obligatorio.'));
            if (!autor.value.trim()) errores.push(marcarError(autor, 'El autor es obligatorio.'));
            if (!editorial.value.trim()) errores.push(marcarError(editorial, 'La editorial es obligatoria.'));

            const anioNum = parseInt(anio.value, 10);
            const anioActual = new Date().getFullYear();
            if (!anio.value || isNaN(anioNum) || anioNum < 1400 || anioNum > anioActual) {
                errores.push(marcarError(anio, 'Ingrese un año válido (1400-' + anioActual + ').'));
            }

            const isbnLimpio = isbn.value.trim();
            if (!isbnLimpio) {
                errores.push(marcarError(isbn, 'El ISBN es obligatorio.'));
            } else if (!/^[0-9\-]{5,20}$/.test(isbnLimpio)) {
                errores.push(marcarError(isbn, 'El ISBN solo debe contener números y guiones.'));
            }

            const stockNum = parseInt(stock.value, 10);
            if (stock.value === '' || isNaN(stockNum) || stockNum < 0) {
                errores.push(marcarError(stock, 'El stock debe ser un número entero mayor o igual a 0.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const formPrestamo = document.getElementById('form-prestamo');
    if (formPrestamo) {
        formPrestamo.addEventListener('submit', function (e) {
            const errores = [];

            const libroId = formPrestamo.querySelector('#libro_id');
            const nombre = formPrestamo.querySelector('#nombre_prestatario');
            const curso = formPrestamo.querySelector('#curso_grado');
            const fPrestamo = formPrestamo.querySelector('#fecha_prestamo');
            const fEsperada = formPrestamo.querySelector('#fecha_devolucion_esperada');

            limpiarError(libroId);
            limpiarError(nombre);
            limpiarError(curso);
            limpiarError(fPrestamo);
            limpiarError(fEsperada);

            if (!libroId.value) errores.push(marcarError(libroId, 'Debe seleccionar un libro.'));
            if (!nombre.value.trim()) errores.push(marcarError(nombre, 'El nombre del estudiante es obligatorio.'));
            if (!curso.value.trim()) errores.push(marcarError(curso, 'El curso o grado es obligatorio.'));
            if (!fPrestamo.value) errores.push(marcarError(fPrestamo, 'La fecha de préstamo es obligatoria.'));

            if (!fEsperada.value) {
                errores.push(marcarError(fEsperada, 'La fecha de devolución esperada es obligatoria.'));
            } else if (fPrestamo.value && fEsperada.value < fPrestamo.value) {
                errores.push(marcarError(fEsperada, 'La devolución esperada no puede ser anterior al préstamo.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const formPrestamoEdit = document.getElementById('form-prestamo-edit');
    if (formPrestamoEdit) {
        formPrestamoEdit.addEventListener('submit', function (e) {
            const errores = [];

            const fReal = formPrestamoEdit.querySelector('#fecha_devolucion_real');
            const estado = formPrestamoEdit.querySelector('#estado');

            limpiarError(fReal);
            limpiarError(estado);

            if (estado.value === 'devuelto' && !fReal.value) {
                errores.push(marcarError(fReal, 'Debe indicar la fecha real de devolución.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const form_editorial = document.getElementById('form-editorial');
    if (form_editorial) {
        form_editorial.addEventListener('submit', function (e) {
            const errores = [];
            const form = form_editorial;

            const nombre = form.querySelector('#nombre');
            const pais = form.querySelector('#pais');
            const telefono = form.querySelector('#telefono');
            const email = form.querySelector('#email');

            limpiarError(nombre);
            limpiarError(pais);
            limpiarError(telefono);
            limpiarError(email);

            if (!nombre.value.trim()) {
                errores.push(marcarError(nombre, 'Nombre de la editorial es obligatorio.'));
            }
            if (!pais.value.trim()) {
                errores.push(marcarError(pais, 'País es obligatorio.'));
            }
            if (!telefono.value.trim()) {
                errores.push(marcarError(telefono, 'Teléfono es obligatorio.'));
            }
            const re_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !re_email.test(email.value.trim())) {
                errores.push(marcarError(email, 'Ingrese un correo electrónico válido.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const form_adquisicion = document.getElementById('form-adquisicion');
    if (form_adquisicion) {
        form_adquisicion.addEventListener('submit', function (e) {
            const errores = [];
            const form = form_adquisicion;

            const editorial_id = form.querySelector('#editorial_id');
            const titulo_obra = form.querySelector('#titulo_obra');
            const cantidad = form.querySelector('#cantidad');
            const fecha_adquisicion = form.querySelector('#fecha_adquisicion');
            const costo_unitario = form.querySelector('#costo_unitario');
            const estado = form.querySelector('#estado');

            limpiarError(editorial_id);
            limpiarError(titulo_obra);
            limpiarError(cantidad);
            limpiarError(fecha_adquisicion);
            limpiarError(costo_unitario);
            limpiarError(estado);

            if (!editorial_id.value) errores.push(marcarError(editorial_id, 'Debe seleccionar un(a) editorial.'));
            if (!titulo_obra.value.trim()) {
                errores.push(marcarError(titulo_obra, 'Título de la obra es obligatorio.'));
            }
            const num_cantidad = parseFloat(cantidad.value);
            if (cantidad.value === '' || isNaN(num_cantidad) || num_cantidad < 0) {
                errores.push(marcarError(cantidad, 'Ingrese un valor numérico válido.'));
            }
            if (!fecha_adquisicion.value) {
                errores.push(marcarError(fecha_adquisicion, 'La fecha es obligatoria.'));
            }
            const num_costo_unitario = parseFloat(costo_unitario.value);
            if (costo_unitario.value === '' || isNaN(num_costo_unitario) || num_costo_unitario < 0) {
                errores.push(marcarError(costo_unitario, 'Ingrese un valor numérico válido.'));
            }
            if (!estado.value) {
                errores.push(marcarError(estado, 'Debe seleccionar una opción.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const form_estudiante = document.getElementById('form-estudiante');
    if (form_estudiante) {
        form_estudiante.addEventListener('submit', function (e) {
            const errores = [];
            const form = form_estudiante;

            const nombres = form.querySelector('#nombres');
            const apellidos = form.querySelector('#apellidos');
            const curso_grado = form.querySelector('#curso_grado');
            const cedula = form.querySelector('#cedula');
            const email = form.querySelector('#email');

            limpiarError(nombres);
            limpiarError(apellidos);
            limpiarError(curso_grado);
            limpiarError(cedula);
            limpiarError(email);

            if (!nombres.value.trim()) {
                errores.push(marcarError(nombres, 'Nombres es obligatorio.'));
            }
            if (!apellidos.value.trim()) {
                errores.push(marcarError(apellidos, 'Apellidos es obligatorio.'));
            }
            if (!curso_grado.value.trim()) {
                errores.push(marcarError(curso_grado, 'Curso / Grado es obligatorio.'));
            }
            if (!cedula.value.trim()) {
                errores.push(marcarError(cedula, 'Cédula es obligatorio.'));
            }
            const re_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !re_email.test(email.value.trim())) {
                errores.push(marcarError(email, 'Ingrese un correo electrónico válido.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const form_sancion = document.getElementById('form-sancion');
    if (form_sancion) {
        form_sancion.addEventListener('submit', function (e) {
            const errores = [];
            const form = form_sancion;

            const estudiante_id = form.querySelector('#estudiante_id');
            const motivo = form.querySelector('#motivo');
            const monto = form.querySelector('#monto');
            const fecha_sancion = form.querySelector('#fecha_sancion');
            const estado = form.querySelector('#estado');

            limpiarError(estudiante_id);
            limpiarError(motivo);
            limpiarError(monto);
            limpiarError(fecha_sancion);
            limpiarError(estado);

            if (!estudiante_id.value) errores.push(marcarError(estudiante_id, 'Debe seleccionar un(a) estudiante.'));
            if (!motivo.value.trim()) {
                errores.push(marcarError(motivo, 'Motivo es obligatorio.'));
            }
            const num_monto = parseFloat(monto.value);
            if (monto.value === '' || isNaN(num_monto) || num_monto < 0) {
                errores.push(marcarError(monto, 'Ingrese un valor numérico válido.'));
            }
            if (!fecha_sancion.value) {
                errores.push(marcarError(fecha_sancion, 'La fecha es obligatoria.'));
            }
            if (!estado.value) {
                errores.push(marcarError(estado, 'Debe seleccionar una opción.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const form_empleado = document.getElementById('form-empleado');
    if (form_empleado) {
        form_empleado.addEventListener('submit', function (e) {
            const errores = [];
            const form = form_empleado;

            const nombres = form.querySelector('#nombres');
            const apellidos = form.querySelector('#apellidos');
            const cargo = form.querySelector('#cargo');
            const telefono = form.querySelector('#telefono');
            const email = form.querySelector('#email');

            limpiarError(nombres);
            limpiarError(apellidos);
            limpiarError(cargo);
            limpiarError(telefono);
            limpiarError(email);

            if (!nombres.value.trim()) {
                errores.push(marcarError(nombres, 'Nombres es obligatorio.'));
            }
            if (!apellidos.value.trim()) {
                errores.push(marcarError(apellidos, 'Apellidos es obligatorio.'));
            }
            if (!cargo.value.trim()) {
                errores.push(marcarError(cargo, 'Cargo es obligatorio.'));
            }
            if (!telefono.value.trim()) {
                errores.push(marcarError(telefono, 'Teléfono es obligatorio.'));
            }
            const re_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !re_email.test(email.value.trim())) {
                errores.push(marcarError(email, 'Ingrese un correo electrónico válido.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const form_turno = document.getElementById('form-turno');
    if (form_turno) {
        form_turno.addEventListener('submit', function (e) {
            const errores = [];
            const form = form_turno;

            const empleado_id = form.querySelector('#empleado_id');
            const dia_semana = form.querySelector('#dia_semana');
            const hora_inicio = form.querySelector('#hora_inicio');
            const hora_fin = form.querySelector('#hora_fin');
            const area = form.querySelector('#area');

            limpiarError(empleado_id);
            limpiarError(dia_semana);
            limpiarError(hora_inicio);
            limpiarError(hora_fin);
            limpiarError(area);

            if (!empleado_id.value) errores.push(marcarError(empleado_id, 'Debe seleccionar un(a) empleado.'));
            if (!dia_semana.value) {
                errores.push(marcarError(dia_semana, 'Debe seleccionar una opción.'));
            }
            if (!hora_inicio.value) {
                errores.push(marcarError(hora_inicio, 'La hora es obligatoria.'));
            }
            if (!hora_fin.value) {
                errores.push(marcarError(hora_fin, 'La hora es obligatoria.'));
            }
            if (!area.value.trim()) {
                errores.push(marcarError(area, 'Área asignada es obligatorio.'));
            }
            if (hora_inicio.value && hora_fin.value && hora_fin.value <= hora_inicio.value) {
                errores.push(marcarError(hora_fin, 'La hora de fin debe ser posterior a la hora de inicio.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const form_sala = document.getElementById('form-sala');
    if (form_sala) {
        form_sala.addEventListener('submit', function (e) {
            const errores = [];
            const form = form_sala;

            const nombre = form.querySelector('#nombre');
            const capacidad = form.querySelector('#capacidad');
            const ubicacion = form.querySelector('#ubicacion');
            const estado = form.querySelector('#estado');

            limpiarError(nombre);
            limpiarError(capacidad);
            limpiarError(ubicacion);
            limpiarError(estado);

            if (!nombre.value.trim()) {
                errores.push(marcarError(nombre, 'Nombre de la sala es obligatorio.'));
            }
            const num_capacidad = parseFloat(capacidad.value);
            if (capacidad.value === '' || isNaN(num_capacidad) || num_capacidad < 0) {
                errores.push(marcarError(capacidad, 'Ingrese un valor numérico válido.'));
            }
            if (!ubicacion.value.trim()) {
                errores.push(marcarError(ubicacion, 'Ubicación es obligatorio.'));
            }
            if (!estado.value) {
                errores.push(marcarError(estado, 'Debe seleccionar una opción.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    const form_reserva = document.getElementById('form-reserva');
    if (form_reserva) {
        form_reserva.addEventListener('submit', function (e) {
            const errores = [];
            const form = form_reserva;

            const sala_id = form.querySelector('#sala_id');
            const nombre_solicitante = form.querySelector('#nombre_solicitante');
            const fecha_reserva = form.querySelector('#fecha_reserva');
            const hora_inicio = form.querySelector('#hora_inicio');
            const hora_fin = form.querySelector('#hora_fin');
            const motivo = form.querySelector('#motivo');
            const estado = form.querySelector('#estado');

            limpiarError(sala_id);
            limpiarError(nombre_solicitante);
            limpiarError(fecha_reserva);
            limpiarError(hora_inicio);
            limpiarError(hora_fin);
            limpiarError(motivo);
            limpiarError(estado);

            if (!sala_id.value) errores.push(marcarError(sala_id, 'Debe seleccionar un(a) sala.'));
            if (!nombre_solicitante.value.trim()) {
                errores.push(marcarError(nombre_solicitante, 'Nombre del solicitante es obligatorio.'));
            }
            if (!fecha_reserva.value) {
                errores.push(marcarError(fecha_reserva, 'La fecha es obligatoria.'));
            }
            if (!hora_inicio.value) {
                errores.push(marcarError(hora_inicio, 'La hora es obligatoria.'));
            }
            if (!hora_fin.value) {
                errores.push(marcarError(hora_fin, 'La hora es obligatoria.'));
            }
            if (!motivo.value.trim()) {
                errores.push(marcarError(motivo, 'Motivo de la reserva es obligatorio.'));
            }
            if (!estado.value) {
                errores.push(marcarError(estado, 'Debe seleccionar una opción.'));
            }
            if (hora_inicio.value && hora_fin.value && hora_fin.value <= hora_inicio.value) {
                errores.push(marcarError(hora_fin, 'La hora de fin debe ser posterior a la hora de inicio.'));
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });
    }

    /** Muestra un mensaje de error debajo del campo, reutilizando el estilo .error del CSS */
    function marcarError(input, mensaje) {
        const campo = input.closest('.campo') || input.parentElement;
        let span = campo.querySelector('.error-js');
        if (!span) {
            span = document.createElement('span');
            span.className = 'error error-js';
            campo.appendChild(span);
        }
        span.textContent = mensaje;
        input.setAttribute('aria-invalid', 'true');
        return mensaje;
    }

    /** Limpia el mensaje de error JS previo de un campo (antes de revalidar) */
    function limpiarError(input) {
        if (!input) return;
        const campo = input.closest('.campo') || input.parentElement;
        const span = campo.querySelector('.error-js');
        if (span) span.remove();
        input.removeAttribute('aria-invalid');
    }
});
