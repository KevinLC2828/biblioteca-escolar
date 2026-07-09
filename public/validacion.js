/**
 * Validaciones básicas de cliente para los formularios de Libros y Préstamos.
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