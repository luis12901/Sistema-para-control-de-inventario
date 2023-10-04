/*
   Project: Laboratory Equipment Inventory Management
   Description: JavaScript functions for handling form validation and fetching data from consulta.php.
   Author: Jose Luis Murillo Salas
   Creation Date: August 20, 2023
   Contact: joseluis.murillo2022@hotmail.com
*/


function mostrarMultimetrosDisponibles(checkbox) {
  var checked = checkbox.checked;

  if (checked) {
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                  // Parsear la respuesta como JSON
                  var marcas = JSON.parse(xhr.responseText);
                  mostrarMarcasMultimetros(marcas);
              } else {
                  console.error('Hubo un error al obtener los multímetros disponibles.');
              }
          }
      };
      xhr.open('GET', 'multimetros_disponibles.php', true);
      xhr.send();
  } else {
      document.getElementById('multimetrosDisponibles').innerHTML = '';
  }
}

function mostrarMarcasMultimetros(marcas) {
  var multimetrosDisponiblesDiv = document.getElementById('multimetrosDisponibles');
  multimetrosDisponiblesDiv.innerHTML = '';

  if (marcas.length > 0) {
      var listaMultimetros = document.createElement('ul');
      for (var i = 0; i < marcas.length; i++) {
          var marca = marcas[i];

          var listItem = document.createElement('li');
          listItem.innerHTML = `
              <label for="${marca}">
                  <input type="checkbox" id="${marca}" name="multimetrosSeleccionados[]" value="${marca}">
                  ${marca}
              </label>
          `;
          listaMultimetros.appendChild(listItem);
      }
      multimetrosDisponiblesDiv.appendChild(listaMultimetros);
  } else {
      multimetrosDisponiblesDiv.innerHTML = 'No hay multímetros disponibles.';
  }
}




function mostrarFuentesDisponibles(checkbox) {
  var checked = checkbox.checked;

  if (checked) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Parsear la respuesta como JSON
          var marcas = JSON.parse(xhr.responseText);
          mostrarMarcasFuentes(marcas);
        } else {
          console.error('Hubo un error al obtener las fuentes disponibles.');
        }
      }
    };
    xhr.open('GET', 'fuentes_disponibles.php', true);
    xhr.send();
  } else {
    document.getElementById('fuentesDisponibles').innerHTML = '';
  }
}

function mostrarMarcasFuentes(marcas) {
  var fuentesDisponiblesDiv = document.getElementById('fuentesDisponibles');
  fuentesDisponiblesDiv.innerHTML = '';

  if (marcas.length > 0) {
    var listaFuentes = document.createElement('ul');
    for (var i = 0; i < marcas.length; i++) {
      var marca = marcas[i];

      var listItem = document.createElement('li');
      listItem.innerHTML = `
        <label for="${marca}">
          <input type="checkbox" id="${marca}" name="fuentesSeleccionadas[]" value="${marca}">
          ${marca}
        </label>
      `;
      listaFuentes.appendChild(listItem);
    }
    fuentesDisponiblesDiv.appendChild(listaFuentes);
  } else {
    fuentesDisponiblesDiv.innerHTML = 'No hay fuentes disponibles.';
  }
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

document.getElementById('tuBoton').addEventListener('click', function() {
  buscarEstudiante();
});




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


function llenarCamposDelPrestador(nombre, codigo) {
  document.getElementById('nombre_prestador').value = nombre;
  document.getElementById('codigo_prestador').value = codigo;
}



document.getElementById('tuBoton').addEventListener('click', function() {
  buscarPrestador();
});







function enviarFormulario() {
  if (validarFormulario()) {
   
    document.getElementById('formulario').submit();
  }
}

// Rest of the code...

// Function to get selected source brands
function obtenerMarcasFuentesSeleccionadas() {
  const marcasFuentesSeleccionadas = [];
  const fuentesCheckboxes = document.getElementsByName('fuentesSeleccionadas[]');

  for (let i = 0; i < fuentesCheckboxes.length; i++) {
    const checkbox = fuentesCheckboxes[i];

    if (checkbox.checked) {
      marcasFuentesSeleccionadas.push(checkbox.value);
    }
  }

  return marcasFuentesSeleccionadas;
}



function validarFormulario() {

  document.getElementById('nombre_prestador').value = nombre;
  document.getElementById('codigo_prestador')

  const nombre = document.getElementById('nombre').value.trim();
  const codigo = document.getElementById('codigo').value.trim();
  //const codigo_prestador = document.getElementById('codigo_prestador').value.trim();
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

  /*if(codigo_prestador.length !== 9 || isNaN(codigo_prestador)){
    alert('El código del prestador debe contener 9 dígitos numéricos.');
    return false;
  }*/

  let alMenosUnEquipoSeleccionado = false;

  for (let i = 0; i < equipos.length; i++) {
    if (equipos[i].checked) {
      alMenosUnEquipoSeleccionado = true;
      break;
    }
  }

  if (!alMenosUnEquipoSeleccionado && otros.trim() === '') {
    alert('Debes seleccionar al menos un equipo o especificar algo en la sección de "Otros".');
    return false;
  }

  // Crear un objeto para almacenar la información
  const data = {
    nombre: nombre,
    codigo: codigo,
    equipos: equipos,
    otros: otros,
    comentarios: comentarios
  };

  // Aquí puedes enviar la data a través de una función o AJAX

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