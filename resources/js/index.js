let $matrixFieldSelect = $('[data-matrix-fields]')
let $blockTypeSelect = $('[data-block-types]')
let $matrixFields = $('[data-matrix-field]')
let $blockTypes = $('[data-block-type]')
let $blockTypeList = $('[data-block-type-list]')
let $entries = $('[data-entries]')

let vue = new Vue({
  el: '#app',
  data: {
    matrixFields: [],
    matrixBlockTypes: [],
    entries: []
  },
  delimiters: ['<%', '%>'], mounted: function() {
    this.getMatrixFields()
  },
  methods: {
    getMatrixFields: function() {
      $.ajax({
        url: '/actions/matrixFinder/getMatrixFields',
        dataType: 'json',
        success: this.populateMatrixFields
      })
    },
    getMatrixBlockTypesByField: function(field) {
      $.ajax({
        url: '/actions/matrixFinder/getMatrixBlockTypesByField',
        dataType: 'json',
        data: {
          fieldId: field.id
        },
        success: this.populateMatrixBlocks
      })
    },
    getEntriesUsingMatrixBlockType: function(matrixBlockType) {
      $.ajax({
        url: '/actions/matrixFinder/getEntriesUsingMatrixBlockType',
        dataType: 'json',
        data: {
          matrixBlockTypeId: matrixBlockType.id
        },
        success: this.populateEntries
      })
    },
    populateMatrixFields: function(data) {
      this.matrixFields = data.matrixFields
    },
    populateMatrixBlocks: function(data) {
      this.matrixBlockTypes = data.matrixBlockTypes
    },
    populateEntries: function(data) {
      this.entries = data.entries
    }
  }
})
