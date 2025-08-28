/**
 * Genera un formulario dinámico a partir de un objeto de definición.
 * @param {object} definicionFormulario - Objeto que define los campos del formulario.
 * @param {string} tituloFormulario - el titulo del formulario en la tarjeta
 */
function generateForm(definicionFormulario, tituloFormulario) {
  const $contenedor = $(definicionFormulario.contenedor);

  const $htmlCardHeader = `
    <div class="card-header bg-success text-white">
      <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">
          ${tituloFormulario}
        </h1>
      </header>
    </div>
  `

  // Limpiar el contenedor antes de agregar el nuevo formulario
  $contenedor.empty();

  // Crear el contenedor de la tarjeta y el cuerpo
  const $cardBody = $('<div class="card-body">');
  const $form = $('<form>').attr({
    'action': definicionFormulario.action,
    'method': 'POST',
    'autocomplete': 'off'
  });
  $contenedor.append($htmlCardHeader);

  // Iterar sobre las propiedades del objeto de definición para crear los campos
  $.each(definicionFormulario.campos, function(i, propiedadCampo) {
    const $formGroup = $('<div class="mb-3">');
    const $label = $('<label>')
      .attr('for', propiedadCampo.name)
      .addClass('form-label')
      .text(propiedadCampo.label);

    let $inputElement;

    if (propiedadCampo.type === "textarea") {
      $inputElement = $('<textarea>')
        .attr({
          'name': propiedadCampo.name,
          'id': propiedadCampo.name,
          'class': 'form-control',
          'rows': 4
        });
    } else {
      $inputElement = $('<input>')
        .attr({
          'type': propiedadCampo.type,
          'name': propiedadCampo.name,
          'id': propiedadCampo.name,
          'class': 'form-control',
        });
    }

    if (propiedadCampo.required) {
      $inputElement.prop('required', true);
    }
    
    // Asignar el valor si existe
    if (propiedadCampo.value) {
      $inputElement.val(propiedadCampo.value);
    }

    $formGroup.append($label, $inputElement);
    $form.append($formGroup);
  });

  // Separador y botones de acción
  $form.append('<hr/>');
  const $buttonDiv = $('<div class="text-left">');
  const $cancelButton = $('<a>')
    .attr('href', definicionFormulario.cancelarBtn)
    .addClass('btn btn-secondary')
    .text('Cancelar');
  const $submitButton = $('<button>')
    .attr('type', 'submit')
    .addClass('btn btn-primary')
    .text('Guardar');

  $buttonDiv.append($cancelButton, ' ', $submitButton);
  $form.append($buttonDiv);

  $cardBody.append($form);

  $contenedor.append($cardBody);
}