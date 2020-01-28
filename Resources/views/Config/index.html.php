<html>
<head>
    <!-- stylesheets -->
    <style type="text/css">
        @import url(/static/bootstrap/css/bootstrap.css);
        /*@import url(/admin/misc/admin-css?_dc=7cf81c67e93e113ef855ff3643f5fda328f3f6af);*/
        /*@import url(/bundles/pimcoreadmin/css/icons.css?_dc=7cf81c67e93e113ef855ff3643f5fda328f3f6af);*/
        /*@import url(/bundles/pimcoreadmin/js/lib/leaflet/leaflet.css?_dc=7cf81c67e93e113ef855ff3643f5fda328f3f6af);*/
        /*@import url(/bundles/pimcoreadmin/js/lib/leaflet.draw/leaflet.draw.css?_dc=7cf81c67e93e113ef855ff3643f5fda328f3f6af);*/
        @import url(/bundles/pimcoreadmin/js/lib/ext/classic/theme-triton/resources/theme-triton-all.css?_dc=7cf81c67e93e113ef855ff3643f5fda328f3f6af);
        /*@import url(/bundles/pimcoreadmin/js/lib/ext/classic/theme-triton/resources/charts-all.css?_dc=7cf81c67e93e113ef855ff3643f5fda328f3f6af);*/
        /*@import url(/bundles/pimcoreadmin/css/admin.css?_dc=7cf81c67e93e113ef855ff3643f5fda328f3f6af);*/
    </style>
    <script src="/bundles/pimcoreadmin/js/lib/ext/ext-all.js"></script>
    <script>
        Ext.onReady(function () {
            var resultsPanel = Ext.create('Ext.panel.Panel', {
                width: '100%',
                height: 500,
                renderTo: Ext.getBody(),
                layout: {
                    type: 'hbox',       // Arrange child items vertically
                    align: 'stretch',    // Each takes up full width
                    padding: 5
                },
                items: [{
                    xtype: 'form',
                    title: 'Settings',
                    url: '/tag_your_photos_config/save',
                    bodyPadding: 5,
                    items: [{
                        xtype: 'textfield',
                        name: 'applicationKey',
                        fieldLabel: 'Application Key',
                        labelWidth: 140,
                        value: '<?= $this->config['applicationKey'] ?>',
                        allowBlank: false,
                        width: 500
                    },{
                        xtype: 'combobox',
                        name: 'language',
                        fieldLabel: 'Language',
                        labelWidth: 140,
                        queryMode: 'local',
                        value: '<?= $this->config['language'] ?>',
                        store: ['de'],
                        forceSelection: true,
                        width: 220
                    },{
                        xtype: 'checkbox',
                        name : 'labels',
                        fieldLabel: 'Labels',
                        labelWidth: 140,
                        inputValue: 'True',
                        uncheckedValue: 'False',
                        value: '<?= $this->config['labels'] ?>'
                    },{
                        xtype: 'checkbox',
                        name : 'landmarks',
                        fieldLabel: 'Landmarks',
                        labelWidth: 140,
                        inputValue: 'True',
                        uncheckedValue: 'False',
                        value: '<?= $this->config['landmarks'] ?>'
                    },{
                        xtype: 'checkbox',
                        name : 'location',
                        fieldLabel: 'Location',
                        labelWidth: 140,
                        inputValue: 'True',
                        uncheckedValue: 'False',
                        value: '<?= $this->config['location'] ?>'
                    },{
                        xtype: 'sliderfield',
                        name: 'probabilityLabels',
                        fieldLabel: 'Probability Labels',
                        labelWidth: 140,
                        width: 500,
                        value: <?= $this->config['probabilityLabels'] ?>,
                        minValue: 50,
                        maxValue: 100,
                        plugins: new Ext.slider.Tip({
                            getText: function(thumb){
                                return Ext.String.format('{0}%', thumb.value);
                            }
                        })
                    },{
                        xtype: 'sliderfield',
                        name: 'probabilityLandmarks',
                        fieldLabel: 'Probability Landmarks',
                        labelWidth: 140,
                        width: 500,
                        value: <?= $this->config['probabilityLandmarks'] ?>,
                        minValue: 50,
                        maxValue: 100,
                        plugins: new Ext.slider.Tip({
                            getText: function(thumb){
                                return Ext.String.format('{0}%', thumb.value);
                            }
                        })
                    },{
                        xtype: 'textfield',
                        name: 'thumbnailDefinition',
                        fieldLabel: 'Thumbnail Definition',
                        labelWidth: 140,
                        value: '<?= $this->config['thumbnailDefinition'] ?>',
                        width: 500
                    }],
                    buttons: [{
                        text: 'Save',
                        icon: '/bundles/tagyourphotos/js/pimcore/img/ok.svg',
                        handler: function() {
                            var form = this.up('form').getForm();
                            if (form.isValid()) {
                                form.submit({
                                    success: function(form, action) {
                                        Ext.toast({
                                            html: 'Saved successfully!',
                                            title: 'Success',
                                            width: 400,
                                            icon: '/bundles/tagyourphotos/js/pimcore/img/ok.svg',
                                            align: 'br'
                                        });
                                    },
                                    failure: function(form, action) {
                                        Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
                                    }
                                });
                            } else {
                                Ext.Msg.alert( "Error!", "Your form is invalid!" );
                            }
                        }
                    }],
                    flex: 2                                       // Use 1/3 of Container's height (hint to Box layout)
                }]
            });
        });
    </script>
</head>
<body>
<div id="settings"></div>
</body>
</html>

