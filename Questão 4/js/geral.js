function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/[àáâãä]/, "a")
        .replace(/[òóôõ]/, "o")
        .replace(/[ìí]/, "i")
        .replace(/[èéê]/, "e")
        .replace(/[ç]/, "c")
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}


/**
 * 'amor'.contains('amo');
 * output: true
 */
if (typeof String.prototype.contains === 'undefined') {
    String.prototype.contains = function (it) {
        return this.indexOf(it) !== -1;
    };
}


/**
 * 'my name {0}'.format('joh')
 * output: my name joh
 */
if (!String.prototype.format) {
    String.prototype.format = function () {
        "use strict";
        var args = arguments;
//        var value = this.urldecode();
        return this.replace(/{(\d+)}/g, function (match, number) {
            return typeof args[number] !== 'undefined' ? args[number] : match;
        });
    };
}

(function ($) {
    var $form_pesquisa_header = $('#form-pesquisa');
    if ($form_pesquisa_header.length > 0) {
        function form_submit(e) {
            e.preventDefault();
            var $form = $(this);
            var q = $form.find('input[name="q"]').val();
//            var cidade = $form.find('input[name="cidade"]').val();
            var cidade_slug = null;
            var estado_uf = null;
            var estado_cidade = null;
            var selectize_header_cidade = $form.find('select[name="cidade"]')[0].selectize;
            if (selectize_header_cidade) {
                var cidade_id = selectize_header_cidade.getValue();
                if (cidade_id) {
                    var cidade = selectize_header_cidade.options[cidade_id];
                    cidade_slug = cidade['slug'];
                    estado_uf = cidade['uf'];
                }
                estado_cidade = estado_uf.toLowerCase() + '-' + cidade_slug;
            }
            if (estado_cidade)
                location.href = (base + '/pesquisa/{0}/{1}').format(estado_cidade, q);
        };

        $form_pesquisa_header.submit(form_submit);

        var $form_pesquisa_home = $('#form-pesquisa-home');
        if ($form_pesquisa_home.length > 0) {
            $form_pesquisa_home.submit(form_submit);
            var $pesquisa_header = $form_pesquisa_header.find('input[name="q"]');
            var $cidade_header = $form_pesquisa_header.find('select[name="cidade"]');
            var $button_header = $form_pesquisa_header.find('button');
            var $cidade_home = $form_pesquisa_home.find('input[name="cidade"]');
            var $button_home = $form_pesquisa_home.find('button');
            var $query_home = $form_pesquisa_home.find('input[name="q"]');
            var $container_home = $form_pesquisa_home.closest('.pesquisa-container');
            var height_container = $container_home.offset().top;

            $query_home.click(function () {
                show_header();
            });
            $cidade_home.click(function () {
                show_header();
            });
//            $form_pesquisa_header.focusout(function () {
//                var scroll = $(window).scrollTop();
//                var dropdown_ative = $cidade_header.closest('div').find('.selectize-input').hasClass('dropdown-active');
//                if (($pesquisa_header.val().length != 0 && scroll < height_container) || scroll >= height_container || dropdown_ative) return;
//                else {
//                    show_home();
//                }
//            });
            $button_home.click(function () {
                $button_header.click();
            });
            $(window).scroll(function () {
                var scroll = $(window).scrollTop();
                if (scroll >= height_container) show_header();
                else if ($pesquisa_header.val().length == 0) show_home();

            });

            var show_header = function () {
                if ($form_pesquisa_header.css('visibility') == 'visible') return;

                $form_pesquisa_home.css('visibility', 'hidden');
//                $container_home.css('visibility', 'hidden');
                $form_pesquisa_header.css('visibility', 'visible').hide().fadeIn("slow");
                $pesquisa_header.focus();
            }
            var show_home = function () {
                if ($form_pesquisa_home.css('visibility') == 'visible') return;
                $form_pesquisa_home.css('visibility', 'visible');
//                if ($container_home.css('visibility') == 'visible') return;
//                $container_home.css('visibility', 'visible');
                $form_pesquisa_header.css('visibility', 'hidden');

                var selectize_cidade_header = $cidade_header[0].selectize;
                $cidade_home.val(selectize_cidade_header.options[selectize_cidade_header.getValue()].nome);
            }
        } else
            $form_pesquisa_header.css('visibility', 'visible');
    }


    var $form_newsletter = $('#form-newsletter');
    if ($form_newsletter.length > 0)
        $form_newsletter.submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: e.target.action,
                data: $form_newsletter.serialize(),
                error: function () {
                    swal("Erro!", "Ops! aconteceu um problema tente novamente.", "error");
                },
                success: function () {
                    $('#myModalNewsletter').modal('hide');
                    $form_newsletter[0].reset();
//                    alert('Salvo com sucesso!');
                    swal("Salvo!", "Seu email foi salvo.", "success");
                }

            });
        });

    $(document).ready(function () {
        $('[data-toggle=popover]').popover();
    });

    $('[data-toggle="btn-favorite"]').click(function () {
        var $this = $(this);
        var active = $this.hasClass('active');

        var id = ($this.attr('aria-id')).toString();
        var favoritos_cookie = $.cookie('favoritos');
        var favoritos = JSON.parse(favoritos_cookie ? favoritos_cookie : '[]');
        var index = favoritos.indexOf(id);
        if (!active) { //add
            if (index === -1)
                favoritos.push(id);
        } else { //delete
            if (index > -1)
                favoritos.splice(index, 1);
        }
        $this.toggleClass('active');
        $.cookie('favoritos', JSON.stringify(favoritos), { expires: 30, path: '/' });

    });
    $('[data-toggle="tr-ativar"]').click(function () {
        var $this = $(this);
        $.ajax({
            method: "GET",
            url: $this.data('action'),
            success: function () {
                var tr = $this.closest('tr');
                tr.css("background-color", "#ffefbf");
                tr.fadeOut(400, function () {
                    tr.remove();
                });
            }
        });
    });

    $('[data-toggle="tr-delete"]').click(function () {
        var $this = $(this);
        swal({
                title: "Tem certeza?",
                text: "Você não será capaz de recuperar esse item!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, delete isto!",
                cancelButtonText: "Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: false },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: "GET",
                        url: $this.data('action'),
                        error: function () {
//                            swal("Deletado!", "Seu arquivo foi excluído com sucesso.", "success");

                        },
                        success: function () {
//                            tr.css("background-color", "#ffefbf");
//                            tr.fadeOut(400, function () {
//                                tr.remove();
//                            });
                            var tr = $this.closest('tr');
                            tr.fadeOut(400, function () {
                                tr.remove();
                            });
                            swal("Deletado!", "Seu arquivo foi excluído com sucesso.", "success");
                        }
                    });

                } else {
                    swal("Cancelado", "Seu documento está seguro!", "error");
                }
            });


//        $.ajax({
//            method: "GET",
//            url: $this.data('action'),
//            success: function () {
//                var tr = $this.closest('tr');
//                tr.css("background-color", "#ffefbf");
//                tr.fadeOut(400, function () {
//                    tr.remove();
//                });
//            }
//        });
    });


    $('[data-toggle="div-delete"]').click(function () {
        var $this = $(this);
        swal({
                title: "Tem certeza?",
                text: "Você não será capaz de recuperar esse item!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, delete isto!",
                cancelButtonText: "Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: false },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: "GET",
                        url: $this.data('action'),
                        error: function () {
                        },
                        success: function () {
                            $this.remove();
                            swal("Deletado!", "Seu arquivo foi excluído com sucesso.", "success");
                        }
                    });

                } else {
                    swal("Cancelado", "Seu documento está seguro!", "error");
                }
            });


//        $.ajax({
//            method: "GET",
//            url: $this.data('action'),
//            success: function () {
//                var tr = $this.closest('tr');
//                tr.css("background-color", "#ffefbf");
//                tr.fadeOut(400, function () {
//                    tr.remove();
//                });
//            }
//        });
    });


})(jQuery);

//function show_header_select_cidade(elemento) {
//    if (elemento == 1)
//        $('.drop-options').show();
//    else
//        $('.drop-optionsIndex').show();
//}
//function headerChangeCidade(cidade) {
//    $('#hd-cidade').val(cidade);
//    $('#hd-cidadeIndex').val(cidade);
//    $('.drop-options').hide();
//    $('.drop-optionsIndex').hide();
//}
