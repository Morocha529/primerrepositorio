$(document).ready(function(){
/*****PERSONA********/
  var tb_persona = $("#tb_persona").DataTable({
      /*dom: 'Bfrtpi',*/
      dom: 'Brtp',
      responsive: true,
      ordering: false,
      paging: false,
      searching: false,
      buttons:[{
        text: 'Persona',
        className:'btnpersona',
        /*defaultContent:'div class="btnpersona2"></div>',*/
        action: function ( e, dt, node, config )
             {Modal_Persona();}
            }],

      columnDefs:[
        {
          targets: [0],
          visible: false,
          searchable: false
        },
        { targets: -1,
          data: null,
          /*defaultContent: '<i class="fa fa-trash fa-2x"/>',*/
          defaultContent: '<div class="remove_persona"><span style="font-size:1rem"><i class="fas fa-user-minus" aria-hidden="true"></i></span></div>',
          className: 'dt-center align-middle',
          orderable: false
        },
        ],

  });
/*tb_persona.button(0).nodes().css('background', '#1c2e51');
tb_persona.button(0).nodes().css('color', '#ffffff');*/

  var tb_persona_modal = $("#tb_persona_modal").DataTable({
        dom: 'rt',
        "responsive": true,
        "ordering": false,
        "paging": false,
        "searching": false,
        columnDefs:[
          {
             "targets": [ 0, 4,5 ],
             "visible": true,
             "searchable": false
          },
          { targets: -1,
             data: null,

             defaultContent:'<div class="add_persona"><span style="font-size:1rem"><i class="fas fa-user-plus" aria-hidden="true"></i></span></div>',
             className: 'dt-center',
             orderable: false
          },
        ],
  });

  function Modal_Persona(){
    $("#modal_persona").modal("show");
  };

  $('#modal_persona').on('shown.bs.modal', function () {
    $('#input_BuscarPersona').trigger("focus");
  })

  $('#modal_persona').on('hidden.bs.modal', function () {
    $("#input_BuscarPersona").val("");
    tb_persona_modal.clear();
    tb_persona_modal.draw();
    /*$(this).remove();*/
  });


  $("#modal_persona").on('keyup', '#input_BuscarPersona', function()
      {
        var valorBusqueda=$(this).val();
         if (valorBusqueda.length > 4)
            {obtener_registros(valorBusqueda);}
        else{tb_persona_modal.clear();
            tb_persona_modal.draw();}
      });

  function obtener_registros(persona)
    {
      let resultado=false;
      let perid="";
      let pernombre = "";
      let dptodescripcion = "";
      let perdomicilio = "";
      let perfchnac = "";
      let perdocnro = "";

        $.ajax({
          url : 'controlador/persona.php',
          type : 'POST',
          dataType : 'json',
          data : { persona: persona },
        })
        .done(function(data){
          tb_persona_modal.clear();
          tb_persona_modal.draw();
          $.each(data , function(i, item) {
              //console.log(item + item.perid);
              perid = item.perid;
              pernombre = item.pernombre;
              dptodescripcion = item.dptodescripcion;
              perdomicilio = item.perdomicilio;
              perfchnac = item.perfchnac;
              perdocnro = item.perdocnro;
              {tb_persona_modal.row.add([perid,pernombre,dptodescripcion,perdomicilio,perfchnac,perdocnro]).draw();}
          });
        });
    };

  $("#modal_persona").on("click", ".add_persona", function()
    { /*var currentRow = $(this).closest("tr");*/
      var data = $('#tb_persona_modal').DataTable().row($(this).closest("tr")).data();
      let resultado=false;

      let perid="";
      let pernombre = "";
      let dptodescripcion = "";
      let perdomicilio = "";
      let perfchnac = "";
      let perdocnro = "";

      perid=data[0];
      pernombre=data[1];
      dptocodigo =data[2];
      perdomicilio =data[3];
      perfchnac = data[4];
      perdocnro = data[5];
      /*evito cargar persoans REPETIDAS*/
      tb_persona.rows().data().each(function (value, index)
        {
            if(perid == value[0])
            {resultado = true;}
        });
      if(!resultado)
          {
            tb_persona.row.add([
            perid,
            pernombre,
            dptocodigo,
            perdomicilio,
            perfchnac,
            perdocnro,
            ]).draw();
            $(this).closest("tr").fadeOut("slow", function(){
                tb_persona_modal.row($(this).closest("tr")).remove().draw( false );
            })
          }
    });

    $("#tb_persona").on("click", ".remove_persona", function(){
          $(this).parents('tr').fadeOut("slow", function(){
              tb_persona.row($(this).parents('tr')).remove().draw( false );
          })
    });
  /***PSICOLOGO****/
  var tb_psicologo = $("#tb_psicologo").DataTable({
      dom: 'Brtp',
      responsive: true,
      ordering: false,
      paging: false,
      searching: false,
      columnDefs:
         [{
           targets:0,
           visible: false,
          },
          {
          targets: -1,
          data: null,
          defaultContent:
          '<div class="remove_psico"><span style="font-size: 1rem"><i class="fas fa-user-minus" aria-hidden="true"></i></span></div>',
          //className: 'row-edit dt-center tbody-center',
          orderable: false
           }
        ],
        buttons:[
            { text: '         ',
              className: 'fas fa-user-plus',
              defaultContent:'<div style="width=200px"></div>',
              action: function ( e, dt, node, config )
                {agregar_psico();},
            },
            {
              text: '',
              className: 'fas fa-redo',
              /*action: function ( e, dt, node, config )
                  {deshacer();}*/
            },
          ]
  });

  (function(){
        $('#tb_psicologo').css('display','table');
        tb_psicologo.buttons('.fa-redo').disable();
  })();

  var tb_psicologo_modal = $("#tb_psicologo_modal").DataTable({
    dom: '',
    responsive: true,
    ordering: false,
    paging: false,
    searching: false,
      columnDefs:
      [{
         targets: [0,2,5],
         className: 'dt-body-center'
       },
        {
        targets: [ 0 ],
         visible: false,
         searchable: false
       },
        {
         targets: -1,
         data: null,
         defaultContent:'<div class="agregar_psico_modal" style="text-align:center"><span style="font-size:1rem"><i class="fas fa-user-plus" aria-hidden="true"></i></span></div>',
         //className: 'dt-center agregar_psico_modal',
         orderable: false
       },
      ]
    });
  /*Variables Globales*/
  var fuecodigo_par ='';
  var caunro_par='';
  var cauanio_par='';
  var tcc_codigo='';
  var orgcodigo_par="";
  var c_servidor="";

  function agregar_psico() {
      if (fuecodigo_par.length == 0){
        return false;
      }
      tb_psicologo_modal.clear();
      tb_psicologo_modal.draw();
        $.ajax({
            url : 'Controlador/psicologo-manual.php',
            type : 'POST',
            dataType : 'json',
            data : { fuecodigo: fuecodigo_par},
            })
            .done(function(data){
              $.each(data , function(i, item) {
                let psicodigo = item.psicodigo;
                let psinombre = item.psinombre;
                let acumulado = item.acumulado;
                fuecodigo = item.fuecodigo;
                let cargo = item.cargo;
                let distrito = item.distrito;
                {tb_psicologo_modal.row.add([psicodigo, psinombre, fuecodigo, cargo, distrito, acumulado]).draw();}
              });
          });
        $("#modal_psicologo").modal('show');
    };

  $('#tb_psicologo tbody').on('click', '.psico_antecedente_detalle', function ()
    {
        let tr = $(this).closest('tr');/*obtengo el selector*/
        let row = tb_psicologo.row(tr);/*obtengo la fila con el selector*/
        if ( row.child.isShown())
        {
            row.child.hide();
            tr.removeClass('shown');
        }
      else
       {
          row.child(format(row.data())).show();
          tr.addClass('shown');
        }
    });

  function format (rowData) {
    c_servidor='';
    let psicodigo = rowData[0];
    let resultado=''
    var div = $('<div/>')
          .addClass( 'loading' )
          .text( 'Loading...' );

          $.ajax({
          url: "controlador/psicologo.php",
          method: "POST",
          dataType: "json",
          data:{
            caunro: caunro_par,
            cauanio: cauanio_par,
            tcc_codigo: tcc_codigo_par,
            psicodigo: psicodigo,
            orgcodigo: orgcodigo_par },
          success: function (data) {
            if(data.length === 0)
             {
                div
                    .html('')
                    .removeClass( 'loading' );
              }
              let encabezado='';
              let cuerpo ='';
              encabezado =  '<table id="subtabla_psico" class="table">'+
              '<thead class="thead-light" style="border:2px solid green!important"><tr>'+
                  '<th>'+"Ped Nro"+'</th>'+
                  '<th>Ped Año</th>'+
                  '<th>Fch. Inicio</th>'+
                  '<th>Estado</th>'+
                  '<th>Psicologo</th>'+
              '</tr></thead><tbody>'
              $.each(data , function(i, item) {
                cuerpo = cuerpo +'<tr>'+
                  '<td>'+item.pednro+'</td>'+
                  '<td>'+item.pedanio+'</td>'+
                  '<td>'+item.pedfechaini+'</td>'+
                  '<th>'+item.pedestado+'</th>'+
                  '<td>'+item.psinombre+'</td></tr>'
                });
                cuerpo=cuerpo+'</tbody></table>';
                div
                    .html(encabezado + cuerpo)
                    .removeClass( 'loading' )
                    .addClass('no_bordes');
              }
        });
      return div;
    }

    $('#tb_psicologo tbody').on('click', '.remove_psico', function(){
        let fila = $(this).parents('tr') ;/*obtengo el selector*/
          fila.fadeOut("slow", function(){
            tb_psicologo.row(fila).remove().draw( false );
          })
    })

  $("#tb_psicologo_modal tbody").on("click", ".agregar_psico_modal", function(){
        //let currentRow = $(this).closest("tr");
        let resultado = false;
        let currentRow = $(this).parents('tr');
        let data = tb_psicologo_modal.row(currentRow).data();
        let psicodigo=data[0];
        let psinombre=data[1];
        let fuecodigo =data[2];
        let cargo = data[3];
        let distrito = data[4]
        /*evito cargar persoans REPETIDAS*/
        tb_psicologo.rows().data().each(function (value, index) {
            if(psicodigo == value[0])
            {
              resultado = true;
            }
        });
        if(!resultado)
        {
          tb_psicologo
          .order( [ 0, 'asc' ])
          .row.add([

            psicodigo,
            psinombre,
            fuecodigo,
            cargo,
            distrito,
            '<div></div>'
            ]).draw(false);
            $(this).parents('tr').fadeOut("slow", function(){
                tb_psicologo.row($(this).parents('tr')).remove().draw( false );
              })
        }
        else{
            currentRow.fadeOut("slow", function(){
            currentRow.fadeIn();
          })
      }
  })

    /**Eventos**/
  $('.nav-vertical-pedido a').hover(function(e){
      let hyperlink = this.hash;
      let padre = $(this).parent(hyperlink);
      padre.toggleClass("dos")
  });

  $("#tcc_codigo").select2({
     minimumInputLength:3,
     language: "es",
     placeholder:"Expediente",
     cache: false,
     ajax:
      {
        url: "Controlador/tcc_codigo.php",
        type: "post",
        dataType: 'json',
        delay: 0,
        data: function (params) {
         return {
           searchTerm: params.term // search term
                };
        },
        processResults: function (response) {
          return {
             results: response
          };
        },
        cache: true
      }
  });

    $("#tcc_codigo").next(".select2").find(".select2-selection").focus(function() {
        $("#tcc_codigo").select2("open");
    });

    $("#orgcodigo").select2({
     minimumInputLength:3,
     language: "es",
     //width:"100%",
     placeholder:"Organismo",
     ajax:
     {
        url: "Controlador/orgcodigo.php",
        type: "post",
        dataType: 'json',
        delay: 0,
        data: function (params) {
         return {
           searchTerm: params.term // search term
         };
        },
        processResults: function (response) {
          return {
             results: response
          };
        },
        cache: true
     }
    });


    $('#orgcodigo').on('select2:select', function (e) {
      let data = e.params.data;
      let orgcodigo = data['id'];
      $.ajax({
            type: "post",
            dataType: "json",
            url: "Controlador/select_fuero.php",
            data:{orgcodigo:orgcodigo},
            success: function(result){
                fuecodigo_par = result[0].fuecodigo;
                }
            })
    });

    $("#orgcodigo").next(".select2").find(".select2-selection").focus(function() {
        $("#orgcodigo").select2("open");
    });
    //BOTTON BuscarCausa 03/05/2021*/
    $("#materias").select2({
      multiple:true,
      tags: true,
      theme: "classic",
      minimumInputLength:3,
      ajax:{
         url: "Controlador/materia.php",
         type: "post",
         dataType: 'json',
         delay: 0,
         data: function (params) {
          return {searchTerm: params.term};
         },
         processResults: function (response) {
           return {results: response};
         },
         cache: true
       }
      });

    $("#btnBuscarCausa").click(function(){

      if ($("#caunro").val().length != 0 && $("#cauanio").val().length !=0 &&
      $('#tcc_codigo').select2('data').length != 0 && $('#orgcodigo').select2('data').length != 0)
        {
          caunro_par = $("#caunro").val();
          cauanio_par = $("#cauanio").val();
          tcc_codigo_par = $('#tcc_codigo').select2('data')[0].id;
          orgcodigo_par = $('#orgcodigo').select2('data')[0].id;
          c_servidor="caratula";

            $.ajax({
              url: "Controlador/caratula.php",
              type: "POST",
              dataType: "json",
              data:{
                caunro:caunro_par,
                cauanio:cauanio_par,
                tcc_codigo:tcc_codigo_par,
                orgcodigo:orgcodigo_par,
                //fuecodigo:fuecodigo_par,
                opcion:c_servidor}
              })
              .done(function(data){
                if (data.length != 0)
                {
                  $("#caucaratula").val(data[0].caucaratula);
                }
                else $("#caucaratula").val('');
              })

          c_servidor="materias";
            $('#materias').val(null).trigger('change');

            $.ajax({
              url: "Controlador/caratula.php",
              type: "POST",
              dataType: "json",
              data:{
                caunro:caunro_par,
                cauanio:cauanio_par,
                tcc_codigo:tcc_codigo_par,
                orgcodigo:orgcodigo_par,
                fuecodigo:fuecodigo_par,
                opcion:c_servidor}
              })
              .done(function(data){
                if(data.length != 0)
                {
                  /*22/04/2021*/
                  let sel = '';
                  $.each(data, function(i, item) {
                      sel = $("<option selected></option>").val(data[i].matcodigo).text(data[i].matnombre);
                      $('#materias').append(sel).trigger('change');
                  });
                }
                else {
                   $('#materias').val(null).trigger('change');

                }
              })
          /*Psicologos*/
          c_servidor="antecedente_psico";
          tb_psicologo.clear();
          tb_psicologo.draw();
          $('#tb_psicologo').css('display','table')
              $.ajax({
                    url: "Controlador/psicologo-antecedente.php",
                    method: 'POST',
                    dataType: 'json',
                    data:{
                      caunro:caunro_par,
                      cauanio:cauanio_par,
                      tcc_codigo:tcc_codigo_par,
                      orgcodigo:orgcodigo_par,
                      opcion:c_servidor
                    }, //enviamos opcion 4 para que haga un SELECT
                    //dataSrc:""
                })
                .done(function(data){
                      $.each(data , function(i, item) {
                      var psicodigo = data[i].psicodigo;
                      var psinombre = data[i].psinombre;
                      var fuecodigo = data[i].fuecodigo;
                      var cargo = data[i].cargo;
                      var distrito = data[i].distrito;

                      {tb_psicologo
                        .order( [ 0, 'asc' ])
                        .row.add([
                          psicodigo,
                          psinombre,
                          fuecodigo,
                          cargo,
                          distrito,
                          '<div class="text-center psico_antecedente_detalle"><span style="font-size: 1rem; color: green!important;"><i class="fas fa-plus-circle"></i></span></div>'
                        ]).draw(false);}
                    });

                });
      }
      else/*cierre del if(if)*/
      {
        //fuecodigo='';
        caunro_par = '';
        cauanio_par = '';
        tcc_codigo_par = '';
        elemento_par = '';
        orgcodigo_par = '';
        c_servidor="";
      }

  })
    /*Pedido*/
  $("#pedfechaini").datepicker({
    showOn: "button",
    buttonImage: "imagen/icons8-calendar-48.png",
    buttonImageOnly: true,
    buttonText: "Select date",
    dateFormat: 'dd/mm/yy',
    }).datepicker("setDate", new Date());

    $("label[for='pedestado']").click(function(){
      alert($("#pedestado option:selected" ).text());
    })

    /*15-04-2021  Persona */
    var id = [];
    id[0]=0;
    var tam=0;

      /*20/04/2021
        navigationItems = $('.nav-vertical-pedido a');
      	navigationItems.on('click', function(event){
                event.preventDefault();
                smoothScroll($(this.hash));
            });

        	function smoothScroll(target) {
                $('body, html').animate(
                	{'scrollTop':target.offset().top},
                	900
                );
        	}*/
    $("#btnGrabar").on('click', function(){
      var persona_array_1 = [];
      var psicologo_array_1 = [];
      var materia_array_1= [];

      caunro_1 = $("#caunro").val();
      cauanio_1 = $("#cauanio").val();
      elemento = $('#tcc_codigo').select2('data');
      tcc_codigo_1 = elemento[0].id;
      elemento = $('#orgcodigo').select2('data');
      orgcodigo_1 =elemento[0].id;
      caucaratula_1 = $('#caucaratula').val();

      let iii=0;
      $("#materias").each(function(value) {
          materia_array_1= $(this).val();
          iii++;
          });

      pedfechaini_1 = $('#pedfechaini').val();
      pedestado_1 = $('#pedestado').val();
      pedobservacion_1 = $('#pedobservacion').val();

      iii=0;
      var data = tb_persona.rows().data();
      data.each(function (value, index) {
            if (index = '0' ){
              persona_array_1[iii] = value[index];
            };
            iii++;
      });
        /*04/11/2020*/
      iii=0;
      var data = tb_psicologo.rows().data();
      data.each(function (value, index) {
            if (index = '0' ){
             psicologo_array_1[iii] = value[index].trim();
            };
            iii++;
      })
      //return(false);

      $.ajax({
        type: "POST",
        url: "Controlador/crud.php",
        data:
          {caunro: caunro_1,
          cauanio: cauanio_1,
          tcc_codigo:tcc_codigo_1,
          orgcodigo:orgcodigo_1,
          caucaratula: caucaratula_1,

          pedfechaini:pedfechaini_1,
          pedestado: pedestado_1,
          pedobservacion: pedobservacion_1,
          persona_array: persona_array_1,
          psicologo_array: psicologo_array_1,
          materia_array: materia_array_1,
          fuecodigo:fuecodigo_par},

          success: function(data)
          {/*Clear formulario*/
            $('#materias').val(null).trigger('change');
            $('#tcc_codigo').val(null).trigger('change');
            $('#orgcodigo').val(null).trigger('change');
            $('#pedestado').val(null).trigger('change');
            tb_psicologo
            .clear()
            .draw();
            tb_persona
            .clear()
            .draw();
            $('#form-main')[0].reset();
            /*Claer Variables*/
          },
          error: function(xhr, status, error){alert(xhr+status+error);}
        });

    })



  });
