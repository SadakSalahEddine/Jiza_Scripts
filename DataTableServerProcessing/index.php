<?php
include_once 'model/header.php';
include_once 'model/select.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <script src="js/jquery-1.12.3.js" type="text/javascript"></script>
        <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="js/dataTables.bootstrap.min.js" type="text/javascript"></script>

        <script src="js/buttonDatatables/buttons.flash.min.js" type="text/javascript"></script>
        <script src="js/buttonDatatables/buttons.html5.min.js" type="text/javascript"></script>
        <script src="js/buttonDatatables/buttons.print.min.js" type="text/javascript"></script>
        <script src="js/buttonDatatables/dataTables.buttons.min.js" type="text/javascript"></script>
        <script src="js/buttonDatatables/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="js/buttonDatatables/jszip.min.js" type="text/javascript"></script>
        <script src="js/buttonDatatables/pdfmake.min.js" type="text/javascript"></script>
        <script src="js/buttonDatatables/vfs_fonts.js" type="text/javascript"></script>
    </head>
    <body style="width: 90% ; margin: 20px auto">

        <div class="col-xs-3">
            <div class="form-group">
                <h5 class="text-background">Année universitaire  :</h5>
                <select class="form-control search-input-select" data-column ='0'  name="code_cab">
                    <option value="">Choix Année Universitaire</option>
                    <?php listinfos("SELECT cab.code ,concat(etab.designation,' - ',form.designation) FROM t_preinscriptioncab cab INNER JOIN ac_annee ann on ann.code = cab.code_annee inner join ac_etablissement etab on etab.code = ann.code_etablissement INNER JOIN ac_formation form on form.code = ann.code_formation WHERE ann.cloture_academique ='oui' and cab.cloture_academique = 'oui'", $filtre); ?>
                </select>
            </div>
        </div>

        <div class="col-xs-3">
            <div class="form-group">
                <h5 class="text-background">Nature De Demande  :</h5>
                <select class="form-control search-input-select" data-column ='1' name="nature_demande">
                    <option value="">Choix Nature De Demande</option>
                    <?php listinfos("SELECT code ,designation FROM nature_demande ", $filtre2); ?>
                </select>
            </div>
        </div>
        <div style="clear: both"></div>


        <table id="my-grid" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>option</th>
                    <th>code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Etablissement</th>
                    <th>Formation</th>
                    <th>Catégorie</th>
                    <th>Type de Bac</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>option</th>
                    <th>code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Etablissement</th>
                    <th>Formation</th>
                    <th>Catégorie</th>
                    <th>Type de Bac</th>
                    <th>Note</th>
                </tr>
            </tfoot>

        </table>

        <script>


//           search input text 
//             $('.search-input-text').on('keyup click', function () {   // for text boxes
//                var i = $(this).attr('data-column');  // getting column index
//                var v = $(this).val();  // getting search input value
//
//                dataTable.columns(i).search(v).draw();
//            });

//search select option
 $('.search-input-select').on('change', function () {    // for text boxes
                var index = $(this).attr('data-column');  // getting column index
                var value = $(this).val();  // getting search input value
alert(value)
                dataTable.columns(index).search(value).draw();
            });



            var dataTable = $('#my-grid').DataTable({
                "iDisplayLength": 15,
                "lengthMenu": [[10, 15, 25, 50, 100, 200, 90000000], [10, 15, 25, 50, 100, 200, "All"]],
                "order": [[0, "asc"]],
                "columnDefs": [
                    {"orderable": false, "targets": 1}
                ],
                // "stateSave": true,
                "processing": true,
                "language": {
                    "url": "js/jquery.dataTablesFrench.json"
                },
                "serverSide": true,
                "ajax": {
                    url: "List.php", // json datasource
                    type: "get", // type of method  ,GET/POST/DELETE
                    error: function (e) {
                        $("#my-grid").html("error");
                    }
                },
                "dom": '<lfB<t>rip>',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        text: '<span class="save_as_icon save_as_pdf" title="Enregistrer sous Pdf"></span>',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<span class="save_as_icon save_as_csv" title="Enregistrer sous CSV"></span>',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'copy',
                        text: '<span class="save_as_icon save_as_copy" title="Copier"></span>',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<span class="save_as_icon save_as_excel" title="Enregistrer sous excel"></span>',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    }
                ]

            });
        </script>
    </body>
</html>
