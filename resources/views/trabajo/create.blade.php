<button type="button" class="btn btn-success" data-toggle="modal" data-target="#nuevosTrabajos">
    <i class="fas fa-plus-square"></i> Nuevo
</button>
<!-- Modal -->
<div class="modal fade" id="nuevosTrabajos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel">NUEVO TRABAJO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/trabajosRealizados') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('trabajo.form', ['modo'=>'Guardar','$resul'])

                </form>
            </div>
        </div>
    </div>
</div>