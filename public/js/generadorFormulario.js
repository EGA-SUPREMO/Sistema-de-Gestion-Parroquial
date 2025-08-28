/**
 * Genera un formulario dinámico a partir de un objeto de definición.
 * @param {object} formDefinition - Objeto que define los campos del formulario.
 * @param {string} containerSelector - Selector del contenedor donde se insertará el formulario.
 * @param {string} formAction - La URL a la que se enviará el formulario.
 */
function generateForm(formDefinition, formTitle) {
  const $container = $(formDefinition.container);

  // Limpiar el contenedor antes de agregar el nuevo formulario
  $container.empty();

  // Crear el contenedor de la tarjeta y el cuerpo
  const $cardBody = $('<div class="card-body">');
  const $form = $('<form>').attr({
    'action': formDefinition.action,
    'method': 'POST',
    'autocomplete': 'off'
  });

  // Agregar un título si se proporciona
  if (formTitle) {
    $cardBody.append(`<h2 class="card-title">${formTitle}</h2>`);
  }

  // Iterar sobre las propiedades del objeto de definición para crear los campos
  $.each(formDefinition.fields, function(fieldName, fieldProps) {
    const $formGroup = $('<div class="mb-3">');
    const $label = $('<label>')
      .attr('for', fieldName)
      .addClass('form-label')
      .text(fieldProps.label);

    let $inputElement;

    if (fieldProps.type === "textarea") {
      $inputElement = $('<textarea>')
        .attr({
          'name': fieldName,
          'id': fieldName,
          'class': 'form-control',
          'rows': 4
        });
    } else {
      $inputElement = $('<input>')
        .attr({
          'type': fieldProps.type,
          'name': fieldName,
          'id': fieldName,
          'class': 'form-control',
        });
    }

    if (fieldProps.required) {
      $inputElement.prop('required', true);
    }
    
    // Asignar el valor si existe
    if (fieldProps.value) {
      $inputElement.val(fieldProps.value);
    }

    $formGroup.append($label, $inputElement);
    $form.append($formGroup);
  });

  // Separador y botones de acción
  $form.append('<hr/>');
  const $buttonDiv = $('<div class="text-left">');
  const $cancelButton = $('<a>')
    .attr('href', formDefinition.cancel)
    .addClass('btn btn-secondary')
    .text('Cancelar');
  const $submitButton = $('<button>')
    .attr('type', 'submit')
    .addClass('btn btn-primary')
    .text('Guardar');

  $buttonDiv.append($cancelButton, $submitButton);
  $form.append($buttonDiv);

  $cardBody.append($form);
  $container.append($cardBody);
}