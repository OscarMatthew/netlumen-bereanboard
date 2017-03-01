@extends('layout')

@section('content')
	<label style="margin-right: 15px;"><i class="fa fa-fw fa-filter color-gray"></i></label>
	<select id="filter-field" style="margin-right: 15px;">
		<option value="username"{{ Request::get('f') === 'username' ? ' selected' : '' }}>username</option>
	</select>
	<input type="text" id="filter-value" value="{{ Request::get('v') }}" style="margin-right: 15px;" autofocus onfocus="this.value = this.value">
	<button type="button" class="btn btn-info" id="btn-filter" style="margin-right: 15px;">Filter</button>
	<a href="/users" class="btn btn-purple">All Users</a>

	<table style="width: 100%;">
		<thead>
			<tr>
				<th><a class="link-gray" href="/users?s=username&d={{ $sort === 'username' ? $direction === 'asc' ? 'desc' : 'asc' : 'asc' }}{{ $field ? '&f='.$field.'&v='.$value : '' }}">username</a></th>
				<th><a class="link-gray" href="/users?s=created_at&d={{ $sort === 'created_at' ? $direction === 'asc' ? 'desc' : 'asc' : 'asc' }}{{ $field ? '&f='.$field.'&v='.$value : '' }}">joined</a></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td><a href="/users/{{ $user->id }}">{{ $user->username }}</a></td>
					<td>{{ $user->created_at->diffForHumans() }}</td>
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
