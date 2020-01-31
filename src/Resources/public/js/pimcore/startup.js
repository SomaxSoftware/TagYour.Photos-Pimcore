/**
 * TagYour.Photos
 *
 * This source file is available under the following license:
 * - GNU General Public License version 3 (GPLv3)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Somax Software UG (haftungsbeschränkt)
 */

pimcore.registerNS("pimcore.plugin.TagYourPhotosBundle");

pimcore.plugin.TagYourPhotosBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.TagYourPhotosBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    postOpenAsset: function (asset, type) {
        if(type == 'image') {
            asset.toolbar.add('->');
            asset.toolbar.add({
                text: t('TagYour.Photos: Autotagging'),
                scale: "medium",
                iconCls: 'autotagging_white',
                handler: function (asset) {
                    asset.tab.mask();
                    Ext.Ajax.request({
                    url: '/tagyourphotos/tagging/autotag',
                        method: 'post',
                        params: {
                        'id': asset.id
                    },
                    success: function (asset, response) {
                        var data = Ext.decode(response.responseText);

                        asset.tab.unmask();
                        if (data.statusCode==1) {
                            asset.tabbar.setActiveItem(asset.tagAssignment.getLayout());
                            asset.tagAssignment.grid.store.reload();
                            asset.tagAssignment.layout.items.get(1).items.get(0).store.reload();

                            pimcore.helpers.showNotification(t("TagYour.Photos: Autotagging"), t("Autotagging successful"), "success");
                        } else if (data.statusCode==9001){
                            pimcore.helpers.showNotification(t("TagYour.Photos: Autotagging"), t("Autotagging failed - wrong applicationkey"), "error");
                        } else if (data.statusCode==9002){
                            pimcore.helpers.showNotification(t("TagYour.Photos: Autotagging"), t("Autotagging failed - no available imagecount"), "error");
                        } else {
                            pimcore.helpers.showNotification(t("TagYour.Photos: Autotagging"), t("Autotagging failed"), "error");
                        }
                    }.bind(this, asset)

                });
                }.bind(this, asset)
            });
            pimcore.layout.refresh();
        }
    }

});

var TagYourPhotosBundle = new pimcore.plugin.TagYourPhotosBundle();
