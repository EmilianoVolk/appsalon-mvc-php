document.addEventListener('DOMContentLoaded', ()=>{
    iniciarApp();
})

function iniciarApp(){
    buscarFecha();
}

function buscarFecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', (e)=>{
        const fecha = e.target.value;

        window.location = `?fecha=${fecha}`
    })
}