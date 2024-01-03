/*
   Project: Laboratory Equipment Inventory Management
   Description: JavaScript functions for handling form validation and fetching data from consulta.php.
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/



function mostrarLeyenda() {
  var codigoInput = document.getElementById('codigo_busqueda');
  if (codigoInput.value === '') {
    codigoInput.value = 'Escribe aquí...';
  }
}


function ocultarLeyenda() {
  var codigoInput = document.getElementById('codigo_busqueda');
  if (codigoInput.value === 'Escribe aquí...') {
    codigoInput.value = '';
  }
}

function llenarCamposDelPrestador(nombre, codigo) {
  document.getElementById('nombre_prestador').value = nombre;
  document.getElementById('codigo_prestador').value = codigo;
}
function updateCampos(id) {
  const updatedOtros = document.getElementById(`otros-${id}`).innerText;
  const updatedEquipos = document.getElementById(`equipos-${id}`).innerText;
  const updatedComentarios = document.getElementById(`comentarios-${id}`).innerText;

  // Obtener el valor seleccionado de la barra desplegable
  const updatedEstado = document.getElementById(`estado-${id}`).value;

  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
      // ... (Código existente)
  };

  xhr.open("POST", "actualizar_campos.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Incluir el valor de "Estado" en la solicitud POST
  xhr.send(`id=${id}&otros=${encodeURIComponent(updatedOtros)}&equipos=${encodeURIComponent(updatedEquipos)}&comentarios=${encodeURIComponent(updatedComentarios)}&estado=${encodeURIComponent(updatedEstado)}`);
}



function exportarExcel() {
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
      if (xhr.readyState == 4) {
          if (xhr.status == 200) {
              alert('El archivo de Excel se ha creado exitosamente.');
          } else {
              alert('No se logró crear el archivo de Excel. Puede deberse a un problema de permisos en la carpeta.');
          }
      }
  };

  xhr.open("GET", "exportar_excel.php", true);  
  xhr.send();
}


function buscarEstudiante() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      var respuesta = JSON.parse(this.responseText);

      if (respuesta.encontrado) {
        llenarCampos(respuesta.nombre, respuesta.codigo);
      } else {
        alert("No se encontró información del estudiante disponible.");
      }
    }
  };

  xhttp.open("GET", "adjuntar_estudiante.php", true);
  xhttp.send();
}

function llenarCampos(nombre, codigo) {
  document.getElementById('nombre').value = nombre;
  document.getElementById('codigo').value = codigo;
}




function buscarPrestador() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      var respuesta = JSON.parse(this.responseText);

      if (respuesta.encontrado) {
        llenarCamposDelPrestador(respuesta.nombre, respuesta.codigo);
      } else {
        alert("No se encontró información del estudiante disponible.");
      }
    }
  };

  xhttp.open("GET", "adjuntar_estudiante.php", true);
  xhttp.send();
}





function mostrarFuentesDisponibles() {
  const fuentesDiv = document.getElementById('fuentesDisponibles');
fuentesDiv.innerHTML = '';  // Limpiamos cualquier contenido previo

const xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    const marcas = JSON.parse(this.responseText);

    if (marcas.length > 0) {

      
      const fuentesLabel = document.createElement('label');
      
      fuentesDiv.appendChild(fuentesLabel);

      for (let i = 0; i < marcas.length; i++) {
        const label = document.createElement('label');
        label.innerText = `F(${marcas[i]})`;
        fuentesDiv.appendChild(label);

        

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'Equipos[]';  // Cambia esto según tu necesidad
        checkbox.value = marcas[i];
        fuentesDiv.appendChild(checkbox);

        fuentesDiv.appendChild(document.createElement('br'));
      }
    } else {
      const noFuentesLabel = document.createElement('label');
      noFuentesLabel.innerText = 'No hay fuentes disponibles.';
      fuentesDiv.appendChild(noFuentesLabel);
    }
  }
};
xhttp.open('GET', 'fuentes_disponibles.php', true);
xhttp.send();

}


window.addEventListener('load', mostrarFuentesDisponibles);


function mostrarMultimetrosDisponibles() {
  const multimetrosDiv = document.getElementById('multimetrosDisponibles');
  multimetrosDiv.innerHTML = '';  // Limpiamos cualquier contenido previo

  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
          const marcas = JSON.parse(this.responseText);
          if (marcas.length > 0) {
              const checkboxContainer = document.createElement('div');
              checkboxContainer.classList.add('checkbox-container');

              // Crear checkboxes para cada marca
              marcas.forEach(marca => {
                  const checkbox = document.createElement('input');
                  checkbox.type = 'checkbox';
                  checkbox.name = 'Equipos[]';
                  checkbox.value = marca;
                  checkboxContainer.appendChild(checkbox);

                  const label = document.createElement('label');
                  label.appendChild(document.createTextNode('M(' + marca + ')'));
                  checkboxContainer.appendChild(label);

                  checkboxContainer.appendChild(document.createElement('br')); // Agrega un salto de línea
              });

              multimetrosDiv.appendChild(checkboxContainer);
          } else {
              multimetrosDiv.appendChild(document.createTextNode('No hay multímetros disponibles.'));
          }
      }
  };
  xhttp.open('GET', 'multimetros_disponibles.php', true);  // Ruta correcta al script PHP
  xhttp.send();
}

// Llama a la función para mostrar los multímetros disponibles al cargar la página
window.addEventListener('load', mostrarMultimetrosDisponibles);





function enviarFormulario() {
  if (validarFormulario()) {
    document.getElementById('formulario').submit();
  }
}



function validarFormulario() {
  const nombre = document.getElementById('nombre').value.trim();
  const codigo = document.getElementById('codigo').value.trim();
  const codigo_prestador = document.getElementById('codigo_prestador').value.trim();
  const equipos = document.getElementsByName('Equipos[]');
  const otros = document.getElementById('otros').value;
  const comentarios = document.getElementById('comm').value;

  if (nombre === '') {
    alert('Debes ingresar un nombre.');
    return false;
  }

  if (codigo.length !== 9 || isNaN(codigo)) {
    alert('El código de estudiante debe contener 9 dígitos numéricos.');
    return false;
  }

  let alMenosUnEquipoSeleccionado = false;
  let equiposFCount = 0;  // Contador para equipos que comienzan con F
  let equiposMCount = 0;

  for (let i = 0; i < equipos.length; i++) {
    if (equipos[i].checked) {
      alMenosUnEquipoSeleccionado = true;

      if (equipos[i].value.startsWith('F')) {
        equiposFCount++;
        if (equiposFCount > 1) {
          alert('No puedes seleccionar más de 1 fuente.');
          return false;
        }
      }

      if (equipos[i].value.startsWith('M')) {
        equiposMCount++;
        if (equiposMCount > 1) {
          alert('No puedes seleccionar más de 1 multimetro.');
          return false;
        }
      }
    }
  }

  if (!alMenosUnEquipoSeleccionado && otros.trim() === '') {
    alert('Debes seleccionar al menos un equipo o especificar algo en la sección de "Otros".');
    return false;
  }




  return true;
}




 // Function to fetch data from consulta.php
 function fetchData() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var data = JSON.parse(xhr.responseText);
      // Update the spans with the counts
      document.getElementById('countPuntas').textContent = data.countPuntas;
      document.getElementById('countFuentes').textContent = data.countFuentes;
      document.getElementById('countMultimetros').textContent = data.countMultimetros;
    }
  };
  xhr.open("GET", "consulta.php", true);
  xhr.send();
}

// Call the function to fetch data
fetchData();


