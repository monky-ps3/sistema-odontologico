<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4 text-gray-800">Calendario de Citas</h1>
            
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar/editar citas -->
<div class="modal fade" id="citaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="citaForm">
                    <input type="hidden" name="cita_id" id="cita_id">
                    <div class="form-group">
                        <label>Paciente</label>
                        <select name="paciente_id" class="form-control select2" style="width: 100%;" required>
                            <option value="">Buscar paciente...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Odontólogo</label>
                        <select name="odontologo_id" class="form-control" required>
                            <?php foreach ($odontologos as $odontologo): ?>
                            <option value="<?= $odontologo['odontologo_id'] ?>">
                                <?= $odontologo['nombre'] ?> <?= $odontologo['apellido'] ?>
                            </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha y Hora</label>
                        <input type="datetime-local" name="fecha_hora" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Motivo</label>
                        <textarea name="motivo" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btnGuardarCita" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.min.js'></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        initialView: 'timeGridWeek',
        slotMinTime: '08:00:00',
        slotMaxTime: '20:00:00',
        events: '<?= base_url('citas/getEvents') ?>',
        dateClick: function(info) {
            $('#citaModal').modal('show');
            $('input[name="fecha_hora"]').val(info.dateStr.substring(0, 16));
        },
        eventClick: function(info) {
            $('#citaModal').modal('show');
            $('#cita_id').val(info.event.id);
            $('input[name="fecha_hora"]').val(info.event.start.toISOString().substring(0, 16));
            $('textarea[name="motivo"]').val(info.event.extendedProps.motivo);
            $('select[name="odontologo_id"]').val(info.event.extendedProps.odontologo);
            $('.modal-title').text('Editar Cita');
        },
        editable: true,
        eventDrop: function(info) {
            $.post('<?= base_url('citas/update/') ?>' + info.event.id, {
                fecha_hora: info.event.start.toISOString()
            });
        }
    });
    calendar.render();

    // Configurar Select2 para búsqueda de pacientes
    $('.select2').select2({
        ajax: {
            url: '<?= base_url('admin/pacientes/search') ?>',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            }
        },
        minimumInputLength: 2
    });

    $('#btnGuardarCita').click(function() {
        var formData = $('#citaForm').serialize();
        var url = $('#cita_id').val() ? '<?= base_url('citas/update/') ?>' + $('#cita_id').val() : '<?= base_url('citas/store') ?>';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    calendar.refetchEvents();
                    $('#citaModal').modal('hide');
                    $('#citaForm')[0].reset();
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>