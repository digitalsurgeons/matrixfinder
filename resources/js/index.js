let vue = new Vue({
  el: '#app',
  data: {
    matrixFields: [],
    matrixBlockTypes: [],
    groupedEntries: [],
    activeSections: [],
    activeMatrixField: false,
    activeMatrixBlockType: false,
  },
  delimiters: ['<%', '%>'], mounted: function() {
    this.getMatrixFields()
  },
  methods: {
    getMatrixFields: function() {
      $.ajax({
        url: this.getActionUrl('getMatrixFields'),
        dataType: 'json',
        success: this.populateMatrixFields
      })
    },
    getMatrixBlockTypesByField: function(field) {
      this.activeMatrixField = field
      $.ajax({
        url: this.getActionUrl('getMatrixBlockTypesByField'),
        dataType: 'json',
        data: {
          fieldId: field.id
        },
        success: this.populateMatrixBlocks
      })
    },
    getEntriesUsingMatrixBlockType: function(matrixBlockType) {
      this.activeMatrixBlockType = matrixBlockType
      $.ajax({
        url: this.getActionUrl('getEntriesUsingMatrixBlockType'),
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
      this.groupedEntries = data.groupedEntries
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
    },
    getActionUrl: function(action) {
      return Craft.actionUrl + '/matrixFinder/' + action
    },
  }
})
