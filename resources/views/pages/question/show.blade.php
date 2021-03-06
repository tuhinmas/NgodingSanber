@extends('layouts.master')

@section('content')
<section class="content pt-2">
	<div class="container-fluid">
		@if (Auth::check()==false)
		<div class="alert alert-info alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<i class="icon fas fa-info"></i> Login untuk vote dan berkomentar!
		</div>
		@endif
		@if(session('message'))
		<div class="alert alert-success alert-dismissible">{{ session('message')}}</div>
		@endif
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-md-1">
				<div class="row">

					@auth
					@if ($question->user->id != Auth::user()->id)
					<form action="{{ route('vote.pertanyaan',$question->id) }}" method="post" style="width: 100%">
						@csrf
						<input type="text" name="vote" id="upvotepertanyaan" value="upvote" hidden>
						<button type="submit" class="btn btn-vote-width">
							<span class="fas fa-thumbs-up fa-2x" style="color:#38c172"></span>
						</button>
					</form>
					@endif
					@endauth

				</div>
				<div class="row">
					<div class="text-total-vote" style="text-align: center">
						<small> Votes </small><br>
						<strong>{{$question->vote}}</strong>
					</div>
				</div>
				<div class="row">

					@auth
					@if ($question->user->id != Auth::user()->id)
					<form action="{{ route('vote.pertanyaan',$question->id) }}" method="post" style="width: 100%">
						@csrf
						<input type="text" name="vote" id="downvotepertanyaan" value="downvote" hidden>
						<button class="btn btn-vote-width">
							<span class="fas fa-thumbs-down fa-2x" style="color:#dc3545"></span>
						</button>
					</form>
					@endif
					@endauth

				</div>
			</div>
			<div class="col-md-11">
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							<p><a href="/profile/{{$question->user->id}}" class="text-primary">{{$question->user->name}}</a></p>
							<small>{{$question->created_at}}</small>
							<strong>{{$question->judul}}</strong>
						</div>
						<div class="card-tools mt-2">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<pre class="m-0">{!!$question->isi!!}</pre>
						<div class="row">
							<div><strong>Komentar</strong></div>
						</div>
						<div class="row">
							<dd>
								<blockquote class="mb-0 mt-1">

									@foreach ($question->komentarPertanyaan as $commentQuestion)
									<p>
										<small>
											{{ $commentQuestion->komentar }}. <br>
											<a href="/profile/{{$commentQuestion->user->id}}">
											<i>{{ $commentQuestion->user->name }}</i></a>
											<span class="ml-1"> {{ $commentQuestion->created_at }} </span>

											@auth
											@if ($commentQuestion->user->id == Auth::user()->id)
											<a href="#" class="btn-delete ml-2" style="color:#dc3545;" data-id="{{ $commentQuestion->id }}"
												data-toggle="modal" data-target="#modal-delete">delete</a>
											@endif
											@endauth

										</small>
									</p>
									@endforeach

								</blockquote>
							</dd>
						</div>
					</div>

					<div class="card-footer">
						@if (Auth::check())
						<form action="{{ route('komentar.store') }}" method="post">
							@csrf
							<div class="input-group">
								<input type="text" name="user_id" value="{{ Auth::user()->id }}" hidden>
								<input type="text" name="pertanyaan_id" value="{{ $question->id }}" hidden>
								<input type="text" name="komentar" placeholder="Tulis Komentar ..." class="form-control">
								<span class="input-group-append">
									<button type="submit" class="btn btn-primary">Kirim</button>
								</span>
							</div>
						</form>
						@else
						<div class="input-group">
							<input type="text" name="komentar" placeholder="Login untuk berkomentar..." class="form-control">
							<span class="input-group-append">
								<button type="submit" class="btn btn-primary" disabled>Kirim</button>
							</span>
						</div>
						@endif
					</div>

				</div>
			</div>
		</div>
	</div><!-- /.container-fluid -->

	<div class="row mb-4">
		<div class="col-md-10">
			<h3 class="m-1 text-dark">{{ $answers->count() }} Jawaban</h3>
		</div><!-- /.col -->
		<div class="col-md-2">
			<button type="button" class="btn btn-md btn-success col-md-12" data-toggle="modal"
				data-target="#modal-new-answer">
				Tambah Jawaban
			</button> 
		</div>
	</div>

	@foreach ($answers as $answer)
	<div class="row">
		<div class="col-md-1">
			<div class="row">
				@auth
					@if ($answer->user->id != Auth::user()->id)
					<form action="{{ route('vote.jawaban',$answer->id) }}" method="post" style="width: 100%">
						@csrf
						<input type="text" name="vote" id="upvotejawaban" value="upvote" hidden>
						<button type="submit" class="btn btn-vote-width">
							<span class="fas fa-thumbs-up fa-2x" style="color:#38c172"></span>
						</button>
					</form>
					@endif
				@endauth

			</div>
			<div class="row">
				<div class="text-total-vote" style="text-align: center">
					@if (Auth::check())
						<strong class="{{ Auth::user()->id == $question->user->id ? 'ml-4 pl-2' : ''}}">{{$answer->vote}}</strong>
						<form action="/jawaban/{{$answer->id}}" method="POST" style="display: inline;">
						@method('PUT')
						@csrf
					@else
						<strong>{{$answer->vote}}</strong>
						<form style="display: inline;">
					@endif
						<input type="number" name="question" value="{{ $question->id }}" hidden>
						<input type="number" name="user" value="{{ $answer->user_id }}" hidden>
						@if ($answer->jawaban_tepat)
							<input type="number" name="solved" value="0" hidden>
							<input type="number" name="reputasi" value="-15" hidden>
							<input type="number" name="tepat" value="0" hidden>
							<button type="{{ Auth::check() ? 'submit' : 'button'}}" class="btn bg-default m-0 p-1">
								<span class="fas fa-check" style="color:#38c172"></span>
							</button>
						@else
							@auth
							@if (Auth::user()->id == $question->user->id)
							<input type="number" name="solved" value="1" hidden>
							<input type="number" name="reputasi" value="15" hidden>
							<input type="number" name="tepat" value="1" hidden>
							<button type="{{ Auth::check() ? 'submit' : 'button'}}" class="btn bg-default m-0 p-0">
								<span class="fas fa-check"></span>
							</button>
							@endif
							@endauth
						@endif
					</form>
				</div>
			</div>
			<div class="row">

				@auth
					@if ($answer->user->id != Auth::user()->id)
					<form action="{{ route('vote.jawaban',$answer->id) }}" method="post" style="width: 100%">
						@csrf
						<input type="text" name="vote" id="downvotejawaban" value="downvote" hidden>
						<button class="btn btn-vote-width">
							<span class="fas fa-thumbs-down fa-2x" style="color:#dc3545"></span>
						</button>
					</form>
					@endif
				@endauth

			</div>
		</div>
		<div class="col-md-11">

			@if ($answer->jawaban_tepat)
			<div class="card card-outline card-success">
				@else
				<div class="card">
					@endif
					<div class="card-header">
						<div class="card-title">
							<pre class="m-0 p-0">{!!$answer->jawaban!!}</pre>
							<div>
							<a href="/profile/{{$answer->user->id}}" class="text-primary">{{$answer->user->name}}</a>
							</div>
						</div>
						<div class="card-tools mt-2">
							{{-- Kerjakan bagian ini --}}
							<form action="/jawaban/{{$answer->id}}" method="post" style="display: inline">
								@method('delete')
								@csrf
								<button type="submit" class="btn btn-tool" style="color: #dc3545;">
									<i class="fas fa-trash"></i>
								</button>
							</form>
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>

					@if ($answer->komentarJawaban->count() != 0)
					<div class="card-body">
						<dd>
							<blockquote class="mb-0 mt-0">
								@foreach ($answer->komentarJawaban as $commentAnswer)
								<p>
									<form class="m-0" action="" method="post">
										<small>

											{{ $commentAnswer->komentar }}. <br>
											<a href="#"><i>{{ $commentAnswer->user->name }}</i></a>
											<span class="ml-2"> {{ $commentAnswer->created_at }} </span>

											@auth
											@if ($commentAnswer->user->id == Auth::user()->id)
											<a href="#" class="btn-delete ml-2" style="color:#dc3545;" data-id="{{ $commentAnswer->id }}"
												data-toggle="modal" data-target="#modal-delete">delete</a>
											@endif
											@endauth

										</small>
									</form>
								</p>
								@endforeach
							</blockquote>
						</dd>
					</div>
					@endif

					<div class="card-footer">
						@if (Auth::check())
						<form action="{{ route('komentar.store') }}" method="post">
							@csrf
							<div class="input-group">
								<input type="text" name="user_id" value="{{ Auth::user()->id }}" hidden>
								<input type="text" name="jawaban_id" value="{{ $answer->id }}" hidden>
								<input type="text" name="pertanyaan_id" value="{{ $question->id }}" hidden>
								<input type="text" name="komentar" placeholder="Tulis Komentar ..." class="form-control">
								<span class="input-group-append">
									<button type="submit" class="btn btn-primary">Kirim</button>
								</span>
							</div>
						</form>
						@else
						<div class="input-group">
							<input type="text" name="komentar" placeholder="Login untuk berkomentar..." class="form-control">
							<span class="input-group-append">
								<button type="submit" class="btn btn-primary" disabled>Kirim</button>
							</span>
						</div>
						@endif
					</div>

				</div>
			</div>
		</div>
		@endforeach

	</div>
	<!-- /.row (main row) -->
</section>

<div class="modal fade" id="modal-delete" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Hapus Komentar</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Yakin ingin menghapus komentar anda?</p>
			</div>
			<div class="modal-footer justify-content-between">
				<form id="deleteItem" method="post">
					@method('delete')
					@csrf
					<button type="button" class="btn btn-danger mr-3" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-default deleteSuccess">Hapus</button>
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

@include('pages.answer.new', ['pertanyaan_id' => '{{ $question->id }}'])

@endsection


@push('script')
<script>

	$(document).ready(function () {
		var id;
    $('.btn-delete').click(function () {
      id = $(this).data('id')
      $('#deleteItem').attr('action', '/komentar/'+id)
    })
  });
  $('.deleteSuccess').click(function() {
    Toast.fire({
      type: 'success',
      title: 'Pertanyaan Dihapus.'
    })
  });	
</script>
@endpush