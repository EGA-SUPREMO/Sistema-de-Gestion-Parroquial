/**
 * Genera un formulario dinámico a partir de un objeto de definición.
 * @param {object} definicionFormulario - Objeto que define los campos del formulario.
 * @param {string} tituloFormulario - el titulo del formulario en la tarjeta
 */
function generarFormulario(definicionFormulario, tituloFormulario) {
  const $contenedor = $(definicionFormulario.contenedor);
  $contenedor.empty();// Limpiar el contenedor antes de agregar el nuevo formulario

  const $htmlCardHeader = `
    <div class="card-header bg-success text-white">
      <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">
          ${tituloFormulario}
        </h1>
      </header>
    </div>
  `

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
    if (propiedadCampo.label) {
      const $label = $('<label>')
        .attr('for', propiedadCampo.name)
        .addClass('form-label')
        .text(propiedadCampo.label);

      $formGroup.append($label);
    }

    let $inputElement;

   if (propiedadCampo.type === "select") {
      $inputElement = $('<select>')
        .attr({
          'name': propiedadCampo.name,
          'id': propiedadCampo.name,
          'class': 'form-control',
        });

      $.each(propiedadCampo.options, function(j, option) {
        const $optionElement = $('<option>')
          .attr('value', option.value)
          .text(option.text);
        
        if (option.value === propiedadCampo.value) {
          $optionElement.prop('selected', true);
        }
        $inputElement.append($optionElement);
      });
    } else if (propiedadCampo.type === "textarea") {
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

    if (propiedadCampo.placeholder) {
      $inputElement.attr("placeholder", propiedadCampo.placeholder);
    }

    if (propiedadCampo.maxlength) {
        $inputElement.attr("maxlength", propiedadCampo.maxlength);
    }

    if (propiedadCampo.pattern) {
        $inputElement.attr("pattern", propiedadCampo.pattern);
    }

    $formGroup.append($inputElement);
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