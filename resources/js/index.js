let $matrixFieldSelect = $('[data-matrix-fields]')
let $blockTypeSelect = $('[data-block-types]')
let $matrixFields = $('[data-matrix-field]')
let $blockTypes = $('[data-block-type]')
let $blockTypeList = $('[data-block-type-list]')
let $entries = $('[data-entries]')

$(document).ready(() => {
  $matrixFields.on('click', e => {
    let fieldId = $(e.target).data('value')
    $matrixFieldSelect.text($(e.target).data('label'))
    $blockTypeSelect.text('Choose a block type')
    $.ajax({
      url: 'matrixfinder/getBlockTypesByMatrix',
      dataType: 'json',
      data: {
        fieldId: fieldId
      },
      success: resp => {
        $blockTypeList.empty()
        resp.blockTypes.forEach(blockType => {
          let option = $(`
            <li>
              <a data-block-type data-label="${blockType.name}" data-value="${blockType.id}" data-field-id="${blockType.fieldId}">
                ${blockType.name}
              </a>
            </li>
          `)
          option.on('click', handleSelectBlockType)
          $blockTypeList.append(option)
        })
      }
    })
  })

  $blockTypes.on('click', e => {
    handleSelectBlockType(e)
  })

  function handleSelectBlockType(e) {
    $('.menu').hide()
    $entries.html('<span data-spinner></span>')
    $blockTypeSelect.text($(e.target).data('label'))
    $.ajax({
      url: 'matrixfinder/getEntriesFor',
      dataType: 'json',
      data: {
        blockType: $(e.target).data('value')
      },
      success: resp => {
        $entries.empty()
        if (!resp.entries.length) {
          $entries.append('<li class="error">No entries</li>')
        }
        resp.entries.forEach((entry, index) => {
          $entries.append(`
            <li class="${ index % 2 == 0 ? 'even' : 'odd' }">
              <a href="${entry.editUrl}">
                ${entry.title}
              </a>
            </li>
          `)
        })
      },
      error: error => {
        console.log(error)
      }
    })
  }
})
