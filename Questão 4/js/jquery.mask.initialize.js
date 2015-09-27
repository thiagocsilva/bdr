(function ($) {


    $(window).ready(function () {
        var masks = {
            mask_date_all: function () {
                mask_datepicker();
                mask_datetimepicker();
                mask_datepicker_empty();
                mask_datetimepicker_empty();
            },
            mask_datepicker: function ($element) {
                $element = $element || $('.mask-date-picker');
                if ($element.length > 0)
                    $element.datetimepicker({
                        pickTime: false,
                        defaultDate: moment(),
                        language: 'pt-BR'
                    });
            },
            mask_datetimepicker: function ($element) {
                $element = $element || $('.mask-date-time-picker');
                if ($element.length > 0)
                    $element.datetimepicker({
                        defaultDate: moment(),
                        language: 'pt-BR'
                    });

            },
            mask_datepicker_empty: function ($element) {
                $element = $element || $('.mask-date-picker-empty');
                if ($element.length > 0)
                    $element.datetimepicker({
                        pickTime: false,
                        language: 'pt-BR'
                    });
            },
            mask_datetimepicker_empty: function ($element) {
                $element = $element || $('.mask-date-time-picker-empty');
                if ($element.length > 0)
                    $element.datetimepicker({
                        language: 'pt-BR'
                    });
            },
            mask_cnpj: function ($element) {
                $element = $element || $('.mask-cnpj');
                $element.mask('00.000.000/0000-00');
            },
            mask_cpf: function ($element) {
                $element = $element || $('.mask-cpf');
                $element.mask('000.000.000-00');
            },
            mask_date_placeholder: function ($element) {
                $element = $element || $('.mask-date-placeholder');
                $element.mask("00/00/0000", {placeholder: "__/__/____"});
            },
            mask_telefone: function ($element) {
                $element = $element || $('.mask-telefone');

                var SPMaskBehavior = function (val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                    },
                    spOptions = {
                        onKeyPress: function (val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };

                $element.mask(SPMaskBehavior, spOptions);
            },
            mask_cep: function ($element) {
                $element = $element || $('.mask-cep');
                $element.mask('00000-000');
            },

            mask_float: function ($element) {
                $element = $element || $('.mask-float');
                $element.mask('000.000.000.000.000,00', {reverse: true});
            },

            unmask_float: function ($component) {
                var value = $component.val();
                value = value.replace('.', '').replace(',', '.');
                $component.val(parseFloat(value));
            },
            unmask_datetimepicker: function ($component, format) {
                if ($component.length > 1) {
                    $.each($component, function (index, value) {
                        unmask_datetimepicker($(value), format);
                    });
                } else {
                    var $datepicker = $component.data("DateTimePicker");
                    format = format | $datepicker.options.pickTime ? 'YYYY-MM-DD H:m' : 'YYYY-MM-DD';
                    var input = $component.find('input');
                    if (input.val() != '') {
                        var date = $datepicker.getDate();
                        if (date != null)
                            date = date.format(format);
                        input.val(date);
                    }
                }
            }
        }
        $.extend(window, masks);


        mask_cnpj();
        mask_cpf();
        mask_telefone();
        mask_cep();
        mask_float();
        mask_date_placeholder();


        //DATE and DATETIME
//        mask_datepicker();
//        mask_datetimepicker();
//        mask_datepicker_empty();
//        mask_datetimepicker_empty();
        mask_date_all();

    });
})(jQuery);
