$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    
});

$('#title').on('input',function(){var e;e=(e=(e=$(this).val()).replace(/\s+/g,' ')).replace(/_/g,' '),$('#seotitle').val(e.toLowerCase()),$('#seotitle').val($('#seotitle').val().replace(/\W/g,' ')),$('#seotitle').val($('#seotitle').val().replace(/\s+/g,'-'))});
$('#seotitle').on('input',function(){var e;e=(e=(e=$(this).val()).replace(/\s+/g,' ')).replace(/_/g,' '),$(this).val(e.toLowerCase()),$(this).val($(this).val().replace(/\W/g,' ')),$(this).val($(this).val().replace(/\s+/g,'-'))});
