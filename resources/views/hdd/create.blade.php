
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevosDatos">
    Nuevo HDD
</button>
<!-- Modal -->
<div class="modal fade" id="nuevosDatos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Nuevo Disco Duro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/hdds') }}" method="post" entype="multipart/form-data">
                    @csrf
                    @include('hdd.form', ['modo'=>'Crear'])
                </form>
            </div>
        </div>
    </div>
</div>