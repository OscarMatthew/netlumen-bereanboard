@extends('layout')

@section('content')
	<label style="margin-right: 15px;"><i class="fa fa-fw fa-filter color-gray"></i></label>
	<select id="filter-field" style="margin-right: 15px;">
		<option value="username"{{ Request::get('f') === 'username' ? ' selected' : '' }}>username</option>
		@can('edit-users')
			<option value="email"{{ Request::get('f') === 'email' ? ' selected' : '' }}>email</option>
			<option value="role"{{ Request::get('f') === 'role' ? ' selected' : '' }}>role</option>
			<option value="active"{{ Request::get('f') === 'active' ? ' selected' : '' }}>active</option>
		@endcan
	</select>
	<input type="text" id="filter-value" value="{{ Request::get('v') }}" style="margin-right: 15px;" autofocus onfocus="this.value = this.value">
	<button type="button" class="btn btn-info" id="btn-filter" style="margin-right: 15px;">Filter</button>
	<a href="/users" class="btn btn-purple">All Users</a>

	<table style="width: 100%;">
		<thead>
			<tr>
				<th><a class="link-gray" href="/users?s=username&d={{ $sort === 'username' ? $direction === 'asc' ? 'desc' : 'asc' : 'asc' }}{{ $field ? '&f='.$field.'&v='.$value : '' }}">username</a></th>
				<th><a class="link-gray" href="/users?s=created_at&d={{ $sort === 'created_at' ? $direction === 'asc' ? 'desc' : 'asc' : 'asc' }}{{ $field ? '&f='.$field.'&v='.$value : '' }}">joined</a></th>
				@can('edit-users')
					<th><a class="link-gray" href="/users?s=email&d={{ $sort === 'email' ? $direction === 'asc' ? 'desc' : 'asc' : 'asc' }}{{ $field ? '&f='.$field.'&v='.$value : '' }}">email</a></th>
					<th><a class="link-gray" href="/users?s=role&d={{ $sort === 'role' ? $direction === 'asc' ? 'desc' : 'asc' : 'asc' }}{{ $field ? '&f='.$field.'&v='.$value : '' }}">role</a></th>
					<th><a class="link-gray" href="/users?s=active&d={{ $sort === 'active' ? $direction === 'asc' ? 'desc' : 'asc' : 'asc' }}{{ $field ? '&f='.$field.'&v='.$value : '' }}">active</a></th>
				@endcan
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{ $user->username }}</td>
					<td>{{ $user->created_at->diffForHumans() }}</td>
					<td>
						@can('send-email')
                                <a href="/email?to={{ $user->email }}">{{ $user->email }}</a>
                        @else
                            {{ $user->email }}
                        @endcan
					</td>
					@can('edit-users')
						<td>
							@if($user->role !== 'admin')
								<form action="/users/{{ $user->id }}" method="post" id="role-form-{{ $user->id }}">
									{{ csrf_field() }}
									{{ method_field('patch') }}
									<select name="role" class="role-select" onchange="document.getElementById('role-form-{{ $user->id }}').submit();" style="margin: 0;">
										<option value="user"{{ $user->role === 'user' ? ' selected' : '' }}>user</option>
										<option value="moderator"{{ $user->role === 'moderator' ? ' selected' : '' }}>moderator</option>
									</select>
								</form>
							@else
								admin
							@endif
						</td>
						<td>
							@if($user->role !== 'admin')
								<form action="/users/{{ $user->id }}" method="post" id="change-active-form-{{ $user->id }}">
									{{ csrf_field() }}
									{{ method_field('patch') }}
									<select class="role-select" name="active" onchange="document.getElementById('change-active-form-{{ $user->id }}').submit();" style="margin: 0;">
										<option value="1"{{ $user->active === 1 ? ' selected' : '' }}>true</option>
										<option value="0"{{ $user->active === 0 ? ' selected' : '' }}>false</option>
									</select>
								</form>
							@else
								true
							@endif
						</td>
					@endcan
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection

@section('javascript')
	<script>

		$('#btn-filter').click(function () {
			window.location = '/users?f=' + $('#filter-field').val() + '&v=' + $('#filter-value').val()
		})

		$('#filter-value').keyup(function (e){
  			if (e.keyCode === 13) {
	      		$('#btn-filter').click()
	   		}
		})

	</script>
@endsection
