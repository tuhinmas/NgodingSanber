@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Pertanyaan Saya</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Pertanyaan</a></li>
                <li class="breadcrumb-item active">Pertanyaan Saya</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          @auth
          <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info pl-3">
                <div class="inner">
                  <h3>{{ Auth::user()->reputasi }}</h3>
                  <p>Reputasi Saya</p>
                </div>
                <div class="icon">
                  <i class="ion ion-heart"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning pl-3">
                <div class="inner">
                  <h3>{{ $myQuestions }}</h3>
  
                  <p>Pertanyaan Saya</p>
                </div>
                <div class="icon">
                  <i class="ion ion-help"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success pl-3">
                <div class="inner">
                  <h3>{{ $solvedQuestions }}</h3>
                  <p>Terjawab</p>
                </div>
                <div class="icon">
                  <i class="ion ion-checkmark"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>
          @endauth
          <!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Pertanyaan</h3>
    
                    <div class="card-tools">
                      <ul class="pagination pagination-sm float-right">
                        {{ $questions->links() }}
                      </ul>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th style="width: 40px">
                            Votes
                          </th>
                          <th>Judul</th>
                          <th style="width: 150px">Tags</th>
                          <th style="width: 10px">Solved?</th>
                          <th style="width: 10px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($questions as $question)
                        <tr>
                          <td>{{ ++$count }}</td>
                          <td>{{ $votes[$question->id] }}</td>
                          <td>
                            <a href="#"> {{ $question->judul }} </a>
                          </td>
                          <td>
                            @foreach ($question->tag as $tag)
                              <i class="badge bg-primary">{{ $tag }}</i>
                            @endforeach
                          </td>
                          <td>
                            @if ($question->solved)  
                              <i class="icon-solved fas fa-check"></i>
                            @else
                              <i class="icon-not-solved fas fa-times"></i>
                            @endif
                          </td>
                          <td>
                            <a href="#" data-id="{{ $question->id }}" data-toggle="modal" data-target="#modal-delete" class="btndelete btn btn-danger btn-sm">
                              <i class="fas fa-trash"></i>
                            </a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
            </section>
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <div class="modal fade" id="modal-delete" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Hapus Pertanyaan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Anda yakin ingin menghapus pertanyaan?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <form id="deleteItem" method="DELETE">
                @csrf
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.content -->
@endsection

@push('script')
    <script>
      $(document).ready(function () {
        var id;
        $('.btndelete').click(function () {
          id = $(this).data('id')
          $('#deleteItem').attr('action', '/pertanyaan/'+id)
        })
        $('#deleteItem').submit(function (event) {
          event.preventDefault();
        })
      });
    </script>
@endpush