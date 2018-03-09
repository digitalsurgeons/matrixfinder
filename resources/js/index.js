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
    entries: [],
    activeSections: []
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
      this.activeSections = ['matrixFields']
    },
    populateMatrixBlocks: function(data) {
      this.matrixBlockTypes = data.matrixBlockTypes
      this.activeSections = ['matrixBlockTypes']
    },
    populateEntries: function(data) {
      this.entries = data.entries
      this.activeSections = ['entries']
    },
    isActive: function(section) {
      return this.activeSections.indexOf(section) > -1
    },
    toggleSection: function(section) {
      if (this.isActive(section)) {
        this.makeInactive(section)
      } else {
        this.makeActive(section)
      }
    },
    makeActive: function(section) {
      this.activeSections.push(section)
    },
    makeInactive: function(section) {
      this.activeSections = this.activeSections.filter(
        function(el) { return el != section }
      )
    },
    toggleText: function(section) {
      return this.isActive(section) ? 'Collapse' : 'Expand'
    }
  }
})
