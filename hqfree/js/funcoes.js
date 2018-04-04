var JSUrlBase = "";
var fJSLogoff = "";
var fJSExclirRegistro = "";
var fJSAlteraStatus = "";
var fJSVotarHQ = "";
var fJSAddFavoritos = "";
var fJSCheckLoginState = "";

(function($) {

    JSUrlBase = $("#hdnUrlBase").val();

    $("#ajax-login-form").submit(function(e) {
        if ($(this) != undefined && $(this) != "") {
            $.ajax({
                url: JSUrlBase + '/usuario/login',
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(response) {
                    var code = parseInt(response.code);
                    switch (code) {
                        case 0:
                            location.reload();							
                            break;
                        default:
                            $("#titulo_modal").html("Login");
                            $("#msg_modal").html(response.message);
                            $('#myModal').modal('show');                            
                            return false;
                    }
                },
                error: function(e) {
                    console.log(e.responseText);                    
                    return false;
                }
            });
        }

        return false;
    });

    $(".forgot-password").click(function(e) {
        $("#ajax-login-form").toggle();
        $("#ajax-forgot-pass").toggle();        
    });

    $(".change-password").click(function(e) {
        $("#ajax-login-form").toggle();
        $("#ajax-change-pass").toggle();        
    });

    $("#ajax-forgot-pass").submit(function(e) {
        if ($(this) != undefined && $(this) != "") {
            $.ajax({
                url: JSUrlBase + '/reenviar/senha',
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(response) {
                    var code = parseInt(response.code);
                    switch (code) {
                        case 0:
                            $("#titulo_modal").html("Reenvio Senha");
                            $("#msg_modal").html("Foi enviada uma nova senha para e-mail cadastrado");
                            $('#myModal').modal('show');                            
                            return false;
                        default:
                            $("#titulo_modal").html("Reenvio Senha");
                            $("#msg_modal").html(response.message);
                            $('#myModal').modal('show');                            
                            return false;
                    }
                },
                error: function(e) {
                    console.log(e.responseText);                    
                    return false;
                }
            });
        }

        return false;
    });

    $("#ajax-change-pass").submit(function(e) {
        if ($(this) != undefined && $(this) != "") {
            $.ajax({
                url: JSUrlBase + '/alterar/senha',
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(response) {
                    var code = parseInt(response.code);
                    switch (code) {
                        case 0:
                            $("#titulo_modal").html("Alterar Senha");
                            $("#msg_modal").html("Sucesso!");
                            $('#myModal').modal('show');    
                            location.reload();
                            break;
                        default:
                            $("#titulo_modal").html("Atenção");
                            $("#msg_modal").html(response.message);
                            $('#myModal').modal('show');   
                            return false;
                    }
                },
                error: function(e) {
                    console.log(e.responseText);
                    //$("#boxMessageLogin").show();
                    return false;
                }
            });
        }

        return false;
    });
    
    $("#ajax-register-form").submit(function(e) {
        if ($(this) != undefined && $(this) != "") {
            $.ajax({
                url: JSUrlBase + '/usuario/cadastro',
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(response) {
                    var code = parseInt(response.code);
                    switch (code) {
                        case 0:
                            $("#titulo_modal").html("Atenção");
                            $("#msg_modal").html("Usuário Cadastrado com Sucesso!");
                            $('#myModal').modal('show');  
                            $('#myModal').on('hidden.bs.modal', function() {
                               location.reload();
                            });                                                        
                            break;
                        default:
                            $("#titulo_modal").html("Atenção");
                            $("#msg_modal").html(response.message);
                            $('#myModal').modal('show');  
                            return false;
                    }
                },
                error: function(e) {
                    console.log(e.responseText);
                    //$("#boxMessageLogin").show();
                    return false;
                }
            });
        }

        return false;
    });

    $("#btnSair").click(function() {
        fJSLogoff();
    });

    fJSLogoff = function() {
        $.ajax({
            url: JSUrlBase + '/usuario/logoff',
            type: 'PATCH',
            dataType: 'json',
            success: function(response) {
                location.href = JSUrlBase;
            },
            error: function(e) {
                alert(e.responseText);
                location.reload();
                return false;
            }
        });
    }

    moment.defineLocale('pt-br', {
        months: 'Janeiro_Fevereiro_Março_Abril_Maio_Junho_Julho_Agosto_Setembro_Outubro_Novembro_Dezembro'.split('_'),
        monthsShort: 'jan_fev_mar_abr_mai_jun_jul_ago_set_out_nov_dez'.split('_'),
        weekdays: 'domingo_segunda-feira_terça-feira_quarta-feira_quinta-feira_sexta-feira_sábado'.split('_'),
        weekdaysShort: 'dom_seg_ter_qua_qui_sex_sáb'.split('_'),
        weekdaysShort: 'dom_seg_ter_qua_qui_sex_sáb'.split('_'),
        weekdaysMin: 'Dom_2ª_3ª_4ª_5ª_6ª_Sáb'.split('_')
    });

    $('#datetimepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        language: 'pt-BR',
        pickTime: false
    });

    Dropzone.autoDiscover = false;

    if ($("#sortable").length > 0) {
        $("#sortable").sortable();
        $("#sortable").disableSelection();
    }

    if ($(".datatable").length > 0) {
        $('.datatable').dataTable({
            "columnDefs": [{
                'bSortable': false,
                'aTargets': [-1]
            }],
            "language": {
                "lengthMenu": " _MENU_ por página",
                "zeroRecords": "NENHUM REGISTRO DISPONÍVEL",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtro de _MAX_ registros no total)",
                "search": "Filtrar: ",
                "loadingRecords": "Carregando...",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
                "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
            },

            "iDisplayLength": 5,
            "aLengthMenu": [
                [5, 10, 25, 50],
                [5, 10, 25, 50]
            ]
        });
    }

    $("#formcadastro").submit(function(e) {
        if ($(this) != undefined && $(this) != "") {

            var id = $("#hdnId").val();
            var urlfunction = $("#hdnUrlInserir").val();
            var title = "Cadastrar " + $("#hdnTitle").val();

            if (id != undefined && id > 0) {
                title = "Alterar " + $("#hdnTitle").val();
                urlfunction = $("#hdnUrlAlterar").val();
            }

            $.ajax({
                url: JSUrlBase + urlfunction,
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(response) {
                    var code = parseInt(response.code);
                    switch (code) {
                        case 0:
                            $("#titulo_modal").html(title);
                            $("#msg_modal").html("Sucesso!");
                            $('#myModal').modal('show');

                            $('#myModal').on('hidden.bs.modal', function() {
                                if ($("#hdnUrlVisaoGeral").val() != undefined) {
                                    document.location.href = JSUrlBase + $("#hdnUrlVisaoGeral").val() + "/" + response.result.id;                                    
                                }else{
                                    document.location.href = JSUrlBase + $("#hdnUrl").val();
                                }
                            });

                            break;
                        default:
                            $("#titulo_modal").html(title);
                            $("#msg_modal").html(response.message);
                            $('#myModal').modal('show');
                            return false;
                    }
                },
                error: function(e) {
                    console.log(e.responseText);
                    return false;
                }
            });
        }

        return false;
    });

    fJSExclirRegistro = function(url, urlredirect, title) {
        $.ajax({
            url: JSUrlBase + url,
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
                var code = parseInt(response.code);
                if (code > 0) {
                    $("#titulo_modal").html(title);
                    $("#msg_modal").html("Sucesso!");
                    $('#myModal').modal('show');

                    $('#myModal').on('hidden.bs.modal', function() {
                        document.location.href = JSUrlBase + urlredirect;
                    });
                } else {
                    $("#titulo_modal").html(title);
                    $("#msg_modal").html(response.message);
                    $('#myModal').modal('show');
                    return false;
                }
            },
            error: function(e) {
                console.log("Error details: " + e.responseText);
                return false;
            }
        });
    };

    fJSAlteraStatus = function(url, urlredirect) {
        $.ajax({
            url: JSUrlBase + url,
            type: 'PATCH',
            dataType: 'json',
            success: function(response) {
                var code = parseInt(response.code);
                if (code > 0) {
                    document.location.href = JSUrlBase + urlredirect;
                } else {
                    $("#titulo_modal").html("Atenção!");
                    $("#msg_modal").html(response.message);
                    $('#myModal').modal('show');
                    return false;
                }
            },
            error: function(e) {
                console.log("Error details: " + e.responseText);
                return false;
            }
        });
    }

    fJSCarregaRegistro = function(url, urlredirect) {
        $.ajax({
            url: JSUrlBase + url,
            type: 'PATCH',
            dataType: 'json',
            success: function(response) {
                var code = parseInt(response.code);
                if (code > 0) {
                    document.location.href = JSUrlBase + urlredirect;
                } else {
                    $("#titulo_modal").html("Atenção!");
                    $("#msg_modal").html(response.message);
                    $('#myModal').modal('show');
                    return false;
                }
            },
            error: function(e) {
                console.log("Error details: " + e.responseText);
                return false;
            }
        });
    }

    fJSVotarHQ = function(idrevista, nota) {
        var data = {
            'idrevista': idrevista,
            'nota': nota
        };

        $.ajax({
            url: JSUrlBase + '/revista/votar',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                var code = parseInt(response.code);
                if (code == 0) {
                    $("#titulo_modal").html("Racking HQ!");
                    $("#msg_modal").html("Votação concluída!");
                    $('#myModal').modal('show');
                } else {
                    $("#titulo_modal").html("Racking HQ!");
                    $("#msg_modal").html(response.message);
                    $('#myModal').modal('show');
                    return false;
                }
            },
            error: function(e) {
                console.log("Error details: " + e.responseText);
                return false;
            }
        });
    }

    fJSAddFavoritos = function(obj, idrevista) {
        var data = {
            'idrevista': idrevista
        };        
        
        $.ajax({
            url: JSUrlBase + '/add/favoritos',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                var code = parseInt(response.code);
                if (code == 0) {
                    $("#titulo_modal").html("Favoritos");
                    $("#msg_modal").html(response.message);
                    $(obj).children(0).toggleClass('fa fa-heart fa fa-heart-o');
                    $('#myModal').modal('show');
                } else {
                    $("#titulo_modal").html("Favoritos");
                    $("#msg_modal").html(response.message);
                    $(obj).children(0).toggleClass('fa fa-heart-o fa fa-heart');
                    $('#myModal').modal('show');
                    return false;
                }
            },
            error: function(e) {
                console.log("Error details: " + e.responseText);
                return false;
            }
        });
    }
    
    fJSCheckLoginState = function() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                getPerfilFacebook();
            } else {
                FB.login(function(response) {            
                    if (response.status === 'connected') {                
                        getPerfilFacebook();
                    }
                }, {scope: 'public_profile, email', return_scopes: true});
            }
        });

    }

    function getPerfilFacebook(){
        FB.api('/me?fields=name,email', function(response) {
            var data = {
                'username': response.name,     
                'email'   : response.email,
                'idfacebook' : response.id,
                'remember'   : $('#remember').val()                
            };    

            $.ajax({
                url: JSUrlBase + '/login/facebook',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(response) {
                    var code = parseInt(response.code);
                    switch (code) {
                        case 0:                            
                            location.reload();
                            break;
                        default:
                            $("#titulo_modal").html("Atenção");
                            $("#msg_modal").html(response.message);
                            $('#myModal').modal('show');  
                            return false;
                    }
                },
                error: function(e) {
                    console.log("Error details: " + e.responseText);
                    return false;
                }
            });
        });
    }

    function goToByScroll(id) {
        // Reove "link" from the ID
        id = id.replace("link", "");
        // Scroll
        $('html,body').animate({
                scrollTop: $("#scroll_li_" + id).offset().top - 50
            },
            'slow');
    }

    $("#scroll_div > ul > li > a").click(function(e) {
        // Prevent a page reload when a link is pressed
        e.preventDefault();
        // Call the scroll function
        goToByScroll($(this).attr("id"));
    });

    // var options = {
    //     data: [{ name: "Avionet", type: "air", icon: "http://lorempixel.com/100/50/transport/2" },
    //         { name: "Car", type: "ground", icon: "http://lorempixel.com/100/50/transport/8" },
    //         { name: "Motorbike", type: "ground", icon: "http://lorempixel.com/100/50/transport/10" },
    //         { name: "Plain", type: "air", icon: "http://lorempixel.com/100/50/transport/1" },
    //         { name: "Train", type: "ground", icon: "http://lorempixel.com/100/50/transport/6" }
    //     ],


    //     getValue: "name",

    //     template: {
    //         type: "custom",
    //         method: function(value, item) {
    //             return "<img src='" + item.icon + "' /> | " + item.type + " | " + value;
    //         }
    //     }
    // };

    // $("#search_topo").easyAutocomplete(options);

    // if ($('#pagination-demo2').length > 0) {
    //     $('#pagination-demo2').pagination({
    //         dataSource: function(done) {
    //             $.ajax({
    //                 type: 'GET',
    //                 url:  JSUrlBase + '/home/paginacao',
    //                 success: function(response) {
    //                     done(response.result.revistas);
    //                 }
    //             });
    //          },
    //         pageSize: 6,
    //         // ajax: {
    //         //     beforeSend: function() {
    //         //         $('#pagination-demo2').html('Loading data from flickr.com ...');
    //         //     }
    //         // },
    //         callback: function(response, pagination) {            
    //             $('#pagination-demo2').prev().load(JSUrlBase + '/application/views/home/listagem-hq-paginacao.php', { 'baseURL': JSUrlBase, 'revistas' : response });
    //         }
    //     });
    // }

    if( $("#hdnId").val() ) {
        $('.btnBox').removeClass('hidden');
        $("#dZUpload").dropzone({
            url: JSUrlBase + '/upload',
            params: {idRevista:$('#hdnIdRevistaProcesso').val(),idCapitulo:$('#numero_capitulo').val()},
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            init: function() {
                dzClosure = this;
                var id = $("#hdnId").val();  
                // for Dropzone to process the queue (instead of default form behavior):
                document.getElementById("btn_upload").addEventListener("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    dzClosure.processQueue();
                });

                this.on("processing", function(file) {
                    if (id != undefined && id > 0) {                    
                        this.options.url = JSUrlBase + "/upload/alteracao";                                 
                    }                
                });

                //this.on("addedfile", function(file) {});

                //send all the form data along with the files:
                this.on("sendingmultiple", function(data, xhr, formData) {                
                    if (id != undefined && id > 0) {                    
                        formData.append("idRevista", $("#hdnIdRevistaProcesso").val());                    
                        formData.append("idCapitulo", id);                    
                    }
                });
                this.on("successmultiple", function(files, response) {       
                    if (id != undefined && id > 0) {                    
                        $('#listFileUpload').load(JSUrlBase + '/application/views/admin/listagem-arquivos.php', { 'baseURL': JSUrlBase, 'idRevista' : $('#hdnIdRevistaProcesso').val() , 'idCapitulo' : id });                    
                    }else{
                        $('#listFileUpload').load(JSUrlBase + '/application/views/admin/listagem-arquivos.php', { 'baseURL': JSUrlBase, 'idRevistaProcesso' : $('#hdnIdRevistaProcesso').val() , 'idCapitulo' : $('#numero_capitulo').val() });
                    }         
                    
                    $('#modalUpload').modal('hide');
                    this.removeAllFiles();
                });
            }
        });
    }
    else {
        $('#numero_capitulo').blur(function(){
            if( !$('#numero_capitulo').val() ) { return; }

            $('.btnBox').removeClass('hidden');
            $("#dZUpload").dropzone({
                url: JSUrlBase + '/upload',
                params: {idRevista:$('#hdnIdRevistaProcesso').val(),idCapitulo:$('#numero_capitulo').val()},
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                init: function() {
                    dzClosure = this;
                    var id = $("#hdnId").val();  
                    // for Dropzone to process the queue (instead of default form behavior):
                    document.getElementById("btn_upload").addEventListener("click", function(e) {
                        // Make sure that the form isn't actually being sent.
                        e.preventDefault();
                        e.stopPropagation();
                        dzClosure.processQueue();
                    });

                    this.on("processing", function(file) {
                        if (id != undefined && id > 0) {                    
                            this.options.url = JSUrlBase + "/upload/alteracao";                                 
                        }                
                    });

                    //this.on("addedfile", function(file) {});

                    //send all the form data along with the files:
                    this.on("sendingmultiple", function(data, xhr, formData) {                
                        if (id != undefined && id > 0) {                    
                            formData.append("idRevista", $("#hdnIdRevistaProcesso").val());                    
                            formData.append("idCapitulo", id);                    
                        }
                    });
                    this.on("successmultiple", function(files, response) {       
                        if (id != undefined && id > 0) {                    
                            $('#listFileUpload').load(JSUrlBase + '/application/views/admin/listagem-arquivos.php', { 'baseURL': JSUrlBase, 'idRevista' : $('#hdnIdRevistaProcesso').val() , 'idCapitulo' : id });                    
                        }else{
                            $('#listFileUpload').load(JSUrlBase + '/application/views/admin/listagem-arquivos.php', { 'baseURL': JSUrlBase, 'idRevistaProcesso' : $('#hdnIdRevistaProcesso').val() , 'idCapitulo' : $('#numero_capitulo').val() });
                        }         
                        
                        $('#modalUpload').modal('hide');
                        this.removeAllFiles();
                    });
                }
            });
        }) ;
    }

})(jQuery);


