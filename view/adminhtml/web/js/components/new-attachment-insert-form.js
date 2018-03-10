define([
    'Magento_Ui/js/form/components/insert-form'
], function (InsertForm) {
    'use strict';

    return InsertForm.extend({
        defaults: {
            modules: {
                attachmentsRows: 'product_form.product_form'
            },
            listens: {
                responseStatus: 'processResponseStatus'
            },
            links: {
                //value: '${ $.provider }:${ $.dataScope}'
                insertData: '${ $.provider }:attachments_product_listing' // FIXME
            }
        },

        initObservable: function() {
            this._super();
            this.observe('insertData');
            return this;
        },

        /**
         * Process response status.
         */
        processResponseStatus: function () {
            if (this.responseStatus()) {
                //this.attachmentsRows.insertData(this.responseData);
                var data = this.insertData();
                data.push(this.responseData.attachment);
                this.insertData(data);
                //this.insertData([this.responseData]);
                this.resetForm();
            }
        }
    });
});
