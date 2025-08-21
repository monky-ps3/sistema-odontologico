<?php echo $this->extend('Layouts/dashboard') ?>
<?php echo $this->section('header') ?>
<h5 class="mb-4">
    <?= $title ?> - Odontólogo:
    <span class="text-primary">Dr. <?= esc($odontologo->nombre . ' ' . $odontologo->apellido) ?></span>
</h5>

<?php echo $this->endSection() ?>
<?php echo $this->section('contenido') ?>
<?php echo view('partials/_form-error') ?>
<form action="<?= base_url('citas/create') ?>" method="post">
    <?= csrf_field() ?>
    <input type="text" name="odontologo_id"  id="odontologo_id" value="<?= esc($odontologo->id) ?>">
    <div class="mb-3">

        <label>Paciente</label>
        <select name="paciente_id" class="form-control">
            <option value="">Seleccione...</option>
            <?php foreach ($pacientes as $p): ?>
                <option value="<?= $p->id ?>" <?= old('paciente_id') == $p->id ? 'selected' : '' ?>>
                    <?= esc($p->nombre . ' ' . $p->apellido) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <!-- Fecha -->
    <input type="date" name="fecha" id="fecha" required value="<?= old('fecha') ?>">

    <!-- Hora: inicialmente vacío -->
    <select name="hora" id="hora" required>
        <option value="">Selecciona una fecha primero</option>
    </select>

    <div class="mb-3">
        <label>Motivo</label>
        <textarea name="motivo" class="form-control"><?= old('motivo') ?></textarea>
    </div>

    <button class="btn btn-primary" type="submit">Guardar cita</button>
</form>




<script>
    document.getElementById('fecha').addEventListener('change', function() {
        const fecha = this.value;
        const odontologo_id = document.getElementById('odontologo_id').value;
        const horaSelect = document.getElementById('hora');

        if (!fecha) {
            horaSelect.innerHTML = '<option value="">Selecciona una fecha primero</option>';
            return;
        }

        fetch(`<?= base_url('citas/horariosdisponibles') ?>?fecha=${fecha}&odontologo_id=${odontologo_id}`)
            .then(response => response.json())
            .then(data => {
                horaSelect.innerHTML = '';

                if (data.length === 0) {
                    horaSelect.innerHTML = '<option value="">No hay horarios disponibles</option>';
                    return;
                }

                horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';
                data.forEach(hora => {
                    // usamos hora.valor como value y hora.texto para mostrar
                    horaSelect.innerHTML += `<option value="${hora.valor}">${hora.texto}</option>`;
                });
            })
            .catch(() => {
                horaSelect.innerHTML = '<option value="">Error al cargar horarios</option>';
            });
    });
</script>
<?php echo $this->endSection() ?>