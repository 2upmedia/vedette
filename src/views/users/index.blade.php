@extends(Config::get('vedette::vedette_views.layout'))

{{-- Include Page CSS --}}
@section('css')
@stop

{{-- Include Page JS --}}
@section('js')
@stop

{{-- Browser Title --}}
@section('page_title')
	- {{ trans('lingos::auth.sign_in') }}
@stop

{{-- Title --}}
@section('title')
	<i class="fa fa-sign-in fa-lg fa-fw"></i>
	{{ trans('lingos::auth.sign_in') }}
@stop

{{-- Content --}}
@section('content')

	<div class="page-header">
		<h3>
			<div class="pull-right">
				<a href="{{ URL::to('admin/users/create') }}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<table id="users" class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.username') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.email') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.roles') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.activated') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.passwordphrase') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.created_at') }}}</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
			<tr>
				<td>
					{{ $user->username }}
				</td>
				<td>
					{{ $user->email }}
				</td>
				<td>
					@foreach($user->roles as $role)
						{{ $role->name }}
					@endforeach
				</td>
				<td>
					{{ $user->confirmed }}
				</td>
				<td>
					{{ $user->passwordphrase->phrase }}
				</td>
				<td>
					{{ $user->created_at }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')
@stop