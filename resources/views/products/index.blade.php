@extends('layouts.app')
@section('tittle', 'Listado de productos')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    @include('layouts.partial.msg')

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" style="background: #6699FF;">
                                <h3 class="card-title text-lg">@yield('tittle')</h3>

                                <a href="{{ route('products.create') }}" class="btn btn-primary float-right" style="background-color: #fff; border-color: blue;">
                                <i class="fas fa-plus nav-icon fa-xl" style="color: blue;"></i></a>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead class="text-primary">
                                        <tr>
                                            <th width="10px">ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->description }}</td>
                                                <td>
                                                    @if ($product->image != null)
                                                        <center>
                                                            <p><img class="img-responsive img-thumbnail"
                                                                    src="{{ ('uploads/products/' . $product->image) }}"
                                                                    style="height: 80px; width: 80px;" alt=""></p>
                                                        </center>
                                                    @elseif ($product->image == null)
                                                    @endif
                                                </td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>
                                                    <center>
                                                        <input data-id="{{ $product->id }}" class="toggle-class" data-width="90px" type="checkbox" data-onstyle="success" data-offstyle="danger"
                                                            data-toggle="toggle" data-on="Active" data-off="Inactive"
                                                            {{ $product->status ? 'checked' : '' }}>
                                                    </center>
                                                </td>
                                                <td>
                                                    <a href="{{route('products.edit', $product->id)}}"
                                                        class="btn btn-sm" tittle="Editar">
                                                        <button style="background: #fff; border; border-color: green; wiht: 40px; height: 30px;">
                                                            <i class="fas fa-pencil-alt fa-lg"></i>
                                                        </button>
                                                    </a>
                                                    <form class="d-inline delete-form"
                                                        action="{{route('products.destroy', $product)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="background: #fff; margin-top: 2px; border; border-color: red; wiht: 40px; height: 30px;"
                                                            tittle="Eliminar">
                                                            <i class="fa-solid fa-trash-arrow-up fa-lg" style="color: #000;"></i>
                                                        </button>
                                                    </form>
                                                    
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                //"buttons": ["excel", "pdf", "print", "colvis"],
                "language": {
                    "sLengthMenu": "show entry menu",
                    "sEmptyTable": "No hay datos disponibles en la tabla",
                    "sInfo": "showing START to END of TOTAL entry",
                    "sInfoEmpty": "showing 0 to 0 of 0 entry",
                    "sSearch": "Search:",
                    "sZeroRecords": "No se encontraron registros coincidentes en la tabla",
                    "sInfoFiltered": "(Filtrado de MAX entradas totales)",
                    "oPaginate": {
                        "sFirst": "First",
                        "sPrevious": "back",
                        "sNext": "following",
                        "sLast": "Last"
                    },
                    /*"buttons": {
                    	"print": "Imprimir",
                    	"colvis": "Visibilidad Columnas"
                    	/*"create": "Nuevo",
                    	"edit": "Cambiar",
                    	"remove": "Borrar",
                    	"copy": "Copiar",
                    	"csv": "fichero CSV",
                    	"excel": "tabla Excel",
                    	"pdf": "documento PDF",
                    	"collection": "Colección",
                    	"upload": "Seleccione fichero...."
                    }*/
                }
            }); //.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        $(document).ready(function() {
            $("example1").DataTable()
        });
        $(function() {
            $('.toggle-class').change(function() {
                var estado = $(this).prop('checked') == true ? 1 : 0;
                var arl_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: 'changeproducturl',
                    data: {
                        'status': estado,
                        'product_id': arl_id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            })
        })
    </script>

    <script>
        $('.delete-form').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Estas seguro?',
                text: "Este registro se eliminara definitivamente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>

    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire(
                'Eliminado',
                'El registro ha sido eliminado exitosamente',
                'success'
            )
        </script>
    @endif
@endpush