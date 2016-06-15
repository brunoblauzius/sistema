
<?= Render::element('Reservas/tabelaListaReservas', array('registros' => $registros, 'urlPDF' => $urlPDF))?>


<script>
    $(document).ready(function() {

        $('#dynamic-table').dataTable({
            "language": {
                "url": web_root + "View/webroot/js/data-tables/json/DataTable-Portuguese-Brasil.json"
            }
        });
              
    });
</script>


