document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion();
    tabs();
    botonesPaginador();
    paginaSiguiente();
    paginaAnterior();
    consultarAPI();
    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();
    mostrarResumen();
}

let paso = 1;
const pasoInicial = 1,
    pasoFinal = 3,
    cita = {
        id: "",
        nombre: "",
        fecha: "",
        hora: "",
        servicios: []
    };


function mostrarSeccion() {
    const seccionActual = document.querySelector(".mostrar");
    if (seccionActual) {
        seccionActual.classList.remove("mostrar");
    }
    document.querySelector("#paso-" + paso).classList.add("mostrar");

    const pasoActual = document.querySelector(".actual");
    if (pasoActual) {
        pasoActual.classList.remove("actual");
    }
    document.querySelector(`[data-paso="${paso}"]`).classList.add("actual");
}

function tabs() {
    document.querySelectorAll(".tabs button").forEach(button => {
        button.addEventListener("click", e => {
            e.preventDefault();
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        });
    });
}

function botonesPaginador() {
    const siguienteBtn = document.querySelector("#siguiente");
    const anteriorBtn = document.querySelector("#anterior");

    if (paso === 1) {
        anteriorBtn.classList.add("ocultar");
    } else {
        anteriorBtn.classList.remove("ocultar");
    }

    if (paso === 3) {
        siguienteBtn.classList.add("ocultar");
        mostrarResumen();
    } else {
        siguienteBtn.classList.remove("ocultar");
    }

    mostrarSeccion();
}

function paginaAnterior() {
    document.querySelector("#anterior").addEventListener("click", () => {
        if (paso > 1) {
            paso--;
            botonesPaginador();
        }
    });
}

function paginaSiguiente() {
    document.querySelector("#siguiente").addEventListener("click", () => {
        if (paso < 3) {
            paso++;
            botonesPaginador();
        }
    });
}

async function consultarAPI() {
    try {
        const url = `/api/servicios`;
        const response = await fetch(url);
        mostrarServicios(await response.json());
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreElement = document.createElement("p");
        nombreElement.classList.add("nombre-servicio");
        nombreElement.textContent = nombre;

        const precioElement = document.createElement("p");
        precioElement.classList.add("precio-servicio");
        precioElement.textContent = "$" + precio;

        const servicioElement = document.createElement("div");
        servicioElement.classList.add("servicio");
        servicioElement.dataset.idServicio = id;
        servicioElement.appendChild(nombreElement);
        servicioElement.appendChild(precioElement);

        servicioElement.onclick = function () {
            seleccionarServicio(servicio);
        };

        document.querySelector("#servicios").appendChild(servicioElement);
    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    if (servicios.some(s => s.id === id)) {
        cita.servicios = servicios.filter(s => s.id !== id);
        document.querySelector(`[data-id-servicio="${id}"]`).classList.remove("seleccionar");
    } else {
        cita.servicios = [...servicios, servicio];
        document.querySelector(`[data-id-servicio="${id}"]`).classList.add("seleccionar");
    }
}

function idCliente() {
    cita.id = document.querySelector("#id").value;
}

function nombreCliente() {
    cita.nombre = document.querySelector("#nombre").value;
}

function seleccionarFecha() {
    document.querySelector("#fecha").addEventListener("input", e => {
        const fechaSeleccionada = e.target.value;
        const diaSemana = new Date(fechaSeleccionada).getUTCDay();

        if ([0, 6].includes(diaSemana)) {
            mostrarAlerta("Los fines de semana no trabajamos", "error", null, true, "errorFecha");
            e.target.value = "";
            cita.fecha = "";
        } else {
            cita.fecha = fechaSeleccionada;

            const alertas = document.querySelectorAll('.errorFecha');
            if (alertas) {
                alertas.forEach(alerta => {
                    alerta.remove();
                })

            }
        }

        console.log(cita);
    });
}

function seleccionarHora() {
    document.querySelector("#hora").addEventListener("input", e => {
        const horaSeleccionada = e.target.value;
        const horaSplit = horaSeleccionada.split(":");

        if (horaSplit[0] < "10" || horaSplit[0] > "18") {
            mostrarAlerta("Disponibles de 10:00am a 7:00pm", "error", null, true, "errorHora" );
            e.target.value = "";
            cita.hora = "";
        } else {
            cita.hora = horaSeleccionada;
            //Quitar mensaje de error cuando el cliente ponga la hora correcta
            const alertas = document.querySelectorAll('.errorHora');
            if (alertas) {
                alertas.forEach(alerta =>{
                    alerta.remove();
                })

            }
        }

        console.log(cita);
    });
}

function mostrarAlerta(mensaje, tipo, selector = null, agregarAntes = true, classe = '') {

    const alertaElement = document.createElement("div");
    alertaElement.classList.add("alerta", tipo, classe);
    alertaElement.textContent = mensaje;
    
    if(classe !== ''){
        alertaElement.classList.add(classe);
    }

    const elementoFormulario = document.querySelector(selector ?? ".formulario");

    if (agregarAntes) {
        elementoFormulario.before(alertaElement);
    } else {
        elementoFormulario.appendChild(alertaElement);
    }

    // classe != '' ? alertaElement.classList.add(classe) : classe = null;
    // console.log(classe)

}









function mostrarResumen() {
    const contenidoResumen = document.querySelector(".contenido-resumen");

    while (contenidoResumen.firstChild) {
        contenidoResumen.removeChild(contenidoResumen.firstChild);
    }

    if (Object.values(cita).includes("") || cita.servicios.length === 0) {
        mostrarAlerta("Faltan datos de servicios, fecha u hora", "error", ".contenido-resumen", false, false);
        return;
    }

    const { nombre, fecha, hora, servicios } = cita;

    const serviciosTitulo = document.createElement("h3");
    serviciosTitulo.textContent = "Resumen de servicios";
    contenidoResumen.appendChild(serviciosTitulo);

    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const contenedorServicio = document.createElement("div");
        contenedorServicio.classList.add("contenedor-servicio");

        const nombreElement = document.createElement("p");
        nombreElement.textContent = nombre;

        const precioElement = document.createElement("p");
        precioElement.innerHTML = `<span>Precio: $${precio} </span>`;

        contenedorServicio.appendChild(nombreElement);
        contenedorServicio.appendChild(precioElement);

        contenidoResumen.appendChild(contenedorServicio);
    });

    const datosTitulo = document.createElement("h3");
    datosTitulo.textContent = "Datos seleccionados";
    contenidoResumen.appendChild(datosTitulo);

    const nombreElement = document.createElement("p");
    nombreElement.innerHTML = "<span>Nombre: </span> " + nombre;

    const fechaDate = new Date(fecha);
    const diaSemana = fechaDate.toLocaleDateString("es-MX", { weekday: "long", year: "numeric", month: "long", day: "numeric" });
    const fechaElement = document.createElement("p");
    fechaElement.innerHTML = "<span>Fecha: </span> " + diaSemana;

    const horaElement = document.createElement("p");
    horaElement.innerHTML = "<span>Hora: </span> " + hora;

    const reservarBtn = document.createElement("button");
    reservarBtn.classList.add("boton");
    reservarBtn.textContent = "Reservar Cita";
    reservarBtn.onclick = reservarCita;

    contenidoResumen.appendChild(nombreElement);
    contenidoResumen.appendChild(fechaElement);
    contenidoResumen.appendChild(horaElement);
    contenidoResumen.appendChild(reservarBtn);

    console.log(contenidoResumen);
}

async function reservarCita() {
    const { id, fecha, hora } = cita;
    const { servicios } = cita;
    const serviciosIds = servicios.map(servicio => servicio.id);

    const formData = new FormData();
    formData.append("fecha", fecha);
    formData.append("hora", hora);
    formData.append("usuarioId", id);
    formData.append("servicios", serviciosIds);

    try {
        const url = "/api/citas";
        const response = await fetch(url, { method: "POST", body: formData });
        const data = await response.json();

        console.log(data);

        if (data.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "Tu cita fue creada correctamente",
                button: "OK"
            }).then(() => {
                window.location.reload();
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Hubo un error, intenta de nuevo!"
        });
    }
}