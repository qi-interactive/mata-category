/**
 * Yii validation module.
 *
 * This JavaScript module provides the validation methods for the built-in validators.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
window.matacategory = window.matacategory || {};

matacategory.validation = (function ($) {
    var pub = {
        isEmpty: function (value) {
            return value === null || value === undefined || value == [] || value === '';
        },

        addMessage: function (messages, message, value) {
            messages.push(message.replace(/\{value\}/g, value));
        },

        mandatory: function ($form, value, messages, options) {
            // if (options.skipOnEmpty && pub.isEmpty(value)) {
            //     return;
            // }

            // var items = $form.find('select#' + options.id);
            // if(media.length == 0) {
            //     pub.addMessage(messages, options.message, value);
            // } else if(this.isEmpty(media.val())) {
            //     pub.addMessage(messages, options.message, value);
            // }

            var valid = false;
            if (options.requiredValue === undefined) {
                var isString = typeof value == 'string' || value instanceof String;
                if (options.strict && value !== undefined || !options.strict && !pub.isEmpty(isString ? $.trim(value) : value)) {
                    valid = true;
                }
            } else if (!options.strict && value == options.requiredValue || options.strict && value === options.requiredValue) {
                valid = true;
            }

            if (!valid) {
                pub.addMessage(messages, options.message, value);
            }
        }


        
    };

    return pub;
})(jQuery);
